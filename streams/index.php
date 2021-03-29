<?php

/* included PHP stream wrappers */
// print_r(stream_get_wrappers());

/* reading normal files */
// $small = file_get_contents(__DIR__ . '\streams.md');
// $small = file_get_contents('file://' . __DIR__ . '\streams.md');
// echo $small;

/* reading large files, errors */
// $large = file_get_contents(__DIR__ . '\rockyou.txt');
// echo $large;

/* using file handles */
// $file_pointer = fopen(__DIR__ . '\rockyou.txt', 'r');

/* line by line */
// echo fgets($file_pointer);
// echo fgets($file_pointer);

/* file handel tracks current cursor */
// echo ftell($file_pointer);

/* piping streams */
// $source = fopen(__DIR__ . '\rockyou.txt', 'r');
// $dest = fopen(__DIR__ . '\copy_rockyou.txt', 'c');
// stream_copy_to_stream($source, $dest);

/* stream filters */
// print_r(stream_get_filters());

$handler = fopen(__DIR__ . '\rockyou.txt', 'r');
// stream_filter_append($handler, 'string.toupper');
//  for ($i = 0; $i < 100; $i++) {
//    echo fgets($handler);
//  }

/* using filter directly */
// echo file_get_contents('php://filter/read=string.toupper/resource=streams.md', 'r');

/* custom filter */
class CustomFilter extends PHP_User_Filter
{
  public $stream;

  /*
    This is the main function that does the data conversion

    $in: A pointer to a brigade (group of buckets) containing the data to be filtered
    $out: A pointer to a brigade (group of buckets) for storing the converted data
    $consumed: A counter passed by reference that needs to be incremented by the length of the converted data
    $closing: A flag that is set to TRUE if you’re in the last cycle and the stream is about to close
  */
  public function filter($in, $out, &$consumed, $closing)
  {
    $consumed = 0;

    // stream_bucket_make_writeable returns editable bucket object from $in
    while ($bucket = stream_bucket_make_writeable($in)) {
      $in_data = $bucket->data;

      // filter data
      $pattern = "/[0-9]{1,9}/m";
      $out_data = preg_replace($pattern, '@@@@@@REDACTED@@@@@', $in_data);

      // put data in bucket, sets new bucket length, adds to consumed data length
      $consumed += strlen($out_data);
      $bucket->data = $out_data;
      $bucket->datalen = strlen($out_data);

      // sends bucket to out brigade
      stream_bucket_append($out, $bucket);
    }

    // inserts termination
    if ($closing) {
      $bucket = stream_bucket_new($this->stream, "\n");
      stream_bucket_append($out, $bucket);
    }

    // This PHP constant indicates that the filter returned a value in $out
    return PSFS_PASS_ON;
  }
}

stream_filter_register('myFilter', 'CustomFilter');
stream_filter_append($handler, "myFilter");
for ($i = 0; $i < 100; $i++) {
  echo fgets($handler);
}
fclose($handler);


class CallbackUrl
{
  const WRAPPER_NAME = 'callback';

  public $context;
  private $_cb;
  private $_eof = false;

  private static $_isRegistered = false;

  public static function getContext($cb)
  {
    if (!self::$_isRegistered) {
      stream_wrapper_register(self::WRAPPER_NAME, get_class());
      self::$_isRegistered = true;
    }
    if (!is_callable($cb)) return false;
    return stream_context_create(array(self::WRAPPER_NAME => array('cb' => $cb)));
  }

  public function stream_open($path, $mode, $options, &$opened_path)
  {
    if (!preg_match('/^r[bt]?$/', $mode) || !$this->context) return false;
    $opt = stream_context_get_options($this->context);
    if (
      !is_array($opt[self::WRAPPER_NAME]) ||
      !isset($opt[self::WRAPPER_NAME]['cb']) ||
      !is_callable($opt[self::WRAPPER_NAME]['cb'])
    ) return false;
    $this->_cb = $opt[self::WRAPPER_NAME]['cb'];
    return true;
  }

  public function stream_read($count)
  {
    if ($this->_eof || !$count) return '';
    if (($string = call_user_func($this->_cb, $count)) == '') $this->_eof = true;
    return $string;
  }

  public function stream_eof()
  {
    return $this->_eof;
  }
}

// Here is the class that will contain the text object that need to be instanciated
class Text
{
  private $_string;
  public function __construct($string)
  {
    $this->$_string = $string;
  }
  public function read($count)
  {
    return fread($this->$_string, $count);
  }
}


// We create a new Text object and open it using our brand-new wrapper CallbackUrl eventually will loop until the file ends
// $text = new Text(fopen(__DIR__ . '\streams.md', 'r'));
// $handle = fopen('callback://', 'r', false, CallbackUrl::getContext(array($text, 'read')));
// while (($row = fread($handle, 128)) != '') {
//   print $row;
// }

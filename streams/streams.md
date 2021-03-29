# PHP Streams

* A stream is a resource object that can be read or written in a linear fashion
* A wrapper is code that tells streams how to handel specific protocols and encodings

PHP has a number of built in wrappers, you can also import new ones from extensions or make your own and register it with `stream_wrapper_register`.

Why use streams? It allows you to work with the data as they come in, no need to wait for the whole file to load (in memory)

```php
/* included PHP stream wrappers */
print_r(stream_get_wrappers());

/* reading normal files */
// $small = file_get_contents(__DIR__ . '\streams.md');
$small = file_get_contents('file://' . __DIR__ . '\streams.md');
echo $small;

/* reading large files, errors */
$large = file_get_contents(__DIR__ . '\rockyou.txt');
echo $large;
```

A stream is referenced as scheme://target, where scheme refers to the wrapper and target refers to the location.

The file wrapper is the default which is why you can read files without specifying file://

```php
// for others you must specify
echo file_get_contents('https://google.ca');

/* php IO streams */
$stdout = fopen('php://stdout', 'w'); // STDOUT
fwrite($stdout, 'Hello World');

$stderr = fopen('php://stderr', 'w'); // STDERR
fwrite($stderr, 'ERROR');

$stdin = fopen('php://stdin', 'r'); // STDIN
$line = trim(fgets($stdin));
echo $line;

$someFile = fopen(__DIR__ . '\test.txt', 'a');
stream_copy_to_stream($stdin, $someFile);

// looping all lines
if ($handle) {
  while (($buffer = fgets($handle)) !== false) {
    // work with line
    echo $buffer;
  }

  if (!feof($handle)) echo "Error: unexpected fgets() fail\n";
  fclose($handle);
}
```

---

## Filters

Streams can be piped through filters to modify data as they are parsed.

For functions that do not return a stream to attach a filter, you can use filters directly

```php
/* included PHP stream filters */
print_r(stream_get_filters());

$handler = fopen(__DIR__ . '\rockyou.txt', 'r');
// appends filter to handler stream
stream_filter_append($handler, 'string.toupper');
for ($i = 0; $i < 100; $i++) {
  echo fgets($handler);
}

/* using filter directly */
echo file_get_contents('php://filter/read=string.toupper/resource=streams.md', 'r');
```

### Custom filters

```php
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
      $out_data = preg_replace($pattern, '@@@@@@@@@@@@@@@@@@@@', $in_data);

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
```

Need to register before filters can be used

```php
stream_filter_register('myFilter', 'CustomFilter');

$handler = fopen(__DIR__ . '\rockyou.txt', 'r');
stream_filter_append($handler, "myFilter");
for ($i = 0; $i < 100; $i++) {
  echo fgets($handler);
}
```

---

## Wrappers

```php
class CallbackUrl {
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
        if (!is_array($opt[self::WRAPPER_NAME]) ||
            !isset($opt[self::WRAPPER_NAME]['cb']) ||
            !is_callable($opt[self::WRAPPER_NAME]['cb'])) return false;
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
class Text {
    private $_string;
    public function __construct($string)
    {
        $this->$_string = $string;
    }
    public function read($count) {
        return fread($this->$_string, $count);
    }
}


// We create a new Text object and open it using our brand-new wrapper CallbackUrl eventually will loop until the file ends
$text = new Text(fopen('/etc/services', 'r'));
$handle = fopen('callback://', 'r', false, CallbackUrl::getContext(array($text, 'read')));
while(($row = fread($handle, 128)) != '') {
    print $row;
}

```

# Syntax

```php
// string concat
echo 'abc'.'efg';

// prints \n with <br>
echo nl2br("abc\n123");

echo isset($var);
unset($var);
unset($arr[1]);

$arr = array('foo' => 'bar');
$obj = new StdClass;
$obj->foo = 'bar';

foreach($arr as $ele) {
  echo $ele;
}

print_r($arr);
var_dump($arr);

// no function hoisting
function dud ($ele) { echo $ele }
array_walk($arr, dud);

// orders elements but not indices
asort($arr);

// import
require 'path.php';
require_once 'path.php';

// same as require but handles errors in imported php
include 'path.php';

// error suppression with @
@echo 1/0;

// script termination
exit('msg') or exit;
die('msg') or die;

// dir
$files = scandir('path');
echo is_dir('path');
$directory = dir('path');
$directory->rewind();
// while directory has files (referring to filename)
while ($file = $directory->read()) {
  echo $file
}

// file exists
if (!file_exist('path.txt')) die('no file');

// open file in append mode
$fRef = fopen('path.txt', 'a');
fwrite($fRef, "data\n");
fclose($fRef);

// file open with error suppression
$fRef = @fopen('path.txt', 'a')
echo $fRef ? 'open' : 'error';

// reading file to array (does not need fopen)
$fArr = file('path.txt');

// string.split
$split =  preg_split('/,/', "abc,def,ghi,jkl");

// regex
preg_match('/^fo{2,}$/', 'foo', $matchArr); // match first
preg_match_all('/^b(ar)?$/', 'bararar', $matchArr); // match all
$newStr = preg_replace('/foo/', 'bar', 'foo foo foo');

// parsing cli input
$input = trim(fgets(STDIN));
fprintf(STDOUT, $input);
exit;

var_dump($argv); // arg vector $argv[0] => script name
```

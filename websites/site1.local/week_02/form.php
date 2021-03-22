<?php
    if(isset($_GET['username'])) {
        $username = strip_tags($_GET['username']);

        if($username !== $_GET['username']) {
            die("Danger script injection");
        } else {
            echo "hi " . $_GET['username'];
            die();
        }
    }

    $s = "hello world";
    echo "$s <br>";
    echo '$s <br>';
    echo '"you owe me $fifty"';

    /*
        functions are not case sensitive
        variables/constants are case sensitive

        Variable expansion
        " evaluates the values
        ' outputs as is

        " and $ needs to be escaped inside "\""
    */

    $x = "hello";
    $$x = "world";
    echo "$x ${$x}";

    var_dump($x);
    echo gettype($x);
    echo is_string($x);

    // constants
    define('CONSTANT', 12);
    echo CONSTANT;
    echo defined('CONSTANT');
    const X = 'a';
    echo defined('X');
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="username">
    <input type="submit" value="enter">
</form>

<!--
    checkboxes
    radio buttons
    sql injection checks

    get: visible in URL, not secure, cached heavily, max 2048, must be URL safe
    post: not visible in URL, not secure (unless https), not cached, no size limit, binary data
-->
<?php

echo '<hr>';
echo '<br>';
date_default_timezone_set("America/Vancouver");
$cur_datetime = date('D M d Y H:i:s');
echo $cur_datetime;
echo '<br>';
$date = (int)date('j');
echo gettype($date);
echo '<br>';

$arr = array(1, 2, 3);
$arr[] = 4;
$arr[] = 5;
$arr[] = 6;

echo $arr[2];
echo '<br>';
echo count($arr);
echo '<hr>';

?>
<form action="./test.php" method="post">
    <input type="text" name="test">
    <input type="submit">
</form>

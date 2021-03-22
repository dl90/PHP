<?php

echo "Before deleting:<br>";
$countries[] = "Canada";
$countries[] = "Fiji";
$countries[] = "England";
$number_of_countries = count($countries);
for ($index = 0; $index < $number_of_countries; $index++) {
    echo "$countries[$index] <br>";
}

unset($countries[1]);
echo "<hr>After deleting:<br>";
$number_of_countries = count($countries);
for ($index = 0; $index < $number_of_countries; $index++) {
    echo "$countries[$index] <br>";
}

// makes a copy and does not change original array
foreach ($countries as $c) {
    echo $c . '<br>';
}

// getting all $_POST data
foreach ($_POST as $formData) {
    echo "$formData<br>";
}

print_r($countries);
echo '<br>';
var_dump($countries);

?>

<hr>

<form enctype="multipart/form-data" action="./index.php" method="post">
    Send this file: <input type="file" name="userfile">
    <input type="submit" value="Send File">
</form>

<hr>

<?php

//move_uploaded_file(
//    $_FILES['userfile']['tmp_name'],
//    "./received_file_dir/" . $_FILES['userfile'] ['name']
//);


if (!file_exists('./uploads/myfile.txt')) die('no file');

$filehandle = fopen("./uploads/myfile.txt", "a");
if ($filehandle =  @fopen("./uploads/myfile.txt", "a+")) {
    echo "File successfully opened for reading/writing/creating/appending";
} else {
    echo "Error opening the file for reading/writing/creating/appending";
}

//fwrite($filehandle, "testing\n");
fclose($filehandle);

$split =  preg_split('/,/', "abc,def,ghi,jkl");
foreach ($split as $item) {
    echo "$item<br>";
}

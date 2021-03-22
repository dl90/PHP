<?php
if (!file_exists('habits.txt')) die('no file');
$fileContent = file('habits.txt');

$db = mysqli_connect('localhost', 'php', 'php') or die(mysqli_connect_error());

$dropDB = 'DROP DATABASE IF EXISTS phplab;';
mysqli_query($db, $dropDB) or die(mysqli_error($db));

$createDB = 'CREATE DATABASE phplab;';
mysqli_query($db, $createDB) or die(mysqli_error($db));
mysqli_select_db($db, 'phplab') or die(mysqli_error($db));

$createTable = 'CREATE TABLE habits (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  habit VARCHAR(255) NOT NULL
);';
mysqli_query($db, $createTable) or die(mysqli_error($db));

foreach($fileContent as $line) {
  $val = trim($line);
  echo $val.'\n';
  mysqli_query($db, "INSERT INTO habits (`habit`) VALUES ('$val');") or die(mysqli_error($db));
}

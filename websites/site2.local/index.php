<?php

  echo 'hi from php site 2 <br>';

  /*
  mysqli db

  $db = mysqli_connect('localhost', 'root', 'pw') or die(mysqli_connect_error());
  mysqli_select_db($db, 'world') or die(mysqli_error($db));

  $result = mysqli_query($db, "SELECT * FROM city WHERE city.Name = 'Vancouver'") or die(mysqli_error($db));

  while($record = mysqli_fetch_assoc($result)) {
    echo $record['Name'] . ' ' . $record['CountryCode'] . ' ' . $record['Population'] . '<br>';
  }
  */

  if(is_callable('curl_init')) echo 'can curl';

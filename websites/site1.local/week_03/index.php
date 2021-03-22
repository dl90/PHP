<?php
    $PHONE_ERROR_MESSAGE = null;
    $LICENSE_ERROR_MESSAGE = null;
    $ADDRESS_ERROR_MESSAGE = null;
    $BIRTHDAY_ERROR_MESSAGE = null;
    $SIN_ERROR_MESSAGE = null;

    $CORRECT = '&#9989 Thank you, you entered: ';
    $INCORRECT = '&#10060';

    if (isset($_GET['phoneNumber'])) {
        $PhoneNumRgx = '/^('
            .'(\d{3}( *|-)?\d{4})|'
            .'(\d{3}( *|-)?\d{3}( *|-)?\d{4})|'
            .'([(]{1}\d{3}[)]{1}\d{3}( *|-)?\d{4})'
            .')$/';
        $PHONE_ERROR_MESSAGE = preg_match($PhoneNumRgx, $_GET['phoneNumber'])
            ? $CORRECT.$_GET['phoneNumber']
            : $INCORRECT;
    }

    if (isset($_GET['licensePlate'])) {
        $LicensePlateRgx = '/^([A-Z]{3}[ ]?[0-9]{3}|[0-9]{3}[ ]?[A-Z]{3})$/';
        $LICENSE_ERROR_MESSAGE = preg_match($LicensePlateRgx, $_GET['licensePlate'])
            ? $CORRECT.$_GET['licensePlate']
            : $INCORRECT;
    }

    if (isset($_GET['address'])) {
        $AddressRgx = '/^(\d{3,5}( [A-Z][a-z]*)+ Street)$/';
        $ADDRESS_ERROR_MESSAGE = preg_match($AddressRgx, $_GET['address'])
            ? $CORRECT.$_GET['address']
            : $INCORRECT;
    }

    if (isset($_GET['birthday'])) {
        $months = 'JAN|FEB|MAR|APR|MAY|JUN|JLY|AUG|SEP|OCT|NOV|DEC';
        $BirthdayRgx = "/^$months-([0-2][1-9]|3[01])-(1[0-9]{3}|20[0-1][0-9]|2020)$/i";
        $BIRTHDAY_ERROR_MESSAGE = preg_match($BirthdayRgx, $_GET['birthday'])
            ? $CORRECT.$_GET['birthday']
            : $INCORRECT;
    }

    if (isset($_GET['sin'])) {
        $SinRgx = '/^(\d{3}( *)?){2}\d{3}$/';
        $SIN_ERROR_MESSAGE = preg_match($SinRgx, $_GET['sin'])
            ? $CORRECT.$_GET['sin']
            : $INCORRECT;
    }
?>

<p>Enter phone number, format: 7 or 10 digits, may include dashes or brackets or spaces</p>
<form action="./index.php" method="get">
    <label for="phoneNumber">Phone Number</label>
    <input id="phoneNumber" name="phoneNumber" type="text">
    <input type="submit">
    <?php if ($PHONE_ERROR_MESSAGE) echo "<span>$PHONE_ERROR_MESSAGE</span>" ?>
</form>

<hr>

<p>Enter license plate, format: LLLDDD or DDDLLL</p>
<form action="./index.php" method="get">
    <label for="licensePlate">License Plate</label>
    <input id="licensePlate" name="licensePlate" type="text">
    <input type="submit">
    <?php if ($LICENSE_ERROR_MESSAGE) echo "<span>$LICENSE_ERROR_MESSAGE</span>" ?>
</form>

<hr>

<p>Enter address, format: 3-5 number followed by a string and ends with Street</p>
<form action="./index.php" method="get">
    <label for="address">Address</label>
    <input id="address" name="address" type="text">
    <input type="submit">
    <?php if ($ADDRESS_ERROR_MESSAGE) echo "<span>$ADDRESS_ERROR_MESSAGE</span>" ?>
</form>

<hr>

<p>Enter birthday, format: MMM-DD-YYYY where MMM are three letters (e.g. Apr), and DD and YYYY are digits</p>
<form action="./index.php" method="get">
    <label for="birthday">Birthday</label>
    <input id="birthday" name="birthday" type="text">
    <input type="submit">
    <?php if ($BIRTHDAY_ERROR_MESSAGE) echo "<span>$BIRTHDAY_ERROR_MESSAGE</span>" ?>
</form>

<hr>

<p>Enter social insurance number, format: 9 digits, may have zero or more spaces after each set of three</p>
<form action="./index.php" method="get">
    <label for="sin">SIN</label>
    <input id="sin" name="sin" type="text">
    <input type="submit">
    <?php if ($SIN_ERROR_MESSAGE) echo "<span>$SIN_ERROR_MESSAGE</span>" ?>
</form>

<hr>

<form action = "./index.php" method = "post">
    check which school you attend:<br>
    <input type = "radio" name = "school" value = "bcit">bcit<br>
    <input type = "radio" name = "school" value = "ubc">ubc<br>
    <input type = "radio" name = "school" value = "sfu">sfu<br>
    check here if male: <input type = "checkbox" name = "male" value = "male"><br>
    check here if human: <input type = "checkbox" name = "human" value = "human"><br>
    birthplace:<select name = "birthplace[]" multiple="multiple">
        <option value=”bc”>bc</option>
        <option value=”alberta”>alberta</option>
        <option value=”saskatchewan”>saskatchewan</option>
    </select>
    <input type = "submit">
</form>

<?php

if (isset($_POST['birthplace'])) print_r($_POST['birthplace']);

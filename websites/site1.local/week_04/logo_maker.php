<?php
$BUSINESS_TYPES = ['pet', 'finance', 'food', 'education', 'design'];
$BUSINESS_NAME_ERROR = false;
$BUSINESS_DESC_ERROR = false;
$TRIM_CHARS = " \n\r\t\v\0";

if (isset($_GET['name'])) {
    $trim_n = trim($_GET['name'], $TRIM_CHARS);
    if (strlen($trim_n) == 0) $BUSINESS_NAME_ERROR = true;
}

if (isset($_GET['desc'])) {
    $trim_d = trim($_GET['desc'], $TRIM_CHARS);
    if (strlen($trim_d) == 0) $BUSINESS_DESC_ERROR = true;
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<div class="d-flex justify-content-center p-3">
    <h1>Logo Maker</h1>
</div>
<div class="container p-3">
    <form action="logo_maker.php" method="get">
        <div class="mb-3">
            <label for="name" class="form-label">Business Name:</label>
            <input type="text" name="name" id="name" class="form-control">
            <?php if ($BUSINESS_NAME_ERROR) echo "<span class='text-warning'>Must not be empty</span>" ?>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Business Description:</label>
            <input type="text" name="desc" id="desc" class="form-control">
            <?php if ($BUSINESS_DESC_ERROR) echo "<span class='text-warning'>Must not be empty</span>" ?>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Business Type:</label>
            <select name="type" id="type" class="form-select">
                <?php
                foreach ($BUSINESS_TYPES as $b)
                    echo "<option value='$b'>$b</option>>"
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-primary">
    </form>
</div>

<?php
$LOGO_SIZE = 512;
$ICON_SIZE_SCALED = 256;
$NAME_SIZE = 32;
$DESC_SIZE = 20;

if ($BUSINESS_NAME_ERROR && $BUSINESS_DESC_ERROR) die;

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $name = $_GET['name'];
    $desc = $_GET['desc'];

    if (!file_exists("./base/$type.png")) die('missing base');
    $icon = imagecreatefrompng("./base/$type.png");
    $logo = imagecreatetruecolor($LOGO_SIZE, $LOGO_SIZE);

    imagesavealpha($logo, true);
    $clearBg = imagecolorallocatealpha($logo, 0, 0, 0, 127);
    imagefill($logo, 0, 0, $clearBg);
    $black = imagecolorallocate($logo, 0, 0, 0);
    $grey = imagecolorallocate($logo, 120, 120, 120);

    $icon_start_x_centered = round(($LOGO_SIZE - $ICON_SIZE_SCALED) / 2);
    imagecopyresampled($logo, $icon, $icon_start_x_centered, 10, 0, 0, $ICON_SIZE_SCALED, $ICON_SIZE_SCALED, imagesx($icon), imagesy($icon));

    $title_offset_x = imagettfbbox($NAME_SIZE, 0, './font/Monoton-Regular.ttf', $name)[2];
    $title_start_x_centered = round(($LOGO_SIZE - $title_offset_x) / 2);
    imagettftext($logo, $NAME_SIZE, 0, $title_start_x_centered, 330, $black, './font/Monoton-Regular.ttf', $name);

    $desc_offset_x = imagettfbbox($DESC_SIZE, 0, './font/Poppins-Light.ttf', $desc)[2];
    $desc_start_x_centered = round(($LOGO_SIZE - $desc_offset_x) / 2);
    imagettftext($logo, $DESC_SIZE, 0, $desc_start_x_centered, 400, $black, './font/Poppins-Light.ttf', $desc);
    imagepng($logo, './out/temp.png');

    $jpg = imagecreatetruecolor($LOGO_SIZE, $LOGO_SIZE);
    $white = imagecolorallocate($jpg,  255, 255, 255);
    imagefill($jpg, 0, 0, $white);
    imagecopy($jpg, $logo, 0, 0, 0, 0, $LOGO_SIZE, $LOGO_SIZE);
    imagejpeg($jpg, './out/temp.jpg');

    imagedestroy($icon);
    imagedestroy($logo);
    imagedestroy(($jpg));

    echo '<div class="d-flex justify-content-center"><img src="./out/temp.png" class="shadow"></div>';
    echo '<div class="d-flex justify-content-center"><a href="./out/temp.png">PNG</a>&nbsp;|&nbsp;<a href="./out/temp.jpg">JPG</a></div>>';
}

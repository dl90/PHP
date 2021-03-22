<?php
$image = ImageCreateTrueColor(1000, 500);

$red = ImageColorAllocate($image, 255, 0, 0);
$orange = ImageColorAllocate($image, 255, 127, 0);
$yellow = ImageColorAllocate($image, 255, 255, 0);
$green = ImageColorAllocate($image, 0, 255, 0);
$blue = ImageColorAllocate($image, 0, 0, 255);
$purple = ImageColorAllocate($image, 75, 0, 130);
$violet = ImageColorAllocate($image, 143, 0, 255);

$COLORS = [$red, $orange, $yellow, $green, $blue, $purple, $violet];

$cx = 500;
$cy = 500;
$arc_width = 1000;
$arc_height = 1000;

foreach ($COLORS as $color) {
    ImageFilledArc($image, $cx, $cy, $arc_width, $arc_height, -180, 90, $color, IMG_ARC_PIE);
    if ($arc_width > 0) $arc_width -= 100;
    if ($arc_height > 0) $arc_height -= 100;
}

ImagePng($image, "rainbow.png");
ImageDestroy($image);

echo '<img src="rainbow.png">';

<?php

//header("Content-type: image/png");
$image = ImageCreateTrueColor(900, 900);
$red = ImageColorAllocate($image, 255, 0, 0);
$black = ImageColorAllocate($image, 0,0,0);
Imagefill($image, 0, 0, $black );
ImageString($image, 5, 100, 100, "Howdy", $red);
ImagePng($image, "img.png");
ImageDestroy($image);

echo '<img src="img.png">';

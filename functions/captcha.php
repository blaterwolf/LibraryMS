<?php
session_start();

$random = rand(10000, 99999);

$_SESSION['captcha'] = $random;

$captcha = imagecreatefromjpeg('captcha.jpg');
$color = imagecolorallocate($captcha, 0, 0, 0);
$font = 'monofont.ttf';
imagettftext($captcha, rand(15, 20), rand(-5, 5), rand(10, 15), rand(15, 20), $color, $font, $random);
imagepng($captcha);
imagedestroy($captcha);
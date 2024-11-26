<?php

/*
Da bi ovo radilo Captcha radili instalirao sam GD i FreeType ekstenzije za PHP.
Otvorio Control Panel > Programs > Programs and Features.
Kliknuo na "Turn Windows features on or off".
Pronašao "Internet Information Services" i proširio ga.
Pronašao "World Wide Web Services" i proširio ga.
Pronašao "Application Development Features" i označio "CGI" i "ISAPI Extensions".
Kliknuo "OK" da bi instalirao odabrana svojstva.
Ja koristim XAMPP, otvorio ga XAMPP Control Panel i kliknuo na "Config" pored Apache, zatim odaberao "php.ini".
Pronašao sljedeću liniju i uklonio komentar (uklonio ";"):
extension=gd
Ova red nisam imao ali sam ga upisao:
extension=freetype
Spremio promjene u php.ini datoteci i restartao Apache.
Nakon toga mi sve radilo. Branko C.
*/
session_start();

// Postavke Lemin Captcha
$width = 200;
$height = 50;
$font_size = 24;
$font_path = 'C:\Windows\Fonts\times.ttf'; // ovo je moja putanja, po potrebi promijeniti
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$captcha_length = 6;

// Generiranje Captcha koda
$captcha_code = '';
for ($i = 0; $i < $captcha_length; $i++) {
    $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
}
$_SESSION['captcha_code'] = $captcha_code;

// Kreiranje slike
$image = imagecreatetruecolor($width, $height);
$background_color = imagecolorallocate($image, 240, 240, 240);
$text_color = imagecolorallocate($image, 0, 0, 0);

imagefill($image, 0, 0, $background_color);

$font = $font_path;
imagettftext($image, $font_size, 0, 40, 35, $text_color, $font, $captcha_code);

// Prikaz slike
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit;
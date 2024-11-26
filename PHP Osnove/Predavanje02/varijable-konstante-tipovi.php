<?php

// varijable
$ime;
//var_dump($ime);

$ime = "Branko";
var_dump($ime);

// konstante
define('PI', 3.14);
var_dump(PI);

// tipovi podataka
// integer

$int_dek = 123;
var_dump($int_dek);

$int_okt = 0123;
var_dump($int_okt);

$int_hex = 0x1A;
var_dump($int_hex);

$float_var = 1.23;
var_dump($float_var);

$string_var = 'Ovo je string <br> Ovo je novi red';
echo $string_var;

$ime ="Ivan";
$prezime = "Ivić";
$ime_prezime = $ime . " " . $prezime;   // konkatenacija
$ime_prezime = "$ime $prezime";         // interpolacija

// boolean
$bool_true = true;
$bool_false = false;
echo $bool_true;
echo $bool_false;

var_dump(0.33 == 0.3333333);

?>
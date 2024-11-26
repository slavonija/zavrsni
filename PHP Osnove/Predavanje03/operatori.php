<?php

$a = 10;
$b = 20;

echo $a % $b; // 10
echo $a += $b; // 10
echo $a.$b;     //3020 type jaggling rezultata u string

$b++;           // $b = $b + 1
var_dump($b);   //21

$c = $b++;      // $b = 22, $c = 21
var_dump($c);
var_dump($b);
$c = ++$b;      // $b = 23, $c = 23
var_dump($c);
var_dump($b);


// Operatori usporedbe
$x = 10;
$y = "10";    // vrijednost ista ali nije tip podatka

var_dump($x == $y);     // true
var_dump($x === $y);     // false jer tip nije isti
var_dump($x != $y);     // false
var_dump($x <> $y);     // false
var_dump($x !== $y);     // true jer je suprotno od ==

$y = "A";
var_dump($x > $y);      // false (ne znamo zašto)
var_dump((int)"A");     // int(0)(ne znamo zašto)

// Operatori logički
$a = 0;
$b = 20;
var_dump(!$x);          // false
var_dump($x && $y);     // true, $a i $b
var_dump($x || $y);     // true, $a ili $b

?>

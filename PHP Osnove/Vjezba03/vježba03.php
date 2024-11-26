<?php

$a = 5;
$b = 2;
$c = "Prvi string.";
$d = "Drugi string.";

echo -$a ."<br>";       // negacija
echo -$b ."<br>";       // negacija
echo $a + $b ."<br>";   // suma
echo $a - $b ."<br>";   // razlika
echo $a * $b ."<br>";   // množenje
echo $a / $b ."<br>";   // djeljenje
echo $a % $b ."<br>";   // modul
echo $a ** $b ."<br><br>";  // potenciranje

$f = $c . $d;
echo $f ."<br>";

$a += $b;
echo $a ."<br>";

var_dump($a > $b);      // true jer je 7 veće od 2
echo "<br>";

var_dump(++$a);         // pre-inkrement, $a je uvećan pa ispisan 7+1=8
echo "<br>";
var_dump(--$b);         // pre-dekrement, $b je umanjen pa ispisan 2-1=1

?>
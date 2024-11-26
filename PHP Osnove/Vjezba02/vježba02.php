<?php

// cijeli broj (integer)
$cijeli = 3;

// realni broj (floating-point number)
$realni = 7.65;

// tekstualni podatak (string)
$str = "Ovo je string.";

// logička vrijednost (boolean)
$logicki = true;

// ispis konkatenacijom
echo '$cijeli = ' . $cijeli . '<br>' . '$realni = ' . $realni . '<br>' . '$str = ' . $str . '<br>' . '$logicki = ' . $logicki  . '<br><br>';
// ispis interpolacijom
// echo "\$cijeli =  $cijeli\n\$realni = $realni\n\$str = $str\n\$logicki = $logicki\n\n";

// konstante
define('PI', 3.14159265);   // Pi
define('OULER', 2.7182818284);  // Oulerov broj
define('BRZINA_ZVUKA', 340);  // brzina zvuka u m/s
define('OMB', "O moj bože");

// ispis konstanti
echo PI . "<br>";
echo OULER . "<br>";
echo BRZINA_ZVUKA . "<br>";
echo OMB . "<br><br>";

$a = 10;
$b =& $a;   // b je referenciran na varijablu a

$a = 500;   // vrijednost $a se primijenila
echo "\$a:" . $a . " " . "\$b:" . $b. "<br>";    // promjenom $a mijenja se i $b

$b = 1000;  // vrijednost $b se primijenila
echo "\$a:" . $a . " " . "\$b:" . $b. "<br>";       // promjenom $b mijenja se i $a

?>
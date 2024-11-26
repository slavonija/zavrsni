<?php

// Zadatak 1
$a = 20;
$b = 20;
$c = 10;
// rezultat true/false
//(ako je b između a i c) = true
// (ako b nije između a i c) = false

// (($b > $a i $b < $c) ili ($b < $a && $b > $c));
var_dump(($b > $a && $b < $c) || ($b < $a && $b > $c)); // && je i a || je ili





// Zadatak 2 - Referenciranje
$a = 10;
$b = &$a;   // 10 referenca na $a
$a = 15;
$b = 20;    // 20
echo $a;

$ime = "Saša";
echo strtoupper($ime); // SAšA
echo mb_strtoupper($ime, "utf-8"); //SAŠA


echo htmlspecialchars("<script>alert(\" DGSDGSDGSDG \")</SCRIPT>");
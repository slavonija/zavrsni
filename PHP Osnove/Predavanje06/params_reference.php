<?php
declare(strict_types=1);

$age = 30;

function promjeniGodine(int $godine): void {
    $GLOBALS['age'] = $godine;
}

promjeniGodine(40);
echo $age;  //40

// 
function promjeniGodineReference(int &$godine, int $value): void {
    $godine = $value;
}

// pozivanjem funkcije promjeniGodineReference parametar se referncira i mijenja $age
promjeniGodineReference($age, 50);
echo $age;  //50

$noveGodine = 10;
// $promjeniGodineReference(50, 50); // ovo izaziva fatalnu grešku jer se ne referencira na ništa
promjeniGodineReference($noveGodine, 30);    
echo $noveGodine;   // 30 jer je vezan referencom iz funkcije
echo $age;  // $age je i dalje 50, nije se promjenio

?>
<?php
// funkcija prima podatak kroz parametar i pribroji varijabli sum
// bez static dobijamo varijabu koja je i ušla
// static definira varijablu koja ostaje zapamćena između poziva funkcija
// prvi puta se napravi inicijalizacija varijable i ostaje zapamćena u funkciji
function randomAdd(int $number): int {
    
    static $sum = 0; // inicijalizira se samo prvi puta, mora biti definiran u funkciji!
    $sum += $number;
    return $sum;
}

$sum = randomAdd(5);
echo $sum;  // 5
$sum = randomAdd(5);
echo $sum;  // 10


$test ='randomAdd'; // definiran string
var_dump($test(5)); // čim su ispred stringa zagrade, PHP traži funkciju, rezultat je 15

?>
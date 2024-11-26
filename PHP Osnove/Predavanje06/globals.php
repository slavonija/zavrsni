<?php

// $foo je globalna i lokalna varijabla
function test() {
   // foo je file ili object a koristi se kao ime varijable
    $foo = "lokalna varijabla";

    echo '$foo u globalnom dosegu: ' . $GLOBALS["foo"] . "\n";
    echo '$foo u trenutnom dosegu: ' . $foo . "\n";
}

$foo = "Primjer sadržaja";
test();

// static varijabla
function incrementCounter() {
// Statička varijabla postoji samo u lokalnom dosegu funkcija, ali ne gubi vrijednost kada izvršenje programa napusti funkciju
    static $counter = 0;
    $counter++;
    echo $counter;
}

incrementCounter(); // Ispisuje "1"
incrementCounter(); // Ispisuje "2"
incrementCounter(); // Ispisuje "3"



?>

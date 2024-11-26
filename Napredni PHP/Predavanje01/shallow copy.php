<?php

// Nacrt objekta (Razred, Klasa)
class Car{
    // Svojstva (Atributi), ispred je access modifier public, oni će nam kasnije omogućiti učahurivanje
    public $brand;
    public $model;

}
// ako probamo var_dump(Car) php ne zna što je to
// ključna riječ new pokreće distanciranje objekta
// $car je instanca klase Car
$car = new Car();
$car->brand = "Audi";

$car1 = new Car();

$car2 = $car1; // dijele istu memorijsku lokaciju jer su reference
$car2->model = "X5";

$car3 = clone $car1;
// ovo je potpuno novi objekt i ne utječe na objekte $car1 i $car2
// to je shallow copy tj. plitko, površno kopiranje
$car3->model = "X6"; // ovo ne utječe na $car1 i $car2

var_dump($car, $car1, $car2, $car3); 
var_dump($car == $car1);
var_dump($car2 == $car3);

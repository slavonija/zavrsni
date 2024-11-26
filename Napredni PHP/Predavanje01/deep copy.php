<?php

// Nacrt objekta (Razred, Klasa)
class Car{
    // Svojstva (Atributi i objekti), ispred je access modifier public, oni će nam kasnije omogućiti učahurivanje
    public $brand;
    public $model;
    public $engine; // ovo svojstvo je objekt

    // Dodajemo metodu __clone za deep copy
    public function __clone() {
        // $this je ključna riječ koja se koristi za referenciranje trenutnog objekta instance klase
        // provjerimo da li je $this->engine objekt
        if (is_object($this->engine)) {
            $this->engine = clone $this->engine; // Deep copy unutrašnjegeg objekta s rekurzivnim kloniranjem
        }
    }

}

// Klasa Engine - koristi se kao primjer složenog unutrašnjeg objekta
class Engine {
    public $type;
    public $horsepower;
}

// Instanciramo osnovni objekt Car
$car1 = new Car();
$car1->brand = "BMW";
$car1->model = "X5";

// Dodajemo složeni objekt Engine
$car1->engine = new Engine();
$car1->engine->type = "Diesel";
$car1->engine->horsepower = 250;

// Shallow Copy
$car2 = $car1; // Samo kopira referencu na isti objekt, dijele istu referencu

// Deep Copy
$car3 = clone $car1; // potpuno nezavisna kopija

// Mijenjamo svojstva različitih kopija
$car2->model = "X6"; // Utječe na car1 jer je to ista referenca
$car3->engine->type = "Electric"; // Ne utječe na car1 jer je to duboka kopija

// Ispisujemo objekte da vidimo razlike
var_dump($car1); // Prikazuje promjene iz car2 jer je shallow copy
var_dump($car2); // Isto kao i car1
var_dump($car3); // Neovisna kopija s deep copy ponašanjem
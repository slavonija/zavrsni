<?php

declare(strict_types=1);

class Car{
    // ne želimo da se pristupi izvana
    private string $brand;
    private string $model;

    // konstruktor zapiše ulazne vrijednosti, automatski se poziva prilikom stvaranja objekta
    public function __construct(string $brand, string $model){
        // sa $this se referenciramo na objekt koji stvara konstruktor
        $this->brand = $brand;
        $this->model = $model;
        echo "Poziva se kod kreiranja objekta.";
    }
    public function __destruct() {
        echo "Poziva se kod zatvaranja objekta.";
    }
    
}

$car = new Car(brand:"Audi", model:"A4");

// ne možemo pristupiti tom objektu (svojstvu), javlja grešku
//var_dump($car->brand);

var_dump($car);

// moguće pristupiti samo sa sa getter i setter


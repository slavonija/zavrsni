<?php

declare(strict_types=1);

class Car{
    private string $brand;
    private string $model;


    public function __construct(string $brand, string $model){
        $this->brand = $brand;
        $this->model = $model;
    }

    // getter za brand vraća string
    public function getBrand(): string{
        return $this->brand;
    }

    // setter za brand
    public function setBrand(string $brand): void{
        $this->brand = $brand;
    }

    // getter za model
    public function getModel(): string{
        return $this->model;
    }


}

$car = new Car("Audi", "A4");
var_dump($car->getBrand()); // Audi

// Poziv setter metode za promjenu brand-a
$car->setBrand("Mercedes");
var_dump($car->getBrand()); // Mercedes

$car1 = new Car("BMW", "X5"); // BMW
var_dump($car1->getBrand());
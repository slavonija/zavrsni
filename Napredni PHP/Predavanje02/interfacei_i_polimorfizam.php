<?php

// interface je obaveza za klase da implementiraju određene metode
// dozvoljeno je samo pisanje imena metode, uglavnom public
// interface ne definira kako će se metoda ponašati, nema vitičastih zagrada
// ovdje je samo ono što klasa treba definirati, nabrojane metode
interface Shape {
    public function getArea(): float;
}
 
class Circle implements Shape {
    private float $radius;
 
    public function __construct(float $radius) {
        $this->radius = $radius;
    }
 
    public function getArea(): float {
        // računanje površine kruga
        return M_PI * $this->radius ** 2;
    }
}
 
class Rectangle implements Shape {
    private float $width;
    private float $height;
 
    public function __construct(float $width, float $height) {
        $this->width = $width;
        $this->height = $height;
    }
 
    public function getArea(): float {
        return $this->width * $this->height;
    }
}
 
// različite klase implementiraju iste metode na različite načine, to je polimorfizam kroz interface 
function printArea(Shape $shape) {
    echo 'Površina: ' . $shape->getArea() . PHP_EOL;
}

// circle je nastao iz klase Circle ali je u stvari Shape
$circle = new Circle(5);
$rectangle = new Rectangle(3, 4);

printArea($circle);
printArea($rectangle);
 
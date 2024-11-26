<?php

class Animal {
    public function makeSound() {
        echo "Animal sound";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "Vau!";
    }
}

class Cat extends Animal {
    public function makeSound() {
        echo "Mjau!";
    }
}

function printSound(Animal $animal) {
    $animal->makeSound();
    echo PHP_EOL;
}

$dog = new Dog();
$cat = new Cat();

printSound($dog); // Ispisat će: Vau!
printSound($cat); // Ispisat će: Mjau!
?>

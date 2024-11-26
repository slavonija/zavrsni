<?php

class ParentClass {
    private $privateProperty = "I am private";

    private function privateMethod() {
        return "This is a private method";
    }

    public function accessPrivate() {
        return $this->privateProperty; // Dostupno unutar iste klase
    }
}

class ChildClass extends ParentClass {
    public function tryAccessPrivate() {
        // return $this->privateProperty; // Fatal error: Cannot access private property
        return "Cannot access private members!";
    }
}

$parent = new ParentClass();
echo $parent->accessPrivate(); // "I am private"

$child = new ChildClass();
echo $child->tryAccessPrivate(); // "Cannot access private members"

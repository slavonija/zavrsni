<?php

namespace App\Classes;

abstract class Person{
    protected int $id;
    protected string $firstName;
    protected string $lastName;

    public function __construct(string $firstName, string $lastName){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getFirstName(): string{
        return $this->firstName;
    }

    public function getLastName(): string{
        return $this->lastName;
    }
}
<?php

namespace App\Classes;

use App\Interfaces\Confirmable;

class Organizer extends Person{
    static private int $nextId = 1;
    private array $events = [];

    public function __construct(string $firstName, string $lastName){
        parent::__construct($firstName, $lastName);
        $this->id = self::$nextId++;
    }

    public function getEvents(): array{
        return $this->events;
    }

    public function addEvent(Confirmable $event): void{
        $this->events[] = $event;
    }

    public function confirmEvent(Confirmable $event): void{
        if(in_array($event, $this->events)){
            $event->confirm();
        }
    }
}
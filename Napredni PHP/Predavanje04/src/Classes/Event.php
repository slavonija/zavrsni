<?php

namespace App\Classes;

use DateTime;
use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Interfaces\Confirmable;
use App\Interfaces\Sortable;

class Event implements Confirmable, Sortable{
    static private int $nextId = 1;
    private int $id;
    private string $name;
    private EventType $type;
    private EventStatus $status;
    private DateTime $startDate;
    private array $participants = [];
    private bool $isApproved = false;

    public function __construct(string $name, EventType $type, DateTime $startDate){
        $this->name = $name;
        $this->type = $type;
        $this->startDate = $startDate;
        $this->status = EventStatus::Planned;
        $this->id = self::$nextId++;
    }

    public function confirm(): void{
        $this->status = EventStatus::Confirmed;
    }

    public function cancel(): void{
        $this->status = EventStatus::Canceled;
    }

    public function sortBy(string $field): mixed{
        return $this->$field;
    }
}
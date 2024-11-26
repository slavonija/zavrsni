<?php

namespace App\Classes;

use App\Enums\ParticipantStatus;

class Participant extends Person{
    static private int $nextId = 1;
    private ParticipantStatus $status;

    public function __construct(string $firstName, string $lastName){
        parent::__construct($firstName, $lastName);
        $this->id = self::$nextId++;
        $this->status = ParticipantStatus::Pending;
    }

    public function getStatus(): ParticipantStatus{
        return $this->status;
    }

    public function setStatus(ParticipantStatus $status): void{
        $this->status = $status;
    }
}
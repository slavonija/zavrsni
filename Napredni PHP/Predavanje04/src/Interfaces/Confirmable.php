<?php

namespace App\Interfaces;

interface Confirmable{
    public function confirm(): void;
    public function cancel(): void;
}
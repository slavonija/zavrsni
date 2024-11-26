<?php

namespace App\Enums;

enum EventType: string {
    case Conference = "Konferencija";
    case Seminar = "Seminar";
    case Workshop = "Radionica";
}
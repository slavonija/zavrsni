<?php

namespace App\Enums;

enum EventStatus: string {
    case Planned = "Planiran";
    case Confirmed = "Potvrđen";
    case Canceled = "Otkazan";
}
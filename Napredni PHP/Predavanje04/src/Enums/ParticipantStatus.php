<?php

namespace App\Enums;

enum ParticipantStatus: string {
    case Accepted = "Prihvaćen";
    case Declined = "Odbijen";
    case Pending = "Na čekanju";
}
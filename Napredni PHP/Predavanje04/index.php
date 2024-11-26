<?php

require_once "vendor/autoload.php";

use App\Classes\Organizer;
use App\Classes\Event;
use App\Enums\EventType;
use App\Interfaces\Sortable;

$o1 = new Organizer("John", "Doe");
$e1 = new Event("PHP Konferencija", EventType::Conference, new DateTime("2022-10-10"));
$e2 = new Event("JavaScript Radionica", EventType::Workshop, new DateTime("2022-11-11"));
$e3 = new Event("Python Seminar", EventType::Seminar, new DateTime("2022-12-12"));
$o1->addEvent($e1);
$o1->addEvent($e2);
$o1->addEvent($e3);
$o1->confirmEvent($e1);

$events = $o1->getEvents();
var_dump($events);
usort($events, fn(Sortable $a, Sortable $b) => $b->sortBy('name') <=> $a->sortBy('name'));
var_dump($events);
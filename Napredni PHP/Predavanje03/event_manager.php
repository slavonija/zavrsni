<?php
 
enum EventType: string {
    case Conference = "Konferencija";
    case Seminar = "Seminar";
    case Workshop = "Radionica";
}
 
enum EventStatus: string {
    case Planned = "Planiran";
    case Confirmed = "Potvrđen";
    case Canceled = "Otkazan";
}
 
enum ParticipantStatus: string {
    case Accepted = "Prihvaćen";
    case Declined = "Odbijen";
    case Pending = "Na čekanju";
}
 
interface Confirmable{
    public function confirm(): void;
    public function cancel(): void;
}
 
interface Sortable{
    public function sortBy(string $field): mixed;
}
 
// apstraktna klasa koju ne želimo moći instancirati u objekt
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

// klasu pravimo iz klase Person
class Participant extends Person{
    static private int $nextId = 1;
    private ParticipantStatus $status;
 
// ne možemo pristupiti $firstName i $lastName svojstvima jer su protected
// ta svojstva dostupna ili samo unutar klase Person ili unutar klase koja je nasljeđuje
// moguće im je naravno pristupiti sa getter i setter ili sa __get magična metoda
    public function __construct(string $firstName, string $lastName){
        parent::__construct($firstName, $lastName); // parent konstruktor zaprimi ime i prezime
        // zapisana vrijednost u svojstvo id, self jer se radi o statičkoj vrijednosti
        // Prilikom instanciranja objekta svojstvo $nextId ne postoji nad objektom nego nad klasom
        $this->id = self::$nextId++; // svaki puta kada kreiramo novi objekt, $nextId se poveća za 1
        $this->status = ParticipantStatus::Pending; // Na čekanju
    }
 
    public function getStatus(): ParticipantStatus{
        return $this->status;
    }
 
    public function setStatus(ParticipantStatus $status): void{
        $this->status = $status;
    }
}
 
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
 
$o1 = new Organizer("John", "Doe");
$e1 = new Event("PHP Konferencija", EventType::Conference, new DateTime("2024-10-10"));
$e2 = new Event("JavaScript Radionica", EventType::Workshop, new DateTime("2024-11-11"));
$e3 = new Event("Python Seminar", EventType::Seminar, new DateTime("2024-12-12"));
$o1->addEvent($e1);
$o1->addEvent($e2);
$o1->addEvent($e3);
$o1->confirmEvent($e1);
 
$events = $o1->getEvents();
var_dump($events);

// sortiranje
$collator = new Collator('hr_HR');
usort($events, fn(Sortable $a, Sortable $b) => $b->sortBy('name') <=> $a->sortBy('name')); // fn je arrow function
var_dump($events);

$array = array('Ägile', 'Ãgile', 'Test', 'カタカナ', 'かたかな', 'Ágile', 'Àgile', 'Âgile', 'Agile');

function Sortify($string)
{
    return preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1' . chr(255) . '$2', htmlentities($string, ENT_QUOTES, 'UTF-8'));
}

array_multisort(array_map('Sortify', $array), $array);

var_dump($array);
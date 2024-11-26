<?php


class Osoba {
    // svojstvima se može pristupiti unutar klase i klasama izvedenim iz te klase (za razliku od protected)
    protected $ime;
    protected $prezime;

   public function __construct($ime, $prezime){
        $this->ime = $ime;
        $this->prezime = $prezime;
    }

    // ovo je magic metoda koji omogućava ispis stringa
    public function __toString(){
        return $this->ime . " " . $this->prezime;
    }
}

// korištenje koda iz bazne klase u izvedenoj klasi
class Student extends Osoba {
    // po ovome se Student razlikuje od Osobe, dodano svojstvo
    // jedinstvenog matičknog broja akademskog građana
    private string $jmbag;

    // doajemo još jedna konstruktor na studentu koji ima $jmbag
    public function __construct($ime, $prezime, $jmbag){
        // ne ovako, radi jer je protected ako je acces modifier private, prestaje raditi
        // $this->ime = $ime;
        // $this->prezime = $prezime;
        // ovako dobijamo modularnost, ova linija mora biti uvijek prva
        parent::__construct($ime, $prezime); // referenciranje osnovne klase (superklase) unutar izvedene klase (subklase)
        $this->jmbag = $jmbag;
    }

    // ovo je polimorfizam jer je isto ime (ali u nasljeđenoj klasi)  ali je druga funkcionalnost
    public function __toString()
    {
        return  parent::__toString() . "-" . $this->jmbag;
    }
}

// objekt iz klase student mora imati parametre
$student = new Student("Marko", "Marković", "123456789");
var_dump($student);
echo $student;

$osoba = new Osoba("Marko", "Marković", "123456789");
var_dump($osoba);
echo $osoba;
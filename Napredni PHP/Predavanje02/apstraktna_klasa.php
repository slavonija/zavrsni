<?php
class Test{
    protected string $test;
}

// ova klasa ne sadrži apstraktne metode bez implementacije a mogla je
abstract class Osoba extends Test{
   protected $ime;
   protected $prezime;

   public function __construct($ime, $prezime){
        $this->ime = $ime;
        $this->prezime = $prezime;
    }

    public function __toString(){
        return $this->ime . " " . $this->prezime;
    }

}

class Student extends Osoba {
    private string $jmbag;

    public function __construct($ime, $prezime, $jmbag){
        // ova linija mora biti uvijek prva
        parent::__construct($ime, $prezime);
        // ne ovako
        // $this->ime = $ime;
        // $this->prezime = $prezime;
        $this->jmbag = $jmbag;
    }

    // ovo je polimorfizam jer je isto ime ali druga funkcionalnost
    public function __toString()
    {
        return  parent::__toString() . "-" . $this->jmbag;
    }
}


$osoba = new Student("Marko", "Marković", "123456789");
var_dump($osoba);
echo $osoba; // Marko Marković-123456789

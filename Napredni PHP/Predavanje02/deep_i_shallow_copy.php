<?php

class mojaKlasa{
    public $x =10;

    public function dohvatiX(){
        $this->x = 5;
        return $this->x;
        }
}

class mojaKlasaKojaSeMožeKlonirati{
    public $a;
    // na klonu, napravi duboku kopiju ovog objekta kloniranjem internog člana;
    public function __clone(){
        $this->a = clone $this->a;
    }
}

echo "=================== Plitka (engl. Shallow) kopija =====================\n";

echo "Kreiranje novog objekta:\n";
$obj1 = new mojaKlasa();
var_dump($obj1);

echo "Pronađi vrijednost x:\n";
$y = $obj1->dohvatiX();
var_dump($y);

echo "Kreiraj klonirani objekt: (shallow)\n";
$obj2 = $obj1;
var_dump($obj2);
echo "==================== Duboka (engl. Deep) kopija ======================\n";

echo "Kreiranje novog objekta klase koja se može klonirati:\n";
$obj3 = new mojaKlasaKojaSeMožeKlonirati();
var_dump($obj3);
echo "Pridruživanje/ pravljenje instance od mojaKlasa\n";
$obj3->a = new mojaKlasa();

echo "Kloniraj objekt mojaKlasaKojaSeMožeKlonirati: (Duboko)\n";
$obj4 = clone $obj3;
var_dump($obj4);
<?php

class Example {
    // Svojstva klase s različitim modifikatorima vidljivosti
    public $publicProperty = 'Public Property';
    protected $protectedProperty = 'Protected Property';
    private $privateProperty = 'Private Property';

    // Javno dostupna metoda
    public function publicMethod() {
        echo "Inside publicMethod---:\n";
        echo $this->publicProperty . "\n";     // Dostupno
        echo $this->protectedProperty . "\n"; // Dostupno
        echo $this->privateProperty . "\n\n";   // Dostupno
    }

    // Zaštićena metoda
    protected function protectedMethod() {
        echo "Inside protectedMethod---:\n";
        echo $this->publicProperty . "\n";     // Dostupno
        echo $this->protectedProperty . "\n"; // Dostupno
        echo $this->privateProperty . "\n\n";   // Dostupno
    }

    // Privatna metoda
    private function privateMethod() {
        echo "Inside privateMethod---:\n";
        echo $this->publicProperty . "\n";     // Dostupno
        echo $this->protectedProperty . "\n"; // Dostupno
        echo $this->privateProperty . "\n\n";   // Dostupno
    }

    // Javni pristup zaštićenoj i privatnoj metodi
    public function accessProtectedAndPrivate() {
        $this->protectedMethod(); // Poziv zaštićene metode unutar klase
        $this->privateMethod();   // Poziv privatne metode unutar klase
    }
}

// Kreiranje instance klase Example
$example = new Example();

// Poziv javnog svojstva i metode
echo $example->publicProperty . "\n"; // Direktan pristup javnom svojstvu
$example->publicMethod();             // Poziv javne metode

// Pristup zaštićenim i privatnim svojstvima izvan klase (uzrokuje grešku)
// echo $example->protectedProperty; // Greška: zaštićeno svojstvo
// echo $example->privateProperty;   // Greška: privatno svojstvo

// Poziv metoda koje pristupaju zaštićenim i privatnim metodama
$example->accessProtectedAndPrivate(); // Ovdje možemo pristupiti zaštićenoj i privatnoj metodi jer se one pozivaju unutar javne metode

// Direktan poziv zaštićenih i privatnih metoda izvan klase (uzrokuje grešku)
// $example->protectedMethod(); // Greška: zaštićena metoda
// $example->privateMethod();   // Greška: privatna metoda
?>


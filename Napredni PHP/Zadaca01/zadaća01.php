// Napišite PHP klasu koja predstavlja Korisnik. 
// Klasa Korisnik treba imati privatna svojstva ime, prezime i email. 
// Klasa treba imati konstruktor za postavljanje ovih svojstava pri stvaranju objekta, kao i gettere i settere za svako od svojstava.

// Extra feature: Setter za email svojstvo treba provjeriti da li je poslan ispravan format email

<?php

class Korisnik {
    private $ime;
    private $prezime;
    private $email;

    // konstruktor za postavljanje svojstava
    public function __construct($ime, $prezime, $email) {
        $this->postaviIme($ime);
        $this->postaviPrezime($prezime);
        $this->postaviEmail($email);
    }

    // getter za ime
    public function dohvatiIme() {
        return $this->ime;
    }

    // setter za ime
    public function postaviIme($ime) {
        $this->ime = $ime;
    }

    // getter za prezime
    public function dohvatiPrezime() {
        return $this->prezime;
    }

    // setter za prezime
    public function postaviPrezime($prezime) {
        $this->prezime = $prezime;
    }

    // getter za email
    public function dohvatiEmail() {
        return $this->email;
    }

    // setter za email
    public function postaviEmail($email) {
        // funkcija filter_var s filterom FILTER_VALIDATE_EMAIL provjerava da li je email ispravan
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Neispravan email format');
        }
        $this->email = $email;
    }
}

// testiranje klase
// instanciranje klase i popunjavanje metoda
$korisnik1 = new Korisnik("Branko", "Ćelap", "branko.celap@gmail.com");
// ispisivanje metoda
echo $korisnik1->dohvatiIme() . "\n"; // Izlaz: Branko
echo $korisnik1->dohvatiPrezime() . "\n"; // Izlaz: Ćelap
echo $korisnik1->dohvatiEmail() . "\n"; // Izlaz: branko.celap@gmail.com
$korisnik2 = $korisnik1; // kopija objekta $korisnik1
$korisnik1->ime = "Mladen"; // nema promjene jer je private svojstvo
var_dump($korisnik1);
var_dump($korisnik1 == $korisnik2); // Izlaz: true


$korisnik3 = new Korisnik("Tomislav", "Keščec", "tomislav.kescec@gmailcom"); // nedostaje . u adresi
echo $korisnik3->dohvatiIme() . "\n"; // Izlaz: greška jer nema $korisnik3
//echo $korisnik3->dohvatiEmail() . "\n"; // Izlaz: greška jer nema $korisnik3
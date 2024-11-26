<?php

// Enumeracija za tip studenta
abstract class TipStudenta {
  const REDOVNI = "Redovni";
  const IZVANREDNI = "Izvanredni";
}

// Interface za potpisivanje entiteta
interface Potpisivo {
  public function potpisi();
}

// Osnovna klasa za Osobu
class Osoba {
  protected $ime;
  protected $prezime;

  public function __construct($ime, $prezime) {
    $this->ime = $ime;
    $this->prezime = $prezime;
  }

  public function __toString() {
    return "{$this->ime} {$this->prezime}";
  }
}

// Klasa Student
class Student extends Osoba {
  private static $brojacID = 1;
  private $id;
  private $tip;

  public function __construct($ime, $prezime, $tip) {
    parent::__construct($ime, $prezime);
    $this->id = self::$brojacID++;
    $this->tip = $tip;
  }

  public function getId() {
    return $this->id;
  }

  public function getPrezime() {
    return $this->prezime;
  }

  public function __toString() {
    return "ID: {$this->id}, Ime: {$this->ime}, Prezime: {$this->prezime}, Tip: {$this->tip}";
  }
}

// Klasa Predmet
class Predmet implements Potpisivo {
  private $sifra;
  private $naziv;
  private $ectsBodovi;
  private $odobren;

  public function __construct($sifra, $naziv, $ectsBodovi) {
    $this->sifra = $sifra;
    $this->naziv = $naziv;
    $this->ectsBodovi = $ectsBodovi;
    $this->odobren = false;
  }

  public function potpisi() {
    $this->odobren = true;
  }

  public function __toString() {
    $odobrenTekst = $this->odobren ? "da" : "ne";
    return "Šifra: {$this->sifra}, Naziv: {$this->naziv}, Bodovi: {$this->ectsBodovi} ECTS, Odobren: {$odobrenTekst}";
  }
}

// Klasa Dokument
class Dokument implements Potpisivo {
  private $naslov;
  private $sadržaj;
  private $potpisan;

  public function __construct($naslov, $sadržaj) {
    $this->naslov = $naslov;
    $this->sadržaj = $sadržaj;
    $this->potpisan = false;
  }

  public function potpisi() {
    $this->potpisan = true;
  }

  public function __toString() {
    $potpisanTekst = $this->potpisan ? "da" : "ne";
    return "Naslov: {$this->naslov}, Potpisan: {$potpisanTekst}";
  }
}

// Klasa Profesor
class Profesor extends Osoba {
  private $predmet;

  public function __construct($ime, $prezime, $predmet) {
    parent::__construct($ime, $prezime);
    $this->predmet = $predmet;
  }

  public function __toString() {
    return "Profesor: " . parent::__toString() . ", Predmet: {$this->predmet}";
  }
}

// Klasa Asistent
class Asistent extends Osoba {
  private $predmet;

  public function __construct($ime, $prezime, $predmet) {
    parent::__construct($ime, $prezime);
    $this->predmet = $predmet;
  }

    public function __toString() {
        return "Asistent: " . parent::__toString() . ", Predmet: {$this->predmet}";
    }
}

// Klasa Dekan
class Dekan extends Osoba {
    private $titula;
  
    public function __construct($ime, $prezime, $titula) {
      parent::__construct($ime, $prezime);
      $this->titula = $titula;
  }

    public function potpisi(Potpisivo $entitet) {
        $entitet->potpisi();
    }
  
    public function __toString() {
        return "Dekan: " . parent::__toString() . ", Titula: {$this->titula}";
    }
}
  
// Glavni program

// Kreiranje studenata
$student1 = new Student("Sanja", "Ulipi", TipStudenta::REDOVNI);
$student2 = new Student("Branko", "Ćelap", TipStudenta::IZVANREDNI);
$student3 = new Student("Smiljka", "Božičković", TipStudenta::REDOVNI);

// Kreiranje liste studenata
$studenti = [$student1, $student2, $student3];

// Ispis studenata
echo "Studenti:\n";
foreach ($studenti as $student) {
  echo $student . "\n";
}

// Sortiraj studenate po ID-u (zadano) i ispiši
usort($studenti, function($a, $b) { return $a->getId() <=> $b->getId(); });
echo "\nStudenti sortirani po ID-u:\n";
foreach ($studenti as $student) {
  echo $student . "\n";
}



// Sortiraj studenata po prezimenu i ispiši
usort($studenti, function($a, $b) { return $a->getPrezime() <=> $b->getPrezime(); });
echo "\nStudenti sortirani po prezimenu:\n";
foreach ($studenti as $student) {
  echo $student . "\n";
}

// Kreiranje predmeta
$predmet = new Predmet("123", "Back-end programer", 20);
echo "\nPredmet prije odobrenja:\n";
echo $predmet . "\n";

// Kreiranje asistenta i profesora za predmet
$asistent = new Asistent("Željko", "Romić", $predmet);
$profesor = new Profesor("Gabrijel", "Lovrić", $predmet);

echo "\nAsistent:\n";
echo $asistent . "\n";

echo "\nProfesor:\n";
echo $profesor . "\n";

// Kreiranje dekana
$dekan = new Dekan("Karla", "Medenjak", "Dr.sc.");
echo "\nDekan:\n";
echo $dekan . "\n";

// Kreiranje kombinirane liste i brojanje tipova
$sveOsobe = array_merge($studenti, [$asistent, $profesor, $dekan]);
$brojacTipova = array_count_values(array_map(function($osoba) { return get_class($osoba); }, $sveOsobe));

echo "\nIzbroj sve vrste:\n";
foreach ($brojacTipova as $tip => $broj) {
  echo "{$tip}: {$broj}\n";
}

// Kreiranje dokumenta
$dokument = new Dokument("Zapisnik", "Ovo je tekst zapisnika.");
echo "\nDokument prije potpisivanja:\n";
echo $dokument . "\n";

// Kreiranje liste stavki za potpisivanje dekanu
$zaPotpis = [$predmet, $dokument];

// Dekan potpisuje stavke
foreach ($zaPotpis as $stavka) {
      $dekan->potpisi($stavka);
}
  
// Ispis predmeta i dokumenta nakon potpisivanja
echo "\nPredmet nakon odobrenja:\n";
echo $predmet . "\n";

echo "\nDokument nakon potpisivanja:\n";
echo $dokument . "\n";

 
  ?>
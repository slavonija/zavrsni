<?php

namespace RefactoringGuru\Singleton\RealWorld;

/**
 * Ako trebate podržati nekoliko vrsta Singletona u svojoj aplikaciji, možete
 * definirati osnovne značajke Singletona u osnovnoj klasi, dok stvarnu
 * poslovnu logiku (kao što je sakupljanje podataka (engl. logging))
 * premještate u podklase.
 */
class Singleton
{
    /**
     * Stvarna instanca singletona gotovo se uvijek nalazi unutar statičkog polja. 
     * U ovom slučaju, statičko polje je matrica, gdje svaka podklasa
     * singltona pohranjuje vlastitu instancu.
     */
    private static $instances = [];

    /**
     * Singletonov konstruktor ne bi trebao biti javan. Međutim,
     * ne može biti ni privatno ako želimo dopustiti podklase.
     */
    protected function __construct() { }

    /**
     * Kloniranje i deserializacija nisu dopušteni za singleton-ove.
     */
    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Nije moguće deserializirati singleton");
    }

    /**
     * Metoda koju koristite za dobivanje (engl. get) Singleton instance.
     */
    public static function getInstance()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            // Primijetite da ovdje koristimo ključnu riječ "static" umjesto
            // stvarnog naziva klase. U ovom kontekstu ključna riječ "static"
            // znači "ime trenutne klase". Taj je detalj važan jer kada se
            // metoda pozove na podklasi, želimo da se ovdje kreira instanca
            // te podklase.

            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }
}

/**
 * Klasa za sakupljanje podataka (engl. logging class) je najpoznatija i naj-
 * hvaljenija upotreba Singleton obrasca. U većini slučajeva, potreban vam je
 * jedan objekt za sakupljanje podataka (engl. logging object) koji zapisuje
 * u jednu log datoteku (kontrola nad zajedničkim resursom). Također vam je
 * potreban prikladan način za pristup toj instanci iz bilo kojeg konteksta
 * vaše aplikacije (globalna pristupna točka).
 */
class Logger extends Singleton
{
    /**
     * Pokazivač datoteke resursa log datoteke.
     */
    private $fileHandle;

    /**
     * Budući da se konstruktor Singletona poziva samo jednom, uvijek je
     * otvoren samo jedan resurs datoteke.
     *
     * Napomena, radi jednostavnosti, ovdje otvaramo tok konzole (engl.console
     * stream) umjesto stvarne datoteke.
     */
    protected function __construct()
    {
        $this->fileHandle = fopen('php://stdout', 'w');
    }

    /**
     * Zapiši log unos u resurs otvorene datoteke.
     */
    public function writeLog(string $message): void
    {
        $date = date('d.m.Y.');
        fwrite($this->fileHandle, "$date: $message\n");
    }

    /**
     * Samo zgodna prečica za  za smanjenje količine koda potrebnog za
     * bilježenje poruka iz koda klijenta.
     */
    public static function log(string $message): void
    {
        $logger = static::getInstance();
        $logger->writeLog($message);
    }
}

/**
 * Primjena Singleton uzorka na pohranu konfiguracije također je uobičajena
 * praksa. Često trebate pristupiti konfiguracijama aplikacije s mnogo 
 * različitih mjesta u programu. Singleton vam pruža tu udobnost.
 */
class Config extends Singleton
{
    private $hashmap = [];

    public function getValue(string $key): string
    {
        return $this->hashmap[$key];
    }

    public function setValue(string $key, string $value): void
    {
        $this->hashmap[$key] = $value;
    }
}

/**
 * Kod klijenta.
 */
Logger::log("Početak!");

// Usporedite vrijednosti Logger singleton.
$l1 = Logger::getInstance();
$l2 = Logger::getInstance();
if ($l1 === $l2) {
    Logger::log("Logger ima jednu instancu.");
} else {
    Logger::log("Logger-i su različiti.");
}

// Provjerite kako Config singleton sprema podatke...
$config1 = Config::getInstance();
$login = "test_login";
$password = "test_password";
$config1->setValue("login", $login);
$config1->setValue("password", $password);
// ...i vrati ih.
$config2 = Config::getInstance();
if ($login == $config2->getValue("login") &&
    $password == $config2->getValue("password")
) {
    Logger::log("Config singleton također radi dobro.");
}

Logger::log("Završeno!");
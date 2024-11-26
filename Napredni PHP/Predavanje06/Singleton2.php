<?php

/**
 * Klasa Singleton definira  `GetInstance` metodu koja služi kao alternativa
 * konstruktoru i omogućava klijentima da uvijek ponovo i ponovo pristupaju
 * istoj instanci ove klase.
 */
class Singleton
{
    /**
     * Instanca singltona pohranjena je u statičko polje. Ovo polje je matrica,
     *  jer ćemo dopustiti da naš Singleton ima podklase. Svaka stavka u ovoj
     * matrici bit će instanca određene Singletonove podklase. Vidjet ćete
     * kako ovo funkcionira za trenutak.
     */
    private static $instances = [];

    /**
     * Konstruktor Singletona uvijek bi trebao biti privatan kako bi se
     * spriječili izravni pozivi konstrukcije s `new` operatorom.
     */
    protected function __construct() { }

    /**
     * Singleton-ovi se ne bi trebali moći klonirati.
     */
    protected function __clone() { }

    /**
     * Singleton-ovi ne bi se trebali moći obnoviti iz stringova.
     */
    public function __wakeup()
    {
        throw new \Exception("Nije moguće deserializirati singleton.");
    }

    /**
     * Ovo je statička metoda koja kontrolira pristup singleton instanci.
     * Prilikom prvog pokretanja, stvara pojedinačni objekt i postavlja ga u
     * statičko polje. U narednim izvođenjima vraća postojeći objekt
     * klijenta pohranjen u statičkom polju.
     *
     * Ova implementacija vam omogućava potklasu klase Singleton dok
     * zadržavate samo jednu instancu svake podklase.
     */
    public static function getInstance(): Singleton
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Konačno, svaki singleton trebao bi definirati neku poslovnu logiku koja
     * se može izvršiti na njegovoj instanci.
     */
    public function someBusinessLogic()
    {
        // ...
    }
}

/**
 * Klijent kod.
 */
function clientCode()
{
    $s1 = Singleton::getInstance();
    $s2 = Singleton::getInstance();
    if ($s1 === $s2) {
        echo "Singleton radi, obje varijable sadrže istu instancu.";
    } else {
        echo "Singleton nije uspio, varijable sadrže različite instance.";
    }
}

clientCode();

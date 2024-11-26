<?php


class Example {
    private $privateData = "Private podatak";
    protected $protectedData = "Protected podatak";

    public function getPrivateData() {
        return $this->privateData; // Pristup private atributu unutar klase
    }
}

class DerivedExample extends Example {
    public function getProtectedData() {
        return $this->protectedData; // Pristup protected atributu u naslijeđenoj klasi
    }
}

$obj = new DerivedExample();
// Poziv metode koja pristupa privatnom atributu unutar klase
echo $obj->getProtectedData(); // "Protected podatak"
echo $obj->getPrivateData();   // Nema greške jer metoda pristupa privatnom svojstvu unutar nasljeđene klase
// direktno pristupanje privatnom svojstvu iz naslijeđene klase ili izvan objekta
echo $obj->privateData; // Fatal error: Cannot access private property

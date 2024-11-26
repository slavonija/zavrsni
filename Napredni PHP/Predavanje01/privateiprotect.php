<?php

class Example {
    private $privateData = "Private Data";
    protected $protectedData = "Protected Data";

    public function getPrivateData() {
        return $this->privateData; // Pristup privatnom atributu unutar klase
    }
}

class DerivedExample extends Example {
    public function getProtectedData() {
        return $this->protectedData; // Pristup zaštićenom atributu u naslijeđenoj klasi
    }
}

$obj = new DerivedExample();
echo $obj->getProtectedData(); // "Protected Data"
echo $obj->getPrivateData();   // Fatal error: Cannot access private property

<?php

// cilj je imati specifični exeption u svom kodu i uhvatiti i obraditi tu iznimku
class AccountException extends Exception{} 
 
class Account{
    private float $balance = 0; // imamo balance koji je 0

    public function __construct(bool $isSavings = false)
    {
        if($isSavings){
            throw new Exception("Saving account not suported");
        }
    }

    // kad nemamo return dobro je naznačiti što metoda vraća, a tu je to void jer ne vraća ništa - prima amount kao neki float
    public function deposit (float $amount) : void{
        // dalje provjeri da li je iznos manji ili jednak 0
        if ($amount <= 0) {
            // ako se dogodi da je amount jednak ili manji 0 onda imamo (specifičnu) iznimku
            throw new AccountException("Amount must be grater than 0"); 
            }
            $this->balance += $amount; 
    }
}

 $account = new Account(); // kreiramo account - dodali smo ga kasnije u try block
 $account->deposit(100); // to je happy path +100 = imamo balans 100
// $account->deposit(-100); // depozit ne može biti minus, za to radimo iznimku - ako ostavimo, baca grešku na ispisu var-dump
var_dump($account); // ispisuje 100


try{
    $account = new Account(true); // ako uklonimo true prikazat će Specific exception
    $account->deposit(-100); // ovo ispisuje General exception jer se dogodila greška, naravno ako u redu iznad nije true
    //$account->deposit(100); // ovo je happy path
    // stavili smo taj kod u try block jer je poželjno da bude tu ako imamo kod koji može generirati iznimku
    
    var_dump($account);
    // ako se dogodila iznimka, tj. PHP ju je uhvatio u objekt $e koji će biti stvoren u specijalnoj iznimci
}   catch(AccountException $e){
    echo "Specific exception: " . $e->getMessage();
}   catch(Exception $e){
    echo "General exception: " . $e->getMessage();
}

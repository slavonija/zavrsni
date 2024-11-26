<?php
// Kada je striktni tip uključen, PHP će sprovoditi provjeru tipa za sve varijable,
// argumente funkcije i tipove koje vraćaju funkcije. To znači da ako dodijelite
// vrijednost jednog tipa varijabli drugog tipa, PHP će izbaciti grešku s tipom
// (engl. type error). U ovom konkretnom slučaju, declare(strict_types=1);
// omogućava samo točan tip za cijelu skriptu.
declare(strict_types=1);

// 1. Zadatak
// Napiši funkciju koja vraća neki tekst.
// Pozovite funkciju i vraćenu vrijednost spremite u varijablu.
// Ispišite vrijednost varijable.

function vratiTekst(): string {     // string znači da očekuje vraćanje stringa
    return 'Ovo je neki tekst';
}

$tekst = vratiTekst();
echo $tekst;

function addNumbers($a, $b, $printResult = false) {
    $sum = $a + $b;
    if($printResult) {
        echo 'Suma je: ' . $sum;
    }
    return $sum;
}

$sum1 = addNumbers(1, 2);
$sum1 = addNumbers(1, 2, false);
$sum1 = addNumbers(5, 6, true); // rezultat je 5+6=11
$sum1 = addNumbers(b: 5, a: 5, printResult: true); // pozivanje imenovanih parametara, može bilo kojim redom
// ovo prikazuje rezultat 5+6



// 2. Zadatak
// Napiši funkciju koja ima dva parametra (name, surname).
// Funkcija treba konkatenirati name i suraname i zapisati u lokalnu varijablu.
// Zatim vrijednost u lokalnoj varijabli treba pretvoriti u velika slova.
// Funkcija treba vratiti vrijednost lokalne varijable.
// Pozovite funkciju i spremite vraćenu vrijednost u varijablu
// Ispišite vrijednost varijable.

echo $GLOBALS['tekst']; // tekst varijabla postaje globalna varijabla
unset($GLOBALS['tekst']);
//print_r($GLOBALS);

$age = 30;
function fullName(string $name, string $surname): string {
    $age = 40;
    $result = $name . ' ' . $surname . '' . $GLOBALS['age']; // iako je varijabla s istim imenom u funkciji, poziva onu def. van funkcije
    return mb_strtoupper($result);
}

$fullName = fullName('John','Doe'); // pozicijsko pozivanje parametara
echo $fullName . "<br>";

$fullName = fullName(surname:'Jane',name:'Doe'); // pozivanje imenovanih parametara, nije bitan je redosljed
echo $fullName . "<br>";


// 3. Callback funkcije
// array_filter je ugrađena funkcija. Ova funkcija ima 2 parametra: matricu i callback funkciju
// callback daje informaciju da li neki element iz ulazne matrice treba ostati u izlaznoj matrici
$parni = array_filter([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], function($value) {
    return $value % 2 === 0;    // vraća parne 2, 4, 5, 8, 10, za neparne staviti !==
});

print_r($parni);


// Custom array_filter funkcija bez korištenja callback funkcije
// kako će funkcija filtrirati provjerit ćemo u foreach petlji, ako zadovoljava smjestit ćemo u izlaznoj petlji
// ova customArrayFilter funkcija je eksplicitno definirana samo za jednu vrstu filtriranja
function customArrayFilter(array $array): array {
    $result = [];
    foreach($array as $key => $value) {
        if($value % 2 === 0) {  // vraća parne 2, 4, 5, 8, 10
            $result[] = $value;
        }
    }
    return $result;
}

$parni = customArrayFilter([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
print_r($parni);

// Custom array_filter funkcija sa korištenjem callback funkcije
// U ovoj funkciji uslov nije hardkodiran, uslov određuje callback funkcija
// Ovoj funkciji pošaljemo customiziranu callback funkciju i ona proširi funkcionalnost
function customArrayFilterCallback(array $matrica, callable $callback): array {
    $rezultat = [];
    foreach($matrica as $vrijednost) {
        if($callback($vrijednost)) {
            $rezultat[] = $vrijednost;
        }
    }
    return $rezultat; 
}

// Custom array_filter funkcija sa korištenjem callback funkcije
// ali se prenose i vrijednost ključa, kao u ulaznoj matrici
function customArrayFilterCallback2(array $matrica, callable $callback): array {
    $rezultat = [];
    foreach($matrica as $ključ => $vrijednost) {
        if($callback($vrijednost)) {
            $rezultat[$ključ] = $vrijednost;
        }
    }
    return $rezultat; 
}



// ovo poziva Custom array_filter funkcija sa korištenjem callback funkcije
$a = customArrayFilterCallback([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], function($value) {
    return $value & 1 == 1; // vraća neparne 1, 3, 5, 7, 9
});

$b = customArrayFilterCallback2([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], function($value) {
    return $value & 1 == 1; // vraća neparne 1, 3, 5, 7, 9
});

print_r($a);
print_r($b);

?>
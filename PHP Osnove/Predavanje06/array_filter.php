<?php

// Kreiraj matricu s 10 brojeva i izdvoji sve brojeve veće od 5 u novu matricu

$brojevi = [1,8,6,4,8,3,7,1,0,5];
// callback funkcija u {} - anonimna funkcija vraća veće ili jednake 10
$brojeviVeciOdPet = array_filter($brojevi, function($broj) {    // callback funkcija je između {}
    return $broj > 5;       // anonimna funkcija, ako umjesto $broj > 5 stavimo true, dobijemo sve brojeve
});

print_r($brojeviVeciOdPet); // rezultat je [1]=>8, [2]=>6, [4]=>8, [6]=>7


// ovo je simulacija array_filter funkcije, radi isto
function arr_filter(array $a, callable $callback): array {
    $newArray = [];
    foreach($a as $key => $value) {
        if($callback($value)) {
            $newArray[$key] = $value;
        }
    }
    return $newArray;
}
$a = arr_filter($brojevi, function($broj) {
    return $broj > 5;
});

print_r($a); // rezultat je [1]=>8, [2]=>6, [4]=>8, [6]=>7

// array_values() vraća sve vrijednosti matrice kao novu numerički indeksiranu matricu (odnosno, indeksiranu od 0 nadalje), bez obzira na izvorne ključeve u matrici.
$reindeksiraniBrojevi = array_values($brojeviVeciOdPet); // rezultat je [0]=>8, [1]=>6, [2]=>8, [3]=>7
$reindBrojevi = array_values($a); // ne radi, ostaje rezultat je [1]=>8, [2]=>6, [4]=>8, [6]=>7
print_r($reindeksiraniBrojevi);
print_r($a);

echo ($reindeksiraniBrojevi === $reindBrojevi);

//  array_map transformira svaki element, primjenjuje callback na elemente niza $a, // između {} callback funkcija
$izlazniNiz = array_map(function($broj) {
    return $broj * 2;
}, $a);

print_r($izlazniNiz); // rezultat je [1]=>16, [2]=>12, [4]=>16, [6]=>14

// Sortiranje rezultata jer nisu elementi prebačeni redom a to se traži u zadatku
sort($izlazniNiz);
$izlazniNiz = array_values($izlazniNiz); // rezultat je [0]=>12, [1]=>14, [2]=>16, [3]=>16
// Ispis rezultata
print_r($izlazniNiz);



?>
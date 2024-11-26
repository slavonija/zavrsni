<?php

// Kreiraj matricu (niz) koji sadrži imena 5 voćaka.
// Dodaj na kraj niza dvije nove voćke korištenjem uglatih zagrada i ugrađene php array funkcije.
// Izbriši prvi element u nizu.

// indeks kreće od 0
$fruits = ["jabuke", "banane", "narandže", "kivi", "mango"];

// ako napišemo broj van opsega dobit ćemo upozorenje Undefined array key i php se nastavi izvoditi
print_r($fruits[4]);

// dodavanje elemenata matrice
$fruits[] = "ananas";
$fruits[8] = "breskve";     // preskočimo 6 i 7
$fruits[] = "grožđe";       // ovo je 9, nastavlja

array_push($fruits, "kajsije");   // Pusha element na kraj matrice

// var_dump($fruits); // ispisuje ružno
print_r($fruits);     // ispisuje ljepše


 var_dump($fruits == false); // prazan niz je false

// brisanje
unset($fruits[0]);      // ukloni iz matrice ali ostavi rupu
array_shift($fruits);   // reindeksira sve elemente, dakle kreće od 0

print_r($fruits);

// kreirati 2 matrice koji sadrže po 3 broja
// Spoji ove 2 matrice u jednu

$prvi = [2,3,7];
$drugi = [2,5,9];
$spojeniNiz = array_merge($prvi, $drugi);

print_r($prvi);
print_r($drugi); 
print_r($spojeniNiz);

$spojeniNiz = [$prvi,$drugi];   // ovo pravi dvodimenzionalnu matricu [2,3,7][2,5,9]
print_r($spojeniNiz);

$spojeniNiz = [...$prvi,...$drugi];   // radi dekompoziciju 2D matrice na članove [2,3,7,2,5,9]
print_r($spojeniNiz);

// Kreiraj niz koji sadrži 5 ocjena. Izračunaj prosječnu ocijenu
$ocjene = [2,4,5,3,4];
$rezultat =  array_sum($ocjene) / count($ocjene);
print_r($rezultat);
echo $rezultat;

// Kreiraj matricu s 10 brojeva i izdvoji sve brojeve veće od 5 u novu matricu

$brojevi = [1,8,6,4,8,3,7,1,0,5];
$brojeviVeciOdPet = array_filter($brojevi, function($broj) {    // callback funkcija u {}
    return $broj > 5;       // anonimna funkcija, ako umjesto $broj > 5 stavimo true, dobijemo sve brojeve
});

print_r($brojeviVeciOdPet); // rezultat je [1]=>8, [2]=>6, [4]=>8, [6]=>7
$reindeksiraniBrojevi = array_values($brojeviVeciOdPet);
print_r($reindeksiraniBrojevi);

?>
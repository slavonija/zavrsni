<?php
/*

* Imate niz s brojevima. Vaš zadatak je filtrirati niz tako da ukloni sve brojeve manje od 10, zatim udvostručiti preostale brojeve, i na kraju vratiti novi niz s tim transformiranim elementima. Novonastali niz treba sortirati od najmanjeg prema najvećem broju.

* $ulazniNiz = [2, 5, 10, 15, 20, 25, 30, 3, 7, 8, 12, 17];

* Novi niz koji sadrži samo brojeve veće ili jednake 10 iz ulaznog niza, svaki udvostručen.

* Zabranjeno korištenje bilo kakvih petlji (for, foreach, while, do-while).

* Možete koristiti funkcije visokog reda za rad s nizovima kao što su array_filter, array_map, i slično.
* Ove funkcije, ali i druge koje vam mogu pomoći u rješavanju, možete pogledati na sljedećem linku.
* https://www.w3schools.com/php/php_ref_array.asp

* Rezultat koji trebate dobiti:
$izlazniNiz = [20, 24, 30, 34, 40, 50, 60]; 

*/

$ulazniNiz = [2, 5, 10, 15, 20, 25, 30, 3, 7, 8, 12, 17];

// Koristimo array_filter za filtriranje brojeva većih ili jednakih 10
$filtriraniNiz = array_filter($ulazniNiz, function($vrijednost) {   // callback funkcija u {}
    return $vrijednost >= 10;                                       // anonimna funkcija vraća veće ili jednake 10
});

//  array_map primjenjuje callback na elemente niza $filtriraniNiz, između {} callback funkcija
$izlazniNiz = array_map(function($vrijednost) {
    return $vrijednost * 2;
}, $filtriraniNiz);

print_r($izlazniNiz);

// Sortiranje rezultata jer nisu elementi prebačeni redom a to se traži u zadatku
sort($izlazniNiz);

// Ispis rezultata
print_r($izlazniNiz);

?>
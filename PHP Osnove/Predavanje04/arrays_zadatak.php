<?php
 
/**
 * Kreiraj matricu (niz) koji sadrži podatke o studentima
 * 
 * 1. Filtriraj studente koji imaju prosječnu ocjenu iznad 3.5
 * 2. Izračunaj prosječnu ocijenu svih studenata koji su prošli filtraciju
 * 3. Odredi broj studenata u svakoj godini studija
 */
 
 $studenti = [
    ["ime" => "Ana", "prezime" => "Anić", "godina" => 1, "prosjek" => 4.2],
    ["ime" => "Ivan", "prezime" => "Ivanić", "godina" => 2, "prosjek" => 3.1],
    ["ime" => "Marko", "prezime" => "Mrkovski", "godina" => 3, "prosjek" => 3.7],
    ["ime" => "Lucija", "prezime" => "Lucić", "godina" => 1, "prosjek" => 4.8],
    ["ime" => "Hrvoje", "prezime" => "Hrvatko", "godina" => 2, "prosjek" => 4.0],
 ];

 // Filtriraj studente koji imaju prosječnu ocjenu iznad 3.5
 $vrloDobriStudenti = array_filter($studenti, function($student) {
    return $student["prosjek"] > 3.5; // uglatom zagradom dolazimo do elementa dvodimenzionalne matrice
 });
print_r($vrloDobriStudenti); // nemamo Ivana Ivanića

// Izračunaj prosječnu ocijenu svih studenata koji su prošli filtraciju
// array_column vraća vrijednost iz jednog stupca matrice, identficiranog sa ključem, treba nam prosjek
$arrayProsjeka = array_column($vrloDobriStudenti, "prosjek");
print_r($arrayProsjeka);
$prosjekVrloDobrihStudenata = array_sum($arrayProsjeka) / count($vrloDobriStudenti);
print_r($prosjekVrloDobrihStudenata);

// array_column ovdje vraća vrijednost iz stupaca godina ali iz matrice $studenti a ne iz $vrloDobriStudenti
$arrayGodina = array_column($studenti, "godina");
// array_count_values broji pojavljivanje svake različite vrijednosti u matrici
$brojStudenataUSvakojGodini = array_count_values(($arrayGodina));
print_r($brojStudenataUSvakojGodini);

?>
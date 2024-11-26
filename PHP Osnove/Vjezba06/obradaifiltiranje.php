<?php
/*
U ovom zadatku, cilj je kreirati PHP skriptu koja koristi funkcije za obradu i filtriranje podataka 
prodaje. Imate listu prodaja predstavljenih kao asocijativni nizovi unutar višedimenzionalnog niza. 
Svaki asocijativni niz sadrži informacije o jednoj prodaji: 'ime_proizvoda', 'kategorija', 'cijena' 
i 'količina'.

Zadatak je napisati dvije funkcije. Prva funkcija treba filtrirati prodaje na temelju kategorije, 
a druga funkcija treba izračunati ukupni prihod od filtriranih prodaja.

Početni Podaci:*/
$prodaja = [
    ['ime_proizvoda' => 'Laptop', 'kategorija' => 'Elektronika', 'cijena' => 800, 'količina' => 10],
    ['ime_proizvoda' => 'Hladnjak', 'kategorija' => 'Aparati', 'cijena' => 600, 'količina' => 5],
    ['ime_proizvoda' => 'Smartphone', 'kategorija' => 'Elektronika', 'cijena' => 500, 'količina' => 15],
    ['ime_proizvoda' => 'Mikser', 'kategorija' => 'Aparati', 'cijena' => 100, 'količina' => 8],
    ['ime_proizvoda' => 'Televizor', 'kategorija' => 'Elektronika', 'cijena' => 1000, 'količina' => 7],
    ['ime_proizvoda' => 'Perilica', 'kategorija' => 'Aparati', 'cijena' => 750, 'količina' => 4],
    ['ime_proizvoda' => 'Sušilica', 'kategorija' => 'Aparati', 'cijena' => 800, 'količina' => 3],
    ['ime_proizvoda' => 'Slušalice', 'kategorija' => 'Elektronika', 'cijena' => 150, 'količina' => 20],
    ['ime_proizvoda' => 'Toster', 'kategorija' => 'Aparati', 'cijena' => 50, 'količina' => 10],
    ['ime_proizvoda' => 'Blender', 'kategorija' => 'Aparati', 'cijena' => 120, 'količina' => 6],
    ['ime_proizvoda' => 'Tablet', 'kategorija' => 'Elektronika', 'cijena' => 450, 'količina' => 12],
    ['ime_proizvoda' => 'Usisavač', 'kategorija' => 'Aparati', 'cijena' => 400, 'količina' => 5],
    ['ime_proizvoda' => 'Sokovnik', 'kategorija' => 'Aparati', 'cijena' => 300, 'količina' => 7],
];
/*
Zadaci:

    Napišite funkciju filtrirajPoKategoriji($prodaja, $kategorija) koja vraća niz prodaja samo iz 
    zadane kategorije.
    Napišite funkciju izracunajUkupniPrihod($filtrirane_prodaja) koja izračunava i vraća ukupni 
    prihod od prodaja u nizu koji joj je proslijeđen.

Upute:

    Koristite foreach petlje za iteraciju kroz nizove.
    Obratite pažnju na to da se prihod za svaku prodaju izračunava množenjem cijene i količine.
    Testirajte svoje funkcije s različitim kategorijama kako biste osigurali da vaš kod radi kako 
    treba.

Ovaj zadatak vam pruža priliku za vježbanje rada s funkcijama, asocijativnim nizovima,
kontrolnim strukturama kao što su petlje, te osnovama operacija sa nizovima u PHP-u. 
Nakon što završite, možete dodatno proširiti zadatak dodavanjem novih funkcionalnosti, 
kao što je sortiranje rezultata po cijeni ili količini.*/


//var_dump($prodaja);

$kategorija = 'Elektronika';

function filtrirajPoKategoriji($prodaja, $kategorija) {
    // ovo su postojeće kategorije u dvodimenzionalnoj matrici
    $resultArr = [];
    foreach($prodaja as $kategorija) {
        $resultArr = array_merge($resultArr, $kategorija);
    }        
    $kategorije = array_keys($resultArr);
    $to_remove = array('kategorija');
    // ostanu ostale grupe u matrici
    $kategorije = array_diff($kategorije, $to_remove);
    print_r($kategorije);

    $filtriraneProdaje = [];
    foreach ($prodaja as $value) {
        foreach ($value as $key => $value2) {
           echo $key . ": " . $value2 . PHP_EOL;
//            $filtiriraneProdaje[$key] = $value2;
              $nova = array($key => $value2);
              print_r($nova);
//            array_merge($filtiriraneProdaje, $nova);
        }
    }
    print_r($filtiriraneProdaje);
/*    
    foreach ($prodaja as $red) {        
        if ($red['kategorija'] == $kategorija) {
        foreach ($red as $red2)
            echo$red2 . "<br>"; 
//            $filtriraneProdaje[] = $prodaja;
        }
    }*/
    return $filtriraneProdaje;
}

$elektronika = filtrirajPoKategoriji($prodaja, $kategorija);
print_r($elektronika);

?>

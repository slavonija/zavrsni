<?php

const PODACI = "podaci.txt";

// Učitavanje txt datoteke
function loaddata(): array {
    $mat = []; $ima_li = 0;
    // ima li datoteke?
    if (!file_exists(PODACI)) {
        // ako ne postoji, vrati praznu matricu
        echo "Nema datoteke " . PODACI . "<br>";
        return [];
    }

    // čita datoteku u string, ako ne postoji prekini izvrsenje
    $datoteka = fopen(PODACI, "r");

    while(! feof($datoteka)) { // Čita red po red do kraja datoteke
        $red = fgets($datoteka); // učitaj jedan red i stavi ga u $red
        $dijelovi = explode(";", $red); // razdvoji $red na dijelove
        $ima_li = $ima_li + strlen(str_replace(";", "", $red));
        $mat2 = array("ime"=>$dijelovi[0], "prezime"=>$dijelovi[1], "godine"=>$dijelovi[2]); 
        array_push($mat, $mat2); // dodaj u dvodimenzionu matricu $mat matricu $mat2
    }
    fclose($datoteka);
    if ($ima_li < 3){
        echo "Nema podataka u datoteci " . PODACI . "<br>";
        return [];
    }
    else
        return $mat;    // vrati dvodimenzionu matricu
}


$a = loaddata();
print_r($a);
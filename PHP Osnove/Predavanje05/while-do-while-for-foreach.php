<?php

// while petlja
$i = 1;

while ($i <  4) {
    echo "Ovo je iteracija broj: $i\n";
    $i++;
}

// do-while petlja
$i = 1;
do {
	echo $i . " ";
	$i++;
} while ($i < 0);

// for petlja
for($i = 1; $i <= 10; $i++) {   // treba paziti da ne otvorimo beskonačnu petlju
    if($i ===3){
        continue;    // ako je $i = 3 preskočit ćemo petlju
    }
    echo $i . "<br>";
    // break;       // ako ovo stavimo nakon prvog puta zaustavit će se petlja
}



// asocijativna matrica s imenovanim ključevima, imena su ključevi a bodovi vrijednosti
$studenti =[
    "Ana" => 95,
    "Ivan" => 85,
    "Petar" => 75,
    "Maja" => 65,
    "Jasna" => 55,
    "Marko" => 45,
    "Iva" => 35,
    "Luka" => 25,
    "Klara" => 15,
    "Filip" => 5
];

// foreach petlja , $studenti je asoc. matrica, as  označava da se svakom
// prolasku petlje dodjeljuju ključ $ime i vrijednost $bodovi iz matrice
foreach ($studenti as $ime => $bodovi) {
    echo "Student/ica $ime je dobila/o ocjenu ";
    if ($bodovi > 92) {
        echo "odličan";
    } elseif($bodovi > 75) {
        echo "vrlo dobar";
    } elseif($bodovi > 62) {
        echo "dobar";
    } elseif($bodovi > 50) {
        echo "dovoljan";
    } else {
        echo "nedovoljan";
    }
    echo "<br>";
}

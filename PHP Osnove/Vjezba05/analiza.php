<?php
/*

Vježba 05 - Kontrolne strukture
Napisati PHP skriptu koja analizira niz brojeva i ispisuje rezultate analize. Analiza treba uključiti:

    Pronalaženje parnih i neparnih brojeva: Skripta treba razdvojiti parne i neparne brojeve iz originalnog niza te ih smjestiti u dva odvojena niza.
    Izračunavanje sume svih brojeva: Skripta treba izračunati ukupnu sumu svih brojeva u nizu.
    Pronalaženje najvećeg broja: Skripta treba pronaći i ispisati najveći broj u nizu.
    Filtriranje i ispis brojeva većih od prosječne vrijednosti: Izračunati prosječnu vrijednost svih brojeva u nizu, a zatim ispisati sve brojeve iz niza koji su veći od te prosječne vrijednosti.

Upute:

    Definirati početni niz s najmanje 10 proizvoljnih brojeva. $brojevi = [3, 7, 2, 8, 1, 4, 6, 9, 5, 10];
    Koristiti petlje (npr. foreach ili for) za iteriranje kroz niz.
    Koristiti if-else strukture za provjeru uvjeta (npr. je li broj paran ili neparan).
    Koristiti odgovarajuće funkcije za rad s nizovima gdje je to potrebno.

    */
    $brojevi = [3, 7, 2, 8, 1, 4, 6, 9, 5, 10];
    $parni = []; $neparni = [];
    $suma = 0; $brojač = 0; $max = 0;

    foreach ($brojevi as $broj) {
        $suma += $broj;
        $brojač = $brojač + 1;
        if ($broj > $max) {
            $max = $broj;
        }
        if ($broj % 2 == 0) {
            echo $broj . " je paran<br>";
            $parni[] = $broj;
        } else {
            echo $broj . " je neparan<br>";
            $neparni[] = $broj;
        }
    }
    
    $prosjek = $suma / $brojač;
    $većiOdProsjeka = array_filter($brojevi, function ($broj) use ($prosjek) {
        return $broj > $prosjek;
    });

    var_dump($parni) . "<br>";
    var_dump($neparni) . "<br>";
    echo "Suma svih brojeva je $suma<br>";
    echo "Najveći broj je $max<br>";
    echo "Prosječna vrijednost je $prosjek<br>";
    echo "Veći od prosjeka $prosjek su:<br>";
    print_r($većiOdProsjeka);

?>
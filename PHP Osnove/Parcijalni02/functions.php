<?php

// Samoglasnici - Prvo se riječ pretvara u mala slova, a zatim se prolazi
// kroz svaki znak u riječi i broji se ako je znak samoglasnik.
function countVowel($enterWord) {
    $samoglasnici = ['a', 'e', 'i', 'o', 'u'];
    $brojSamoglasnika = 0;

    foreach (str_split(strtolower($enterWord)) as $znak) {
        if (in_array($znak, $samoglasnici)) {
            $brojSamoglasnika++;
        }
    }
    return $brojSamoglasnika;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Provjeri da li je unešena riječ u input polje
    if (!empty($_POST["enterWord"])) {
        $enterWord = htmlspecialchars(trim($_POST["enterWord"])); // Sanitizacija unosa
        
        // Učitavanje postojećih podataka iz JSON datoteke
        $podaci = [];
        if (file_exists('words.json')) { // ako postoji datoteka
            $json_content = file_get_contents('words.json'); // učitaj je u varijablu
            if ($json_content !== false) {
                $podaci = json_decode($json_content, true) ?? []; // dekodiraj, ako nije dekodiraj
            }
        }

        // Provjera postoji li unesena riječ već u podacima
        $vec_postoji = false;
        foreach ($podaci as $item) {
            if (strcasecmp($item['enterWord'], $enterWord) == 0) { // uporedi neosjetljivo na velika/mala slova
                $vec_postoji = true;
                break;
            }
        }

        if (!$vec_postoji) {
            // Ako riječ ne postoji, dodaj je u podatke
            $brojSlova = strlen($enterWord);
            $brojSamoglasnika = countVowel($enterWord);
            $brojSuglasnika = $brojSlova - $brojSamoglasnika;

            // Dodavanje nove riječi u postojeće podatke na kraj matrice
            $podaci[] = array(
                'enterWord' => $enterWord,
                'brojSlova' => $brojSlova,
                'brojSuglasnika' => $brojSuglasnika,
                'brojSamoglasnika' => $brojSamoglasnika
            );

            // Spremanje ažuriranih podataka u JSON datoteku
            file_put_contents('words.json', json_encode($podaci, JSON_PRETTY_PRINT));
        }

        // Spriječavanje ponovnog slanja podataka na refresh
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    } else {
        echo "<p>Unesite riječ</p>";
    }
}
?>

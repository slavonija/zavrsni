<!DOCTYPE html>
<html lang="en">
<head>
    <!-- osigurava da stranica ispravno prikazuje dijakritičke znakove. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcijalni ispit</title>
</head>

<body>

<?php include 'functions.php'; ?>

<table border='0'cellpadding='20'>
    <tr>
        <h1><center>Upiši željenu riječ!</center></h1>     
        <td>   
            <!-- HTML forma za unos riječi -->
            <!-- Forma koristi POST metodu za slanje podataka na istu stranicu koristeći zaštitu od XSS -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Upišite riječ:</label><br>
                <!-- Unesi riječ u input polje a s dugmetom ga pošalji na server -->
                <input type="text" id="enterWord" name="enterWord" placeholder="Unesi neku riječ..." required><br><br>
                <button type="submit">Pošalji</button>
            </form>
        </td>
        <td>
            <?php
            // Učitavanje i prikaz prethodnih riječi iz words.json prilikom svakog učitavanja stranice
            if (file_exists('words.json')) { // Ako datoteka postoji
                $podaci = json_decode(file_get_contents('words.json'), true); // dekodiraj u varijablu
                if (!empty($podaci)) {
                    echo "<table border='1' cellspacing='2' cellpadding='5'>";
                    // Ispiši zaglavlje tablice
                    echo "<tr>
                          <th>Riječ</th>
                          <th>Broj slova</th>
                          <th>Broj suglasnika</th>
                          <th>Broj samoglasnika</th>
                          </tr>";

                    foreach ($podaci as $item) {
                        // Provjeri da li postoje ključevi 'enterWord', 'brojSlova', 'brojSuglasnika' i 'brojSamoglasnika' prije ispisa
                        if (isset($item['enterWord'], $item['brojSlova'], $item['brojSuglasnika'], $item['brojSamoglasnika'])) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item['enterWord']) . "</td>";
                            echo "<td>" . $item['brojSlova'] . "</td>";
                            echo "<td>" . $item['brojSuglasnika'] . "</td>";
                            echo "<td>" . $item['brojSamoglasnika'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                }
            }
            ?>
        </td>
    </tr>
</table>

</body>
</html>

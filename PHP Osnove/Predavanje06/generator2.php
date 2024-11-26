<?php
function generirajKljuceve() {
    yield "prvi" => "Jedan";
    yield "drugi" => "Dva";
    yield "treći" => "Tri";
}

foreach (generirajKljuceve() as $kljuc => $vrijednost) {
    echo "$kljuc: $vrijednost" . PHP_EOL;
}


?>
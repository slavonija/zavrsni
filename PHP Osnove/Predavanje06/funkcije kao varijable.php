<?php
// Ovo je omotač (engl. wrapper) funkcija oko echo naredbe
function pozdrav($ime) {
    echo "Pozdrav, $ime!";
}

$func = 'pozdrav';
$func('Marko'); // // Ovo poziva pozdrav()

$print_function = 'print_r';
$print_function('Hello, world!'); // Ispisuje "Hello, world!"


$print_function = 'printf';
$print_function('Goodbye, world!'); // Ispisuje "Goodbye, world!"


?>

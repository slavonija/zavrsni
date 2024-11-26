<?php
$square = function($x) {
    return $x * $x;
};

$result = $square(5);  // $result će biti 25


function math(int $a, int $b, callable $callback): int { // treći parametar bit će callable funkcija ("može se pozvati") proslijeđen kao argument
    return $callback($a, $b);
}

$a = math(2, 3, function(int $a, int $b): int {
    return $a + $b;
});
echo "Zbroj je: $a";

// Ovo je callback funkcija koju 'math' poziva
function add($a, $b) {
    // Zbroji dva integera i vrati rezultat
    return $a + $b;
}

echo add(5,10);
echo math(5,10,'add');

// Kreiraj varijablu koja sadrži 'add' ime funkcije
$zbroji = 'add';
echo $zbroji;

// Pozovi 'add' funkciju pomoću varijable koja sadrži njen naziv
// Ovo je isto kao pozivanje 'add(5, 10)'
echo $zbroji(5, 10);

?>

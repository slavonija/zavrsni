<?php


$x = "Naša slova su: ččćđšžČĆĐŠŽ";
echo substr($x, -6, 3) . "<br>";
echo mb_substr($x, -6, 3) . "<br>";

function removeEvenNumbers($number) {
    return $number % 2 !== 0;
}

$brojevi = [1,8,6,4,8,3,7,1,0,5];
$filteredNumbers = array_filter($brojevi, 'removeEvenNumbers');
print_r($filteredNumbers);


?>
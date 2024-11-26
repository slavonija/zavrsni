<?php

function countdown(int $number): int {
    if ($number === 0) {
        return 0;
    }
    echo $number . '<br>';
    return countdown($number - 1);
}

$a = countdown(3);



function faktorijal(int $number): int {
    if ($number === 1) {
        return 1;
    }   

    return $number * faktorijal($number - 1);
}

echo faktorijal(20); // 6=3*2*1
?>
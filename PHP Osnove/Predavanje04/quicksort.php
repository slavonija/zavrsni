<?php
function partition(array &$A, int $start, int $end): int {
    $i = $start + 1;
    $piv = $A[$start];  // Prvi element se uzima kao pivot

    for ($j = $start + 1; $j <= $end; $j++) {
        // Reorganiziraj niz tako da elementi manji od pivota budu na jednoj strani
        // a oni veći na drugoj.
        if ($A[$j] < $piv) {
            // Zamjeni elemente na poziciji $i i $j
            $temp = $A[$i];
            $A[$i] = $A[$j];
            $A[$j] = $temp;

            $i += 1;
        }
    }
    // Stavi pivot na njegovo odgovarajuće mjesto
    $temp = $A[$start];
    $A[$start] = $A[$i - 1];
    $A[$i - 1] = $temp;

    return $i - 1;  // Vrati poziciju pivota
}

function rand_partition(array &$A, int $start, int $end): int {
    // Odabiremo nasumično poziciju pivota između start i end
    $random = $start + rand(0, $end - $start);
    
    // Zamjenjujemo pivot s prvim elementom
    $temp = $A[$random];
    $A[$random] = $A[$start];
    $A[$start] = $temp;

    // Pozivamo standardnu partition funkciju
    return partition($A, $start, $end);
}

function quick_sort(array &$A, int $start, int $end): void {
    if ($start < $end) {
        // Pozicija pivot elementa
        // $piv_pos = partition($A, $start, $end);
        $piv_pos = rand_partition($A, $start, $end);  // Koristimo rand_partition umjesto partition
        
        // Sortiraj lijevu stranu pivota
        quick_sort($A, $start, $piv_pos - 1);
        
        // Sortiraj desnu stranu pivota
        quick_sort($A, $piv_pos + 1, $end);
    }
}

// Primjer upotrebe:
$A = [9, 7, 8, 3, 2, 1];
quick_sort($A, 0, count($A) - 1);

print_r($A);
?>

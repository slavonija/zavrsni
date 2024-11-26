<?php

// if kontrolna struktura
echo "Prije uslova.<br>";
if(4 > 3)
{
    echo "Uslov je ispunjen.<br>";
}
if (3 > 4) {
    echo "Uslov nije ispunjen.<br>";
}
echo "Poslije uslova.<br>";

// if-else kontrolna struktura
if (2 > 3)
{
    echo "Uslov je ispunjen.<br>";
} else {
    echo "else se izvršava se samo ako uslov u bloku nije ispunjen.<br>";
}

// if-elseif-else kontrolna struktura
if (4 > 5)
{
    echo "Uslov nije ispunjen.<br>";
} elseif (4 > 4) {
    echo "Uslov nije ispunjen.<br>";
}
 elseif (4 == 4) {
    echo "Ispunjen je uslov.<br>";
} elseif (4 > 2) {
    echo "Ne ocjenjuje se.<br>";
} else {
    echo "Ne ocjenjuje se.<br>";
}
if (4==4) {
    echo "Ispunjen je uslov.<br>";
}


// PHP skripta koja provjerava koji je dan u tjednu i ispisuje odgovarajuću poruku sa switch petljom

$danUTjednu = date("N");

switch($danUTjednu) {
    case 1:
        echo "Danas je ponedjeljak";
        break;
    case 2:
        echo "Danas je utorak";
        break;
    case 3:
        echo "Danas je srijeda";
        break;
    case 4:
        echo "Danas je četvrtak";
        break;
    case 5:
        echo "Danas je petak";
        break;
    case 6:
        echo "Danas je subota";
        break;
    case 7:
        echo "Danas je nedjelja";
        break;
    default:
        echo "Nepoznat dan";
        break;
}

?>

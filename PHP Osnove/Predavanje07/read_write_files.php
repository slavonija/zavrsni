<?php

$filename = 'names.txt';

// Otvori datoteku za čitanje
$resource = fopen($filename, 'r') or die('Ne mogu otvoriti datoteku $filename');
// pročitaj sve iz datoteke
echo fread($resource, filesize($filename));
// obavezno zatvori datoteku
fclose($resource);


// Otvori datoteku za pisanje
$resource = fopen($filename, 'a');
// nadodaj novu stavku u datoteku
//fwrite($resource, "\nJohn Doe"); // može i ovako
fwrite($resource, PHP_EOL . "John Doe");
// obavezno zatvori datoteku
fclose($resource);

// Otvori datoteku za čitanje
$resource = fopen($filename, 'r') or die('Ne mogu otvoriti datoteku $filename za čitanje');
$names = [];    // prazna matrica
while (!feof($resource)) {
    $name = fgets($resource);
    if (trim($name)) {
        $names[] = $name;
    }
}
fclose($resource);
var_dump($names);    

?>

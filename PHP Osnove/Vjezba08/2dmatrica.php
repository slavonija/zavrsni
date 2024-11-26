<?php
include_once 'constants.php'; // uključuje datoteku samo prvi puta
include_once 'functions.php';



/* ----------- Zadana indeksna matrica ----------- */
$zaposleni = [
    [1,"Branko","manager",2500],
    [2,"Sanja","voditelj prodaje",2000],
    [3,"Filip","operator",1200],
    [4,"Dinko","vozač",800]
];
foreach ($zaposleni as list($id, $ime,$posao,$plaća)) {
echo "$id $ime $posao $plaća </br>";
}


/* ispiši u tablici */
echo "<table border='1px' cellpadding='5px' cellspacing='0'>
  <tr>
      <th>Id. broj</th>
      <th>Ime zaposlenog</th>
      <th>Posao koji obavlja</th>
      <th>Plaća</th>
  </tr>";
foreach ($zaposleni as list($id, $ime,$posao,$plaća)) {
echo "<tr><td>$id</td><td>$ime</td><td>$posao</td><td>$plaća</td></tr>";
}
echo "</table>";


/* ----------- Zadana multidimenziona asocijativna matrica----------- */
$zaposleni = [
    ["id" => 1,"ime" => "Branko","posao" => "Manager","plaća" => 2500],
    ["id" => 2,"ime" => "Sanja","posao" => "voditelj prodaje","plaća" => 2000],
    ["id" => 3,"ime" => "Filip","posao" => "operator","plaća" => 1200],
    ["id" => 4,"ime" => "Dinko","posao" => "vozač","plaća" => 800]
];

foreach ($zaposleni as list("id" => $id, "ime" => $ime,"posao" => $posao,"plaća" => $plaća)) {
  echo "Id: $id; Ime: $ime; Posao: $posao; Plaća: $plaća</br>";
}


$todoall = loadToDo();
$rezultat = [];

foreach ($todoall as $id => $todo):
    $rezultat[$id]["id"] = $todo["id"]; 
    $rezultat[$id]["task"] = $todo["task"];
    $rezultat[$id]["finished"] = $todo["finished"];
    echo $rezultat[$id]["id"] . "<br>";
    echo $rezultat[$id]["task"] . "<br>";
    echo $rezultat[$id]["finished"] ? 'true' : 'false' , '<br><br>';
endforeach;

$rezultat = [];


foreach ($todoall as ["id" => $id, "task" => $task, "finished" => $finished]):
    echo "id: $id, Zadatak: $task" . "<br>";
endforeach;





?>
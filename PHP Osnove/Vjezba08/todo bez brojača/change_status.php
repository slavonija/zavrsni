<?php
include_once 'constants.php';
include_once 'functions.php';

$todoall = loadToDo(); // Učitavanje todo liste iz json datoteke
var_dump($brisi);
$todoName = $_POST['todo_name'];

$todoall[$todoName]['finished'] = isset($_POST['status']);

saveToDo($todoall); // Spremi todo liste u json datoteku
header('Location: index.php');
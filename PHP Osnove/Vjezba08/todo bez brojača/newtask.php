<?php
include_once 'constants.php';
include_once 'functions.php';

$todoall = loadToDo(); // Učitavanje todo liste iz json datoteke

if (isset($_POST['todo_name'])){
    $todoName = $_POST['todo_name'];
    $todoall[$todoName] = ['finished' => false];
}

saveToDo($todoall); // Spremi todo liste u json datoteku
header('Location: index.php');
?>
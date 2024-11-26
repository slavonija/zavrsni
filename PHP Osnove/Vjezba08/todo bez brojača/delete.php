<?php
include_once 'constants.php';
include_once 'functions.php';
$todoName = $_POST['todo_name'];

$todoall = loadToDo(); // Učitaj todo listu iz json datoteke

//$todoall = json_decode(file_get_contents(TODO_FILE), true);
unset($todoall[$todoName]);


saveToDo($todoall); // Spremi todo liste u json datoteku
header('Location: index.php');
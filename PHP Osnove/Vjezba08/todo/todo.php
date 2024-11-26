<?php

$todo_file = 'tasks.json';

// Učitavanje todo liste iz json datoteke
function loadToDo($todo_file) {
    if (!file_exists($todo_file)) {
        return [];
    } else {
        // čita datoteku u string, ako ne postoji vrati false
        $json = file_get_contents($todo_file);
        return json_decode($json, true);
    }
}

// Spremanje todo liste u json datoteku
// prvi parametar šalje matricu sa todo listom, idući parametar šalje putanju
function saveToDo($tasks, $todo_file) {
    // Spremanje i slanje na pohranu
    $json = json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // Ako ne postoji, kreiraj datoteku
    file_put_contents($todo_file, $json);
}

// Dodavanje (pohranjivanje) novog taska
function addTask($task, $todo_file) {
    $tasks = loadToDo($todo_file); // učitaj todo listu iz JSONa
        // Odredi maksimalnu vrijednost iz jednog stupca u ulaznoj matrici, ako nema zapisa vrati 1
    // array_column pronađe u višedimenzionoj matrici ključ ID i sve vrijednosti koje pronađe generira u novu matricu
    $newId = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;
    $tasks[] = [
        'id' => $newId,
        'task' => $task];
    saveToDo($tasks, $todo_file); // spremi todo listu u JSON
}

// Brisanje taska iz todo liste
function deleteTask($taskId, $todo_file) {
    $tasks = loadToDo($todo_file); // učitaj todo listu iz JSONa
    foreach ($tasks as $id => $task) { // izvrti todo dok ne pronađeš ID za brisanje
        if ($task['id'] == $taskId) { // kada ga pronađeš
            array_splice($tasks, $id, 1); // ukloni tu matricu iz matrice (matrica, start, dužina)
            break;  // izađi iz petlje
        }
    }
    saveToDo($tasks, $todo_file); // spremi todo listu u JSON
}


// Provjera requesta korisnika
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // da li je poslano POST metodom
    // ako postoji varijabla task i nije prazna, pritisnuo je dugme Add task, dodaj novi task
    if (isset($_POST['task']) && !empty(trim($_POST['task']))) {
        addTask(trim($_POST['task']), $todo_file);
    // ako postoji varijabla delete i nije prazna, pritisnuo je dugme Delete na nekom tasku, briši taj task
    } elseif (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
        deleteTask($_POST['delete'], $todo_file);
    }

    // Preusmjeravanje na samog sebe nakon obrade POST zahtjeva, restart datoteke
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$tasks = loadToDo($todo_file);

?>

<!-- HTML dio za novi task i prikazivanje postojećih -->
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
</head>
<body>    
    <h1>Todo List</h1>
    
    <!-- forma za novi task i dugme -->
    <form method="post">
        <input type="text" name="task" placeholder="Enter your new task">
        <button type="submit">Add Task</button>
    </form>

    <!-- nacrtaj tablicu -->
    <?php echo "<br>" ."<table border='1px' cellpadding='5px' cellspacing='0'>
    <tr>
        <th>Task</th><th>Delete Task</th>
    </tr>" ?>
    
    <!-- provrti petlju sa taskovima i dugmadi -->
    <?php foreach ($tasks as $task): ?>
        <echo "<tr><td><?php echo htmlspecialchars($task['task']);?></td><td style="text-align: center">
        <form method="post" style="display:inline;">
            <!-- ako pritisne dugme, pošalji ID taska -->
            <button type="submit" name="delete" value="<?php echo $task['id'];?>">Delete</button>
        </form>
        <?php echo "</td></tr>"; ?>
    <?php endforeach; ?>
    <?php echo "</table>"; ?>

</body>
</html>

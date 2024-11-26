<?php

include_once 'constants.php'; // uključuje datoteku samo prvi puta


// Učitavanje todo liste iz json datoteke.
function loadToDo(): array {
    // pokušava dohvatiti json datoteku
    if (!file_exists(TODO_FILE)) {
        return [];
    }
    // čita datoteku u string, ako ne postoji vrati false a taj slučaj je pokriven
    $todo = file_get_contents(TODO_FILE);

    return json_decode($todo, true);
}

// Spremanje todo liste u json datoteku
// prvi parametar šalje matricu sa todo listom, idući parametar šalje putanju
function saveToDo(array $todo): void {
    // Spremanje i slanje na pohranu
    $jsonToDo = json_encode($todo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // Ako ne postoji, kreiramo datoteku iz konstante
    file_put_contents(TODO_FILE, $jsonToDo);
}

/*saveToDo([
    [
        'id' => 1,
        'task' => 'Napraviti sarmu'
    ],
    [
        'id' => 2,
        'task' => 'Napisati zadaću'
    ],
    [
        'id' => 3,
        'task' => 'Zaraditi 100 € svaki dan'
    ]
    ]);*/


// Dodavanje (pohranjivanje) novog taska
function addTask(string $task): int {
    $todo = loadToDo(); // učitaj todo listu iz JSONa
    // Odredi maksimalnu vrijednost iz jednog stupca u ulaznoj matrici, ako nema zapisa vrati 1
    // array_column pronađe u višedimenzionoj matrici ključ ID i sve vrijednosti koje pronađe generira u novu matricu
    $newId = empty($todo) ? 1 : max(array_column($todo, "id")) + 1;
    $todo[] = [
        "id" => $newId,
        "task" => $task
    ];
    saveToDo($todo); // spremi todo listu u JSON

    return $newId; // ono što izlazi iz funkcije je novi ID
}

// Ažuriranje postojeći task
// ? ispred argumenta znači da vrijednost koju šaljemo ne mora biti string, možemo pisati string | null
// null govori da ne postoji nikakva vrijednost, vraća bool da bi smo vratili logičku vrijednost
function updateTask(int $id, ?string $task = null): bool{
    $todo = loadToDo(); // učitaj cijelu todo listu iz JSON dototeke

    foreach($todo as &$task){ // petlja prolazi po elementima
        // radimo referenciranje i tako mijenjanjem podatka na task varijabli mijenjamo podatak u matrici
        if($task["id"] === $id){ // da li je id elementa jednak ulaznom elementu
            
            // Vrijednost je expr1 (lijevo) ako expr1 postoji, a nije NULL.
            // Ako expr1 (lijevo) ne postoji ili je NULL vrijednost je expr2 (desno)
            $task["task"] = $task ?? $task["task"];
            saveToDo($todo);
            return true;
        }
    }


    // ovako bi glasila petlja ako ne želimo koristiti referencu
    // foreach($todo as $key => $task){
    //     if($task["id"] === $id){
    //         $todo[$key]["task"] = $task ?? $task["task"];
    //         saveToDo($todo);
    //         return true;
    //     }
    // }

    return false;
}

// Dohvati task po ID-u
// Ako neko pošalje id taska a njega nema tada treba vratiti null,
// dakle za izlaz je dovoljno ?array
function getTaskById(int $id): ?array{
    $todo = loadToDo();
    // trebamo dobiti podatke o jednoj knjizi (jedan slog)
    // prođi petljom po svakom elementu matrice, svaki task je nova matrica
    // kada pronađe element dobili smo task i izlazimo sa return
    foreach ($todo as $task) {
        if ($task["id"] === $id) {
            return $task;
        }
    }

    return null;
}

// Brisanje taska iz todo liste po ID-u
function deleteTask(int $id): bool{
    $todo = loadToDo();
    // koristi $id koji bi inače bio van scope-a, use će to dozvoliti
    //  u callback funkciji time koristimo varijablu roditeljske funkcije
    // use ne funkcionira kada imamo imenovane funkcije
    // nego samo sa anonimnim funkcijama
    $newToDo = array_filter($todo, function($task) use ($id){
        return $task["id"] !== $id;
    });
    // ako se broj taskova ne razlikuje vraćamo false
    if(count($todo) === count($newToDo)){
        return false;
    }
    // snimi todo listu ako se broj taskova razlikuje
    saveToDo($newToDo);

    return true;
}
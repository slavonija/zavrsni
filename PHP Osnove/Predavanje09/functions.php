<?php

include_once 'constants.php'; // uključuje datoteku samo prvi puta što je dobra praksa

// Učitavanje knjiga iz json datoteke.
function loadBooks(): array {
    // pokušava dohvatiti json datoteku
    if (!file_exists(BOOKS_FILE)) {
        return [];
    }
    // čita datoteku u string, ako ne postoji vrati false a taj slučaj je pokriven
    $books = file_get_contents(BOOKS_FILE);

    return json_decode($books, true);
}

// Spremanje knjiga u json datoteku
// prvi parametar šalje matricu sa knjigama, idući parametar šalje putanju
function saveBooks(array $books): void {
    $jsonBooks = json_encode($books, JSON_PRETTY_PRINT);
    file_put_contents(BOOKS_FILE, $jsonBooks);
}

// Dodavanje (pohranjivanje) nove knjige
function addBook(string $title, string $author, int $year, string $imagePath): int {
    $books = loadBooks(); // učitaj knjige iz JSONa
    // Odredi maksimalnu vrijednost iz jednog stupca u ulaznoj matrici, ako nema zapisa vrati 1
    // array_column pronađe u višedimenzionoj matrici ključ ID i sve vrijednosti koje pronađe generira u novu matricu
    $newId = empty($books) ? 1 : max(array_column($books, "id")) + 1;
    $books[] = [
        "id" => $newId,
        "title" => $title,
        "author" => $author,
        "year" => $year,
        "image" => $imagePath // dodano za pohranjivanje linka
    ];
    saveBooks($books); // spremi knjige u JSON

    return $newId; // ono što izlazi iz funkcije je novi ID
}

// Ažuriranje postojeće knjige
// ? ispred argumenta znači da vrijednost koju šaljemo ne mora biti string, možemo pisati string | null
// null govori da ne postoji nikakva vrijednost, vraća bool da bi smo vratili logičku vrijednost
function updateBook(int $id, ?string $title = null, ?string $author = null, ?int $year = null): bool{
    $books = loadBooks(); // učita sve knjige iz JSON-a

    foreach($books as &$book){ // petlja prolazi po elementima
        // radimo referenciranje i tako mijenjanjem podatka na book varijabli mijenjamo podatak u matrici
        if($book["id"] === $id){ // da li je id elementa jednak ulaznom elementu
            $book["title"] = $title ?? $book["title"];
            $book["author"] = $author ?? $book["author"];
            $book["year"] = $year ?? $book["year"];
            saveBooks($books);
            return true;
        }
    }

    // ovako bi glasila petlja ako ne želimo koristiti referencu
    // foreach($books as $key => $book){
    //     if($book["id"] === $id){
    //         $books[$key]["title"] = $title ?? $book["title"];
    //         $books[$key]["author"] = $author ?? $book["author"];
    //         $books[$key]["year"] = $year ?? $book["year"];
    //         saveBooks($books);
    //         return true;
    //     }
    // }

    return false;
}

// Dohvati knjigu po ID-u
// Ako neko pošalje ID koji ne postoji tada treba vratiti null,
// dakle za izlaz ?array = array | null
function getBookById(int $id): ?array{
    $books = loadBooks();
    
    // trebamo dobiti podatke o jednoj knjizi (jedan slog)
    // prođi petljom po svakom elementu matrice, svaka knjiga je nova matrica
    // kada pronađe element dobili smo knjigu i izlazimo sa return
    foreach ($books as $book) {
        if ($book["id"] === $id) {
            return $book;
        }
    }

    return null;
}

// Brisanje knjige po ID-u
function deleteBook(int $id): bool{
    $books = loadBooks();

    // koristi $id koji bi inače bio van scope-a, use će to dozvoliti
    //  u callback funkciji time koristimo varijablu roditeljske funkcije
    // use ne radi s imenovanim funkcijama nego samo s anonimnim
    $newBooks = array_filter($books, function($book) use ($id){
        return $book["id"] !== $id;
    });
    // ako se broj knjiga ne razlikuje vracamo false
    if(count($books) === count($newBooks)){
        return false;
    }

    saveBooks($newBooks);

    return true;
}
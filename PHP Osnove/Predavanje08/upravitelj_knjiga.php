<?php

const BOOK_FILE = 'knjige.json';

// Učitavanje knjiga iz JSON datoteke
function loadBooks(string $path = BOOK_FILE): array {
    // pokušava dohvatiti JSON datoteku
    if (!file_exists($path)) {
        return [];
    }
    $books = file_get_contents($path); // false ako nije pronađena datoteka

    return json_decode($books, true);
}

$array = loadBooks();
//$array = "Nova knjiga";
var_dump($array);


// Spremanje knjiga u JSON datoteku
// prvi parametar šalje matricu sa knjigama, idući parametar šalje putanju
function saveBooks(array $books, string $path = BOOK_FILE): void {
    // Spremanje i slanje na pohranu
    $jsonBooks = json_encode($books, JSON_PRETTY_PRINT);
    // Ako ne postoji, kreiramo
    file_put_contents($path, $jsonBooks);
}

saveBooks([
    [
        'id' => 1,
        'title' => 'Harry Potter',
        'author' => 'J.K. Rowling',
        'year' => 1997
    ],
    [
        'id' => 2,
        'title' => 'The Lord of the Rings',
        'author' => 'J.R.R. Tolkien',
        'year' => 1995
    ],
    [
        'id' => 3,
        'title' => 'The Great Gatsby',
        'author' => 'F. Scott Fitzgerald',
        'year' => 1925
    ]
    ]);

// Dodavanje (pohranjivanje) nove knjige
function addBook(string $title, string $author, int $year): int {
    $books = loadBooks();   // učitaj knjige iz JSONa
    // Odredi maksimalnu vrijednost iz jednog stupca u ulaznoj matrici, ako nema zapisa vrati 1
    // array_column pronađe u višedimenzionoj matrici ključ ID i sve vrijednosti koje pronađe generira u novu matricu
    $newId = empty($books) ? 1 : max(array_column($books, "id")) + 1; 
    // dodaj podatak o knjizi
    $books[] = [
        'id' => $newID,
        'title' => $title,
        'author' => $author,
        'year' => $year
    ];
    saveBooks($books);      // spremi knjige u JSON
    // vrati ID
    return $newId;          // ono što izlazi iz funkcije je novi ID
}

// Ažuriranje postojeće knjige
// ? ispred argumenta znači da vrijednost koju šaljemo ne mora biti string, možemo pistai string | null
// null govori da ne postoji nikakva vrijednost, vraća bool da bi smo vratili logičku vrijednost
function updateBook(int $id,  ?string $title = null, ?string $author = null, ?int $year = null): bool {
    $books = loadBooks();   // učita sve knjige iz JSON-a
    $book = getBookById($id); // dohvati knjigu po ID-u
    foreach($books as &$book){   // petlja prolazi po elementima
        // radimo referenciranje i tako mijenjanjem podatka na book varijabli mijenjamo podatak u matrici
        if($book['id'] === $id){    // da li je id elementa jednak ulaznom elementu
            // ako je null uzmi vrijednost sa desne strane, to je vrijednost koja je bila prije,
            // ako vrijednost prilikom update-a nije poslana (došao je null)vraća vrijednost koja je bila
            // ako u title nije null zapiši tu vrijednost
            $book['title'] = $title ?? $book["title"];
            $book['author'] = $author ?? $book["author"];
            $book['year'] = $year ?? $book["year"];
            saveBooks($books);
            return true;    // zavšavamo petlju nakon update-a i vracamo true
        }
    }
    return false;
}

// ovako bi glasila petlja ako ne želimo koristiti referencu
/*foreach($books as $key => $book){   // petlja prolazi po elementima
    // radimo referenciranje i tako mijenjanjem podatka na book varijabli
    // mijenjamo podatak u matrici
    if($book['id'] === $id){    // da li je id elementa jednak ulaznom elementu
        // ako je null uzmi vrijednost sa desne strane,
        //  to je vrijednost koja je bila prije,
        // ako vrijednost prilikom update-a nije poslana (došao je null)vraća vrijednost koja je bila
        // ako u title nije null zapiši tu vrijednost
        $book[$key]['title'] = $title ?? $book["title"];
        $book[$key] ['author'] = $author ?? $book["author"];
        $book[$key] ['year'] = $year ?? $book["year"];
        saveBooks($books);
        return true;    // zavšavamo petlju nakon update-a i vracamo true
    }
}
return false;
}*/


// funkciju za ažuriranje možemo provjeriti na sljedeći način
updateBook(id: 1, year:1998);


// Dohvati knjigu po ID-u
// Ako neko pošalje id knjige a nje nema tada treba vratiti null,
// dakle za izlaz je dovoljno ?array
function getBookById(int $id): ?array{
    $books = loadBooks();
    // trebamo dobiti podatke o jednoj knjizi (jedan slog)
    // prođi petljom po svakom elementu matrice, svaka knjiga je nova matrica
    // kada pronađe element dobili smo knjigu i izlazimo sa return
    foreach ($books as $book) {
        if ($book['id'] === $id) {
            return $book;
        }
    }
//    array_map(function($book) {
//        if ($book['id'] === $id) {
//            return $book;
//        }
//    }, $books);
      return null;
}

// Brisanje knjige po ID-u
function deleteBook(int $id): bool {
    $books = loadBooks();
    // koristi $id koji bi inače bio van scope-a, use će to dozvoliti
    //  u callback funkciji time koristimo varijablu roditeljske funkcije
    // use ne funkcionira kada imamo imenovane funkcije
    // nego samo sa anonimnim funkcijama
    $newBooks = array_filter($books, function($book) use ($id){
        return $book['id'] !== $id;
    });
    // ako se broj knjiga ne razlikuje vracamo false
    if(count($newBooks) === count($books)){
        return false;
    }
    // spremi knjige ako se broj knjiga ne razlikuje
    saveBooks($newBooks);
    return true;
}

var_dump(deleteBook(4));





?>
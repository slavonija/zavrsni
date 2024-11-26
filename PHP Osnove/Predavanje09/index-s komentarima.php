<?php 
include_once 'functions.php'; 
/*
session_start();
session_regenerate_id();

var_dump($_COOKIE["username"]);

if($_SESSION["username"] !== "admin"){
    header("Location: login.php");
    exit;
}*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Manager</title>
</head>
<body>
    <table border="1" cellspacing="5" cellpadding="15">
        <tr>
            <td width="50%" valign="top">
                <h1>Books</h1>
                <?php
                    $books = loadBooks();
                    // ne može sa filesize() = 0 jer želimo vidjeti sadržaj matrice
                    if($books): // ako je loadBooks vratio matricu u kojoj nešto ima
                ?>
                <table width="100%">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                    </tr>
                    <?php foreach($books as $book): ?> <!-- u $book nalazi se asocijativna matrica -->
                        <tr>
                            <!-- superglobalna varijabla $_SERVER['PHP_SELF'] daje naziv datoteke
                            u odnosu na korijen dokumenta, često se koristi za self request -->
                            <td>
                                <?php 
                                    echo "<a href=\"".$_SERVER['PHP_SELF']."?id=".$book['id']."\">".$book['title']."</a>" 
                                ?>
                            </td>
                            <td><?php echo $book['author'] ?></td>
                            <td><?php echo $book['year'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
                <?php else: ?> <!-- a ako je loadBooks vratio null ili praznu matricu -->
                    <p>No books!</p>
                <?php endif ?>

            </td>
            <td width="50%" valign="top">
                <h1>Add Book</h1> <!-- ovdje dodajtemo naslov
                    napravit ćemo formu POST metodom jer želimo slati datoteke
                     echo $_SERVER['PHP_SELF'] znači da će action biti na istu datoteku,
                     isto ako je i prazan, može biti naveden i neka php datoteka
                     validaciju je privremeno moguće ugasiti sa novalidate ključnom riječi
                     forma mora biti podešena da bi smo mogli binarne podatke poslati i zato
                     obavezno staviti  enctype="multipart/form-data" je ne ide bez toga -->
                <form action="" method="post" novalidate enctype="multipart/form-data">
                    <p>
                        <label for="title">Title:</label>
                        <!-- ne smijemo preskočiti name ni za jednu labelu!
                             require je oznaka da je polje obavezno -->
                        <input type="text" name="title" id="title" required>
                    </p>
                    <p>
                        <label for="author">Author:</label>
                        <input type="text" name="author" id="author" required>
                    </p>
                    <p>
                        <label for="year">Year:</label>
                        <input type="number" name="year" id="year" required>
                    </p>
                    <p>
                        <label for="cover">Book Cover:</label>
                        <input type="file" name="cover" id="cover" required>
                    </p>
                    <p>
                        <button type="submit">Add Book</button>
                    </p>
                </form>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") { // da li se zahtjev aktivirao s $_POST metodom
                        //  podaci završavaju u superglobalnoj varijabli $_POST a datoteka završava u $_FILES
                        // print_r("<pre>");
                        // var_dump($_POST);
                        // var_dump($_FILES);
                        $title = htmlentities($_POST["title"]);
                        $author = htmlentities($_POST["author"]);
                        $year = htmlentities($_POST["year"]);
                        // višedimenzionalna matrica koju dohvatamo iz superglobalne $_FILES
                        $cover = $_FILES["cover"];
                        //var_dump($cover);
                        // ovime osiguravamo da mora napraviti upload, UPLOAD_ERR_OK je zamjena za 0
                        if ($cover["error"] === UPLOAD_ERR_OK) { // da li se zahtjev aktivirao s $_POST metodom
                            $targetDir = "uploads/"; // definiramo target direktorij
                            // dodan time da ne bi bilo pregaženih datoteka, dobra praksa
                            $targetFile = $targetDir . time() . "_" . basename($cover["name"]);

                            if(move_uploaded_file($cover["tmp_name"], $targetFile)){
                                $id = addBook($title, $author, $year, $targetFile);
                                echo "<p>Book added with id: $id</p>";
                                // ovo pravi GET request i refresh stranice
                                header("Location: ". $_SERVER['PHP_SELF']);
                            } else {
                                echo "<p>Failed to add new book!</p>";
                            }
                        } else {
                            echo "<p>Failed to upload file!</p>";
                        }
                    }
                ?>
            </td>
        </tr>
    </table>

    <?php
        
        if (isset($_GET["id"])):
            $id = htmlentities($_GET["id"]);
            $book = getBookById($id);

            if ($book):
    ?>
        <table width="100%">
            <tr>
                <td width="50%">
                    <img src="<?php echo $book['image'] ?>" width="50%">
                </td>
                <td width="50%">
                    <?php
                        echo "
                            <p>Title: ".$book['title']." </p>
                            <p>Author: ".$book['author']." </p>
                            <p>Year: ".$book['year']." </p>
                        ";
                    ?>
                </td>
            </tr>
        </table>
    <?php endif; endif; ?>
</body>
</html>
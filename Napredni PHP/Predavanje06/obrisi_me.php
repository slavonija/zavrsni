<?php
echo "Skripta se izvršava na: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Vaš IP adresa je: " . $_SERVER['REMOTE_ADDR'] . "<br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    echo "Pozdrav, " . $name . "!";
}
?>

<form method="post">
    Unesite vaše ime: <input type="text" name="name">
    <input type="submit">
</form>



?>
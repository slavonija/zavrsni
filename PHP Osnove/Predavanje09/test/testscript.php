<?php
echo "Datoteka:" . $_FILES['datoteka']['name'] . "<br>";
echo "Tip : " . $_FILES['datoteka']['type'] . "<br>";
echo "Veličina : " . $_FILES['datoteka']['size'] . "<br>";
echo "Temp ime: " . $_FILES['datoteka']['tmp_name'] . "<br>";
echo "Greška : " . $_FILES['datoteka']['error'] . "<br>";
?>
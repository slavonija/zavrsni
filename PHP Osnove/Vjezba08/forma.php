<?php include_once 'functions.php'; ?>
<!DOCTYPE HTML>  
<html>
<head>
<style>
.greska {color: #FF0000;}
</style>
</head>
<body>  

<?php
$ToDo = loadToDo();
// definiraj varijable i postavi ih na prazne vrijednosti
$komentar = $komentarErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["komentar"])) {
        $komentarErr = "Komenter niste unijeli";
    //    $komentar = "";
    } else {
        $komentar = test_input($_POST["komentar"]);
        if (!preg_match("/^[a-z-' \p{Latin}L]+$/u",$komentar)) {
            $komentarErr = "Dopuštena su samo slova i razmak";
        }
    }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>ToDo list</h2>
<h3>Provjera da li je obavezno polje prazno ili ne i da li je podatak koji ste unijeli ispravan</h3>
<h3>Nakon što pritisnete Pošalji, pojavi se na ToDo listi</h3>

<p><span class="greska">* obavezno polje</span></p>
//<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<form method="post" action="addtask($komentar)" enctype="multipart/form-data">

Komentar: <input type="text" name="komentar"><br>
  <span class="greska">* <?php echo $komentarErr;?></textarea></span>
  <br><br>
  <input type="submit" name="submit" value="Pošalji">  
</form>

<?php
$todo = loadToDo();
echo "<h2>Vaš unos:</h2>";
echo $komentar;
echo "<br>";
?>

<ul id="taskUL">
<?php
  foreach($todo as $key => $task){
    echo "<li>" . $task["task"] . $task["id"] . "</li>";
    ?>
    <form action="functions.php" method="POST" enctype="multipart/form-data">
    <input type ="submit" value="Obriši" name="obrisi">
    <?php
  }
  ?>
</ul>

</body>
</html>

<?php

$pdo = new PDO("mysql:host=localhost;dbname=adventureworkshop; charset=utf8",
    "root", "", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
]);

//$id = 1;
$id = "1 OR 1=1";
$stm = $pdo->prepare("SELECT * FROM proizvod where IDProizvod = ?");
$stm->execute([$id]);
$res = $stm->fetch();
var_dump($res);


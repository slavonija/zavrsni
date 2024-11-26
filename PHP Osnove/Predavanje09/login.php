<?php


session_start();
session_regenerate_id();

if ($_GET["login"] ?? false) {
    $_SESSION["username"] = "admin";
    setcookie("username", "admin", time() + 3600, "/", "", false, false);
    header("Location: index.php");
    exit;
}

echo "Nisi prijavljen!";
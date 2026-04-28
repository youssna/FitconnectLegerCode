<?php

try {
    $users = "root";
    $pass = "root"; 
    $bdd = new PDO("mysql:host=localhost;dbname=fitconnect;charset=utf8", $users, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur ! : " . $e->getMessage() . "<br/>";
    die();
}

?>
<?php

try {
    $users = "jfrancois";
    $pass = "password!75"; 
    $bdd = new PDO("mysql:host=192.168.30.130;dbname=fitconnect;charset=utf8", $users, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur ! : " . $e->getMessage() . "<br/>";
    die();
}

?>

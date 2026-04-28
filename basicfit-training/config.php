<?php
// Configuration de la base de données
$host = '192.168.30.130';
$dbname = 'fitconnect';
$user = 'jfrancois';
$pass = 'password!75';

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<?php

include('bdd/bdd.php');
include('model/utilisateur/utilisateurModel.php');

$utilisateur = new Utilisateur($bdd);
$utilisateurById = $utilisateur->selectById($_GET['id_utilisateur']);

?>
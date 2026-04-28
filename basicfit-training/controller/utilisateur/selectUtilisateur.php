<?php

include('bdd/bdd.php');
include('model/utilisateur/utilisateurModel.php');

$utilisateur = new Utilisateur($bdd);
$allUtilisateur = $utilisateur->allUtilisateur();

?>
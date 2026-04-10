<?php

// 1. On charge le modèle depuis la racine
require_once('model/programme/programmeModel.php');

// GESTION DES ACTIONS (POST)
if (isset($_POST['action'])) {

    // $bdd est dispo grâce à index.php
    $programmeController = new ProgrammeController($bdd);

    switch ($_POST['action']) {
        case 'ajouter':
            $programmeController->create();
            break;

        case 'update':
            $programmeController->update();
            break;

        case 'supprimer':
            $programmeController->delete();
            break;

        default:
            header('Location: index.php?page=programme');
            exit;
    }
}

class ProgrammeController {

    private $programme;

    function __construct($bdd) {
        $this->programme = new Programme($bdd);
    }

    public function create() {
        // On appelle la méthode du modèle
        $this->programme->ajouterProgramme(
            $_POST['nom'],
            $_POST['description'], // Note: C'est ici que tu mettras le code HTML du tableau si tu utilises l'admin
            $_POST['type']         // ex: 'prise_masse'
        );

        header('Location: index.php?page=programme');
        exit;
    }

    public function update() {
        $this->programme->modifierProgramme(
            $_POST['id_programme'],
            $_POST['nom'],
            $_POST['description'],
            $_POST['type']
        );

        header('Location: index.php?page=programme');
        exit;
    }

    public function delete() {
        $this->programme->supprimerProgramme($_POST['id_programme']);

        header('Location: index.php?page=programme');
        exit;
    }
    
    // Si tu veux gérer l'affichage de la page publique via le contrôleur (Optionnel pour l'instant)
    public function afficherPublic() {
        // Ici on pourrait récupérer les programmes en BDD
        // $programmes = $this->programme->allProgramme();
        require('view/programme/programme.php');
    }
}
?>
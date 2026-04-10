<?php

include('../../model/utilisateur/utilisateurModel.php');
include('../../bdd/bdd.php');

if (isset($_POST['action'])) {

    $utilisateurController = new UtilisateurController($bdd);

    switch ($_POST['action']) {
        case 'ajouter':
            $utilisateurController->create();
            break;

        case 'update':
            $utilisateurController->update();
            break;

        case 'supprimer':
            $utilisateurController->delete();
            break;

        default:
            header('Location: /fitconnect/index.php?page=utilisateur');
            exit;
            break;
    }
}

class UtilisateurController {

    private $utilisateur;

    function __construct($bdd) {

        $this->utilisateur = new Utilisateur($bdd);
    }

    public function create() {

        $mdpHash = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

        $this->utilisateur->ajouterUtilisateur(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['mail'],
            $mdpHash 
        );

        header('Location: /fitconnect/index.php?page=utilisateur');
        exit;
    }

    public function update() {
        $mdpHash = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

        $this->utilisateur->modifierUtilisateur(
            $_POST['id_utilisateur'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['mail'],
            $mdpHash
        );

        header('Location: /fitconnect/index.php?page=utilisateur');
        exit;
    }

    public function delete() {
        $this->utilisateur->supprimerUtilisateur($_POST['id_utilisateur']);

        header('Location: /fitconnect/index.php?page=utilisateur');
        exit;
    }
}
?>
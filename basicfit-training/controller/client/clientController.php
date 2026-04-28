<?php

require_once('model/client/clientModel.php');
require_once('model/coach/coachModel.php');
require_once('model/programme/programmeModel.php');

/**
 * --- PARTIE ROUTAGE ---
 * Gère les appels POST venant des formulaires
 */
if (isset($_POST['action'])) {
    $clientController = new ClientController($bdd);

    switch ($_POST['action']) {
        case 'ajouter': 
            $clientController->create();
            break;

        case 'connexion': 
            $clientController->login();
            break;

        case 'deconnexion': 
            $clientController->logout();
            break;

        case 'update':
            $clientController->update();
            break;

        case 'supprimer':
            $clientController->delete();
            break;

        default:
            header('Location: index.php?page=espace_client');
            exit;
    }
}

/**
 * --- CLASSE CLIENT CONTROLLER ---
 */
class ClientController {

    private $client;
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
        $this->client = new Client($bdd); // Instance du modèle Client
    }

    /**
     * Traitement de l'inscription (Action: ajouter)
     */
    public function create() {
        // Hachage sécurisé du mot de passe
        $mdpHash = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
        
        // Récupération et nettoyage des données du formulaire
        $nom         = trim($_POST['nom']);
        $prenom      = trim($_POST['prenom']);
        $mail        = trim($_POST['mail']);
        $telephone   = isset($_POST['telephone']) ? trim($_POST['telephone']) : null;
        $poids       = $_POST['poids'];
        $taille      = $_POST['taille'];
        $objectif    = $_POST['objectif'];
        $motivation  = trim($_POST['description']); // 'description' dans ton HTML

        // Appel au modèle pour l'insertion en BDD
        $resultat = $this->client->ajouterClient(
            $nom,
            $prenom,
            $mail,
            $telephone, 
            $mdpHash, 
            $poids,
            $taille,
            $objectif,
            $motivation
        );

        if ($resultat) {
            // Succès : redirection vers la page de connexion
            header('Location: index.php?page=connexion_client&success=1');
        } else {
            // Échec : arrêt du script avec message d'erreur
            die("Erreur critique : Impossible d'enregistrer le client en base de données.");
        }
        exit;
    }

    /**
     * Traitement de la connexion (Action: connexion)
     */
    public function login() {
        $user = $this->client->getClientByEmail(trim($_POST['mail']));

        // Vérification de l'existence et du mot de passe
        if ($user && password_verify(trim($_POST['motdepasse']), $user['mot_de_passe'])) {
            
            // Initialisation de la session
            $_SESSION['id_client'] = $user['id_client'];
            $_SESSION['prenom']    = $user['prenom'];
            $_SESSION['role']      = 'client';

            header('Location: index.php?page=espace_client');
            exit;
        } else {
            // Identifiants incorrects
            header('Location: index.php?page=connexion_client&error=auth');
            exit;
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    /**
     * Affichage du tableau de bord client
     */
    public function dashboard() {
        // Sécurité : Vérifier que le client est bien connecté
        if (!isset($_SESSION['id_client'])) {
            header('Location: index.php?page=connexion_client');
            exit;
        }

        // 1. Récupération des infos du profil
        $monProfil = $this->client->selectById($_SESSION['id_client']);

        // 2. Récupération du coach associé (si id_coach n'est pas NULL)
        $monCoach = null;
        if (!empty($monProfil['id_coach'])) {
            $coachModel = new Coach($this->bdd);
            $monCoach = $coachModel->selectById($monProfil['id_coach']);
        }

        // 3. Récupération du programme correspondant à l'objectif du client
        $programmeModel = new Programme($this->bdd);
        $monProgramme = $programmeModel->getProgrammeByType($monProfil['objectif']);

        // 4. Détails des exercices si un programme existe
        $exercicesDetails = [];
        if ($monProgramme && isset($monProgramme['id_programme'])) {
            $exercicesDetails = $programmeModel->getDetailsProgramme($monProgramme['id_programme']);
        }

        // Chargement de la vue
        require('view/client/espaceClient.php');
    }

    /**
     * Mise à jour du profil (Action: update)
     */
    public function update() {
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : null;

        $this->client->modifierClient(
            $_POST['id_client'],
            trim($_POST['nom']),
            trim($_POST['prenom']),
            trim($_POST['mail']),
            $telephone, 
            $_POST['motdepasse'], // À gérer si changement de mdp souhaité
            $_POST['poids'],
            $_POST['taille'],
            $_POST['objectif'],
            trim($_POST['description'])
        );
        header('Location: index.php?page=espace_client&success=updated');
        exit;
    }

    /**
     * Suppression du compte (Action: supprimer)
     */
    public function delete() {
        if (isset($_POST['id_client'])) {
            $this->client->supprimerClient($_POST['id_client']);
            session_destroy();
        }
        header('Location: index.php');
        exit;
    }
}
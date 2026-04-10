<?php

require_once('model/coach/coachModel.php');

/**
 * --- PARTIE ROUTAGE ---
 */
if (isset($_POST['action'])) {

    $coachController = new CoachController($bdd);

    switch ($_POST['action']) {
        case 'ajouter': 
            $coachController->create();
            break;
            
        case 'connexion': 
            $coachController->login();
            break;
            
        case 'deconnexion': 
            $coachController->logout();
            break;
            
        case 'update': 
            $coachController->update();
            break;
            
        case 'accepter_client': 
            $coachController->accepterClient();
            break;
            
        case 'refuser_client': 
            $coachController->refuserClient();
            break;
            
        default:
            header('Location: index.php?page=espace_coach');
            exit;
    }
}

/**
 * --- CLASSE COACH CONTROLLER ---
 */
class CoachController {

    private $coach;
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
        $this->coach = new Coach($bdd);
    }

    /**
     * Inscription d'un nouveau coach (Candidature)
     */
    public function create() {
        // Nettoyage des données
        $nom        = trim($_POST['nom']);
        $prenom     = trim($_POST['prenom']);
        $email      = trim($_POST['mail']);
        $telephone  = isset($_POST['telephone']) ? trim($_POST['telephone']) : null;
        $adresse    = trim($_POST['adresse']);
        $specialite = $_POST['specialite'];
        $cv         = trim($_POST['cv']); // URL ou nom du fichier
        $mdp        = trim($_POST['motdepasse']);
        $mdp_confirm = trim($_POST['motdepasse_confirm']);

        // 1. Vérifications de sécurité
        if ($this->coach->emailExiste($email)) {
            header('Location: index.php?page=inscription_coach&error=email_existe');
            exit;
        }

        // 2. Hachage du mot de passe
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

        // 3. Insertion en base (valide est à 0 par défaut dans le Model)
        $resultat = $this->coach->ajouterCoach(
            $nom, 
            $prenom, 
            $email, 
            $telephone, 
            $adresse, 
            $specialite, 
            $cv, 
            $mdpHash
        );

        if ($resultat) {
            header('Location: index.php?page=accueil&message=candidature_envoyee');
        } else {
            die("Erreur lors de l'envoi de la candidature.");
        }
        exit;
    }

    /**
     * Connexion sécurisée avec vérification de validation Admin
     */
    public function login() {
        $user = $this->coach->getCoachByEmail(trim($_POST['mail']));
    
        if ($user && password_verify(trim($_POST['motdepasse']), $user['mot_de_passe'])) {
            
            // Vérification : le coach a-t-il été validé par l'Admin Java ?
            if ($user['valide'] == 0) {
                header('Location: index.php?page=connexion_coach&error=not_validated');
                exit;
            }
    
            // Session
            $_SESSION['id_coach'] = $user['id_coach'];
            $_SESSION['prenom']   = $user['prenom'];
            $_SESSION['role']     = 'coach'; 

            header('Location: index.php?page=espace_coach');
            exit;
            
        } else {
            header('Location: index.php?page=connexion_coach&error=auth');
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
     * Dashboard : Statistiques et gestion des athlètes
     */
    public function dashboard() {
        if (!isset($_SESSION['id_coach'])) {
            header('Location: index.php?page=connexion_coach');
            exit;
        }

        $infosCoach = $this->coach->selectById($_SESSION['id_coach']);
        $maSpecialite = $infosCoach['specialite'];

        // Récupère les clients qui ont un objectif correspondant à la spécialité
        $clientsEnAttente = $this->coach->getClientsCompatibles($maSpecialite, $_SESSION['id_coach']);

        // Récupère les clients déjà acceptés par ce coach
        $mesClients = $this->coach->mesClients($_SESSION['id_coach']);

        require('view/coach/espaceCoach.php');
    }
    
    /**
     * Accepter une demande d'athlète
     */
    public function accepterClient() {
        if (isset($_POST['id_client'])) {
            $this->coach->validerClient($_POST['id_client'], $_SESSION['id_coach']);
        }
        header('Location: index.php?page=espace_coach&message=client_accepte');
        exit;
    }

    /**
     * Refuser une demande d'athlète
     */
    public function refuserClient() {
        if (isset($_POST['id_client'])) {
            $this->coach->refuserClient($_POST['id_client'], $_SESSION['id_coach']);
        }
        header('Location: index.php?page=espace_coach&message=client_refuse');
        exit;
    }

    /**
     * Mise à jour du profil coach
     */
    public function update() {
        $mdpHash = null;
        if (!empty($_POST['motdepasse'])) {
            $mdpHash = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
        }
        
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : null;

        $this->coach->modifierCoach(
            $_POST['id_coach'], 
            trim($_POST['nom']), 
            trim($_POST['prenom']), 
            trim($_POST['mail']), 
            $telephone, 
            trim($_POST['adresse']), 
            $_POST['specialite'], 
            trim($_POST['cv']), 
            $mdpHash
        );

        header('Location: index.php?page=espace_coach&message=profil_modifie');
        exit;
    }
}
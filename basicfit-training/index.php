<?php
session_start();
include('bdd/bdd.php');

// --- PARTIE 1 : ROUTING DES ACTIONS (POST) ---
if (isset($_POST['action'])) {

    if (isset($_POST['controller'])) {
        
        switch ($_POST['controller']) {
            case 'client':
                include('controller/client/clientController.php');
                break;

            case 'coach':
                include('controller/coach/coachController.php');
                break;

            case 'programme':
                include('controller/programme/programmeController.php');
                break;

            case 'utilisateur':
                include('controller/utilisateur/utilisateurController.php');
                break;
        }
    }
}

// --- PARTIE 2 : ROUTING DES VUES (GET) ---
include('view/commun/header.php');

if (isset($_GET['page'])) {
    
    switch ($_GET['page']) {

        // --- ESPACE CLIENT ---
        case 'inscription_client':
            include('view/utilisateur/client/inscriptionClient.php');
            break;

        case 'connexion_client':
            include('view/utilisateur/client/connexionClient.php');
            break;

        // CORRECTION IMPORTANTE ICI : On utilise 'espace_client'
        case 'espace_client':
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'client') {
                // ON PASSE PAR LE CONTROLEUR (C'est lui qui charge les données)
                include('controller/client/clientController.php');
                $clientController = new ClientController($bdd);
                $clientController->dashboard(); 
            } else {
                include('view/utilisateur/client/connexionClient.php');
            }
            break;

        // --- ESPACE COACH ---
        case 'inscription_coach':
            include('view/utilisateur/coach/inscriptionCoach.php');
            break;

        case 'connexion_coach':
            include('view/utilisateur/coach/connexionCoach.php');
            break;

        // CORRECTION IMPORTANTE ICI : On utilise 'espace_coach'
        case 'espace_coach':
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'coach') {
                // ON PASSE PAR LE CONTROLEUR
                include('controller/coach/coachController.php');
                $coachController = new CoachController($bdd);
                $coachController->dashboard(); 
            } else {
                include('view/utilisateur/coach/connexionCoach.php');
            }
            break;

        // --- PAGE PROGRAMME (Vitrine) ---
        case 'programme':
            include('view/programme/programme.php');
            break;

        // --- ADMINISTRATION ---
        case 'utilisateur':
            include('view/utilisateur/listeUtilisateur.php');
            break;

        // --- ACCUEIL ---
        default:
            include('view/accueil/accueil.php');
            break;
    }

} else {
    // Si pas de page, accueil par défaut
    include('view/accueil/accueil.php');
}

include('view/commun/footer.php');
?>
<?php

/**
 * Modèle Coach : Gère les interactions avec la table 'coach' et les relations avec les clients
 */
class Coach {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    /**
     * Récupère tous les coachs
     */
    public function allCoach() {
        $req = $this->bdd->prepare("SELECT * FROM coach ORDER BY nom, prenom");
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Vérifie si un email existe déjà pour éviter les doublons
     */
    public function emailExiste($mail) {
        $req = $this->bdd->prepare("SELECT COUNT(*) FROM coach WHERE mail = :mail");
        $req->bindParam(':mail', $mail);
        $req->execute();
        return $req->fetchColumn() > 0;
    }

    /**
     * AJOUT : Enregistre un nouveau coach (Candidature)
     * Note : 'valide' est forcé à 0 pour attendre la validation de l'Admin Java
     */
    public function ajouterCoach($nom, $prenom, $mail, $telephone, $adresse, $specialite, $cv, $mot_de_passe) {
        $req = $this->bdd->prepare("
            INSERT INTO coach (nom, prenom, mail, telephone, adresse, specialite, cv, mot_de_passe, valide)
            VALUES (:nom, :prenom, :mail, :telephone, :adresse, :specialite, :cv, :mot_de_passe, 0)
        ");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':specialite', $specialite);
        $req->bindParam(':cv', $cv);
        $req->bindParam(':mot_de_passe', $mot_de_passe);
        return $req->execute();
    }

    /**
     * MODIFICATION : Met à jour le profil du coach
     */
    public function modifierCoach($id_coach, $nom, $prenom, $mail, $telephone, $adresse, $specialite, $cv, $mot_de_passe = null) {
        $sql = "UPDATE coach SET nom = :nom, prenom = :prenom, mail = :mail, telephone = :telephone, 
                adresse = :adresse, specialite = :specialite, cv = :cv";
        
        if ($mot_de_passe !== null) {
            $sql .= ", mot_de_passe = :mot_de_passe";
        }
        
        $sql .= " WHERE id_coach = :id_coach";
        
        $req = $this->bdd->prepare($sql);
        
        $req->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':specialite', $specialite);
        $req->bindParam(':cv', $cv);
        
        if ($mot_de_passe !== null) {
            $req->bindParam(':mot_de_passe', $mot_de_passe);
        }
        
        return $req->execute();
    }

    /**
     * Récupère un coach par son ID
     */
    public function selectById($id_coach) {
        $req = $this->bdd->prepare("SELECT * FROM coach WHERE id_coach = :id_coach");
        $req->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }

    /**
     * Récupère un coach par son email (pour la connexion)
     */
    public function getCoachByEmail($mail) {
        $req = $this->bdd->prepare("SELECT * FROM coach WHERE mail = :mail");
        $req->bindParam(':mail', $mail);
        $req->execute();
        return $req->fetch();
    }

    /**
     * MATCHING : Trouve les clients sans coach dont l'objectif correspond à la spécialité du coach
     * On exclut ceux que le coach a déjà refusés
     */
    public function getClientsCompatibles($specialite, $id_coach) {
        $req = $this->bdd->prepare("
            SELECT * FROM client 
            WHERE objectif = :specialite 
            AND id_coach IS NULL 
            AND id_client NOT IN (SELECT id_client FROM refus_coach WHERE id_coach = :id_coach)
        ");
        $req->bindParam(':specialite', $specialite);
        $req->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Liste des clients suivis par ce coach
     */
    public function mesClients($id_coach) {
        $req = $this->bdd->prepare("SELECT * FROM client WHERE id_coach = :id_coach");
        $req->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * ACCEPTER : Assigne le coach au client et lui attribue un programme par défaut
     */
    public function validerClient($id_client, $id_coach) {
        // 1. Liaison client -> coach
        $req1 = $this->bdd->prepare("UPDATE client SET id_coach = :id_coach WHERE id_client = :id_client");
        $req1->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $req1->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        $coachAssigne = $req1->execute();

        // 2. Attribution automatique d'un programme basé sur l'objectif
        $req2 = $this->bdd->prepare("
            INSERT INTO client_programme (id_client, id_programme, date_debut, statut)
            SELECT c.id_client, p.id_programme, CURRENT_DATE, 'en_cours'
            FROM client c
            INNER JOIN programme p ON c.objectif = p.type
            WHERE c.id_client = :id_client
            LIMIT 1
        ");
        $req2->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $req2->execute();

        return $coachAssigne;
    }

    /**
     * REFUSER : Enregistre le refus dans la table pivot pour ne plus proposer ce client
     */
    public function refuserClient($id_client, $id_coach) {
        $req = $this->bdd->prepare("INSERT INTO refus_coach (id_client, id_coach) VALUES (:id_client, :id_coach)");
        $req->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $req->bindParam(':id_coach', $id_coach, PDO::PARAM_INT);
        return $req->execute();
    }
}
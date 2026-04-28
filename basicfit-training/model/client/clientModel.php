<?php

/**
 * Modèle Client : Gère toutes les interactions avec la table 'client'
 */
class Client {

    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    /**
     * Récupère la liste de tous les clients
     */
    public function allClient() {
        $req = $this->bdd->prepare("SELECT * FROM client ORDER BY nom, prenom");
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * AJOUT : Enregistre un nouveau client en base de données
     * Note : motivation correspond à la colonne en BDD et $description à la donnée du formulaire
     */
    public function ajouterClient($nom, $prenom, $mail, $telephone, $mdp, $poids, $taille, $objectif, $description) {
        $req = $this->bdd->prepare("
            INSERT INTO client 
            (nom, prenom, mail, telephone, mot_de_passe, poids, taille, objectif, motivation, date_inscription)
            VALUES 
            (:nom, :prenom, :mail, :telephone, :mdp, :poids, :taille, :objectif, :description, NOW())
        ");
        
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':poids', $poids);
        $req->bindParam(':taille', $taille);
        $req->bindParam(':objectif', $objectif);
        $req->bindParam(':description', $description);
        
        return $req->execute();
    }

    /**
     * MODIFICATION : Met à jour les informations d'un client existant
     */
    public function modifierClient($id_client, $nom, $prenom, $mail, $telephone, $mdp, $poids, $taille, $objectif, $description) {
        $req = $this->bdd->prepare("
            UPDATE client
            SET nom = :nom, 
                prenom = :prenom, 
                mail = :mail, 
                telephone = :telephone, 
                mot_de_passe = :mdp,
                poids = :poids, 
                taille = :taille, 
                objectif = :objectif,
                motivation = :description
            WHERE id_client = :id_client
        ");
        
        $req->bindParam(':id_client', $id_client);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':poids', $poids);
        $req->bindParam(':taille', $taille);
        $req->bindParam(':objectif', $objectif);
        $req->bindParam(':description', $description);
        
        return $req->execute();
    }

    /**
     * SUPPRESSION : Supprime un compte client
     */
    public function supprimerClient($id_client) {
        $req = $this->bdd->prepare("DELETE FROM client WHERE id_client = :id_client");
        $req->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        return $req->execute();
    }

    /**
     * SÉLECTION : Récupère les infos d'un client par son ID (pour le dashboard)
     */
    public function selectById($id_client) {
        $req = $this->bdd->prepare("SELECT * FROM client WHERE id_client = :id_client");
        $req->bindParam(':id_client', $id_client, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }

    /**
     * CONNEXION : Récupère les infos d'un client par son email
     */
    public function getClientByEmail($mail) {
        $req = $this->bdd->prepare("SELECT * FROM client WHERE mail = :mail");
        $req->bindParam(':mail', $mail);
        $req->execute();
        return $req->fetch();
    }
}
?>
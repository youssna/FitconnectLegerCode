<?php

class Utilisateur {

    private $bdd;

    function __construct($bdd){
        $this->bdd = $bdd;
    }

    public function allUtilisateur(){
        $req = $this->bdd->prepare("SELECT * FROM utilisateur");
        $req->execute();
        return $req->fetchAll();
    }

    public function ajouterUtilisateur($nom, $prenom, $mail, $motdepasse){
        $req = $this->bdd->prepare("
            INSERT INTO utilisateur (nom, prenom, mail, motdepasse)
            VALUES (:nom, :prenom, :mail, :motdepasse)
        ");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':motdepasse', $motdepasse);
        return $req->execute();
    }

    public function modifierUtilisateur($id_utilisateur, $nom, $prenom, $mail, $motdepasse){
        $req = $this->bdd->prepare("
            UPDATE utilisateur 
            SET nom = :nom, prenom = :prenom, mail = :mail, motdepasse = :motdepasse
            WHERE id_utilisateur = :id_utilisateur
        ");
        $req->bindParam(':id_utilisateur', $id_utilisateur);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mail', $mail);
        $req->bindParam(':motdepasse', $motdepasse);
        return $req->execute();
    }

    public function supprimerUtilisateur($id_utilisateur){
        $req = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':id_utilisateur', $id_utilisateur);
        return $req->execute();
    }

    public function selectById($id_utilisateur){
        $req = $this->bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':id_utilisateur', $id_utilisateur);
        $req->execute();
        return $req->fetch();
    }
}
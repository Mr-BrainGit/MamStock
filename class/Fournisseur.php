<?php

class Fournisseur
{
    private $nomFournisseur;
    private $prenomFournisseur;
    private $emailFournisseur;
    private $telFournisseur;
    private $adresseFournisseur;
    private $nomStructFournisseur;
    private $raisonSocialeFournisseur;
    private $deliveryDelay;

    public function __construct($nomFournisseur, $prenomFournisseur, $emailFournisseur, $telFournisseur, $adresseFournisseur, $nomStructFournisseur, $raisonSocialeFournisseur, $delivery)
    {
        $this->setNomFournisseur($nomFournisseur);
        $this->setPrenomFournisseur($prenomFournisseur);
        $this->setEmailFournisseur($emailFournisseur);
        $this->setTelFournisseur($telFournisseur);
        $this->setAdresseFournisseur($adresseFournisseur);
        $this->setNomStrutFournisseur($nomStructFournisseur);
        $this->setRaisonSocialeFournisseur($raisonSocialeFournisseur);
        $this->setDelivery($delivery);
        
    }

    public function setNomFournisseur(string $nomFournisseur)
    {
        $this->nomFournisseur = $nomFournisseur;
    }

    public function getNomFournisseur()
    {
        return $this->nomFournisseur;
    }

    public function setRaisonSocialeFournisseur(string $raisonSocialeFournisseur)
    {
        $this->raisonSocialeFournisseur = $raisonSocialeFournisseur;
    }

    public function getRaisonSocialeFournisseur()
    {
        return $this->raisonSocialeFournisseur;
    }

    public function setPrenomFournisseur(string $prenomFournisseur)
    {
        $this->prenomFournisseur = $prenomFournisseur;
    }

    public function getPrenomFournisseur()
    {
        return $this->prenomFournisseur;
    }

    public function setEmailFournisseur(string $emailFournisseur)
    {
        $this->emailFournisseur = $emailFournisseur;
    }

    public function getEmailFournisseur()
    {
        return $this->emailFournisseur;
    }

    public function setTelFournisseur(string $telFournisseur)
    {
        $this->telFournisseur = $telFournisseur;
    }

    public function getTelFournisseur()
    {
        return $this->telFournisseur;
    }

    public function setAdresseFournisseur(string $adresseFournisseur)
    {
        $this->adresseFournisseur = $adresseFournisseur;
    }

    public function getAdresseFournisseur()
    {
        return $this->adresseFournisseur;
    }

    public function setNomStrutFournisseur(string $nomStructFournisseur )
    {
        $this->nomStructFournisseur = $nomStructFournisseur;
    }

    public function getDelivery()
    {
        return $this->deliveryDelay;
    }

    public function setDelivery(string $delivery )
    {
        $this->deliveryDelay = $delivery;
    }

    public function getNomStructFournisseur()
    {
        return $this->nomStructFournisseur;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fournisseurs");
        $requete->execute();
        return $requete->fetchAll();
    }

    /**Méthode pour ajouter un fournisseur */
    public static function create(Fournisseur $fournisseur)
    {
        include 'db-connect.php';
        $email = $fournisseur->getEmailFournisseur();

        $requete = $bdd->prepare("SELECT * FROM fournisseurs WHERE emailFournisseur = '$email'");
        $requete->execute();
        $emails = $requete->fetchAll();


        if (count($emails) === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO fournisseurs VALUES (:idFournisseur, :nomFournisseur, :prenomFournisseur, :emailFournisseur, :telFournisseur, :adresseFournisseur, :nomStructFournisseur, :raisonSocialeFournisseur, :deliveryDelay)');
            $pdoStat->bindValue(':idFournisseur', NULL);
            $pdoStat->bindValue(':nomFournisseur', $fournisseur->getNomFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':prenomFournisseur', $fournisseur->getPrenomFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':emailFournisseur', $fournisseur->getEmailFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':telFournisseur', $fournisseur->getTelFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':adresseFournisseur', $fournisseur->getAdresseFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':nomStructFournisseur', $fournisseur->getNomStructFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':raisonSocialeFournisseur', $fournisseur->getRaisonSocialeFournisseur(), PDO::PARAM_STR);
            $pdoStat->bindValue(':deliveryDelay', $fournisseur->getDelivery(), PDO::PARAM_STR);

            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo "";
            } else {
                echo "Ajout echoué";
            }
        } else {
            $response = "Le fournisseur a été déja créé";
            return $response;
        }
    }

    /**Méthode pour supprimer un fournisseur */
    public static function delete($idFournisseur)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM fournisseurs WHERE idFournisseur = $idFournisseur");
        $requete->execute();
    }

    //**Méthode pour faire la mise a jour d'un fournisseur */
    public static function update(Fournisseur $fournisseur, $id)
    {
        include 'db-connect.php';

        $nom = $fournisseur->getNomFournisseur();
        $prenom = $fournisseur->getPrenomFournisseur();
        $tel = $fournisseur->getTelFournisseur();
        $adresse = $fournisseur->getAdresseFournisseur();
        $email = $fournisseur->getEmailFournisseur();
        $struct = $fournisseur->getNomStructFournisseur();
        $social = $fournisseur->getRaisonSocialeFournisseur();
        $delivery = $fournisseur->getDelivery();


        $sql = "UPDATE fournisseurs SET
                nomFournisseur = '$nom',
                prenomFournisseur = '$prenom',
                telFournisseur = '$tel',
                adresseFournisseur = '$adresse',
                emailFournisseur = '$email',
                nomStructFournisseur = '$struct',
                raisonSocialeFournisseur = '$social',
                deliveryDelay = '$delivery'
                WHERE idFournisseur = $id";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();

        if ($retour) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function findByCode($idFournisseur)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT * FROM fournisseurs WHERE idFournisseur = $idFournisseur");
        $requete->execute();
        return $requete->fetchAll();
    }

}

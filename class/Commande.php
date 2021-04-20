<?php

class Commande
{
    private $codeCommande;
    private $dateCommande;
    private $idFournisseur;
    private $etatCommande;
    private $description;

    public static $commande;

    public function __construct($codeCommande, $dateCommande, $idFournisseur, $etatCommande, $description)
    {
        $this->setCodeCommande($codeCommande);
        $this->setDateCommande($dateCommande);
        $this->setIdFournisseur($idFournisseur);
        $this->setEtatCommande($etatCommande);
        $this->setDescription($description);
    }

    public function getCodeCommande()
    {
        return $this->codeCommande;
    }

    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    public function getIdFournisseur()
    {
        return $this->idFournisseur;
    }

    public function getEtatCommande()
    {
        return $this->etatCommande;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCodeCommande($codeCommande)
    {
        $this->codeCommande = $codeCommande;
    }

    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }

    public function setIdFournisseur($idFournisseur)
    {
        $this->idFournisseur = $idFournisseur;
    }

    public function setEtatCommande($etatCommande)
    {
        $this->etatCommande = $etatCommande;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM commandes");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function create(Commande $commande)
    {
        include 'db-connect.php';
        $codeCommande = $commande->getCodeCommande();




        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO commandes VALUES (:idcommande, :dateCommande,:dateArrivee , :idFournisseur, :etatCommande, :commentaire)');
            $pdoStat->bindValue(':idcommande', NULL);
            $pdoStat->bindValue(':dateCommande', $commande->getDateCommande(), PDO::PARAM_STR);
            $pdoStat->bindValue(':dateArrivee', NULL);
            $pdoStat->bindValue(':idFournisseur', $commande->getIdFournisseur(), PDO::PARAM_INT);
            $pdoStat->bindValue(':etatCommande', $commande->getEtatCommande(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $commande->getDescription(), PDO::PARAM_STR);
            $insertOK = $pdoStat->execute();


            if ($insertOK) {
            } else {
            }
        } else {
            $response = "Le produit à été déja créé";
            return $response;
        }
    }

    public static function createFake(Commande $commande)
    {
        include 'db-connect.php';
        $codeCommande = $commande->getCodeCommande();




        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO fakecommandes VALUES (:idcommande, :dateCommande, :idFournisseur, :etatCommande, :commentaire)');
            $pdoStat->bindValue(':idcommande', NULL);
            $pdoStat->bindValue(':dateCommande', $commande->getDateCommande(), PDO::PARAM_STR);
            $pdoStat->bindValue(':idFournisseur', $commande->getIdFournisseur(), PDO::PARAM_INT);
            $pdoStat->bindValue(':etatCommande', $commande->getEtatCommande(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $commande->getDescription(), PDO::PARAM_STR);
            $insertOK = $pdoStat->execute();


            if ($insertOK) {


            }
            else{

            }
        }else{
            $response = "Le produit à été déja créé";
            return $response;
        }


    }

    public static function getLastId()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT idCommande FROM commandes ORDER BY idCommande DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idCommande'];

    }

    public static function getFakeLastId()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT idCommande FROM fakecommandes ORDER BY idCommande DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idCommande'];

    }

    public static function findByFakeCommandeCode($fakeCode)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakecommandes WHERE idCommande = $fakeCode");
        $requete->execute();
        $commande = $requete->fetchAll();
		return $commande[0];
    }

    public static function findByCommandeCode($code)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM commandes WHERE idCommande = $code");
        $requete->execute();
        $commande = $requete->fetchAll();
		return $commande[0];
    }

    public static function delete($idComm)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM commandes WHERE idCommande = $idComm");
		$requete->execute();
    }

    public static function setEtat($idComm, $etat)
    {
        include 'db-connect.php';

        $sql = "UPDATE commandes SET
                etatCommande = '$etat'
                WHERE idCommande = $idComm";

       // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

    public static function setDateArrivee($idComm, $date)
    {
        include 'db-connect.php';

        $sql = "UPDATE commandes SET
                dateArrivee = '$date'
                WHERE idCommande = $idComm";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

}

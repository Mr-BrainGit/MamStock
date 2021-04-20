<?php

class Facture
{
    private $codeFacture;
    private $dateFacture;
    private $idClient;
    private $etatFacture;
    private $description;

    public static $facture;

    public function __construct($codeFacture, $dateFacture, $idClient, $etatFacture, $description)
    {
        $this->setCodeFacture($codeFacture);
        $this->setDateFacture($dateFacture);
        $this->setIdClient($idClient);
        $this->setEtatFacture($etatFacture);
        $this->setDescription($description);
    }

    public function getCodeFacture()
    {
        return $this->codeFacture;
    }

    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function getEtatFacture()
    {
        return $this->etatFacture;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCodeFacture($codeFacture)
    {
        $this->codeFacture = $codeFacture;
    }

    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;
    }

    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    public function setEtatFacture($etatFacture)
    {
        $this->etatFacture = $etatFacture;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function create(Facture $facture)
    {
        include 'db-connect.php';
        $codeFacture = $facture->getCodeFacture();




        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO factures VALUES (:idFacture, :dateFacture,:dateReglee , :idClient, :etatFacture, :commentaire)');
            $pdoStat->bindValue(':idFacture', NULL);
            $pdoStat->bindValue(':dateFacture', $facture->getDateFacture(), PDO::PARAM_STR);
            $pdoStat->bindValue(':dateReglee', NULL);
            $pdoStat->bindValue(':idClient', $facture->getIdClient(), PDO::PARAM_INT);
            $pdoStat->bindValue(':etatFacture', $facture->getEtatFacture(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $facture->getDescription(), PDO::PARAM_STR);
            $insertOK = $pdoStat->execute();


            if ($insertOK) {
            } else {
            }
        } else {
            $response = "Le produit à été déja créé";
            return $response;
        }
    }

    public static function createFake(Facture $facture)
    {
        include 'db-connect.php';
        $codeFacture = $facture->getCodeFacture();




        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO fakefactures VALUES (:idFacture, :dateFacture, :idClient, :etatFacture, :commentaire)');
            $pdoStat->bindValue(':idFacture', NULL);
            $pdoStat->bindValue(':dateFacture', $facture->getDateFacture(), PDO::PARAM_STR);
            $pdoStat->bindValue(':idClient', $facture->getIdClient(), PDO::PARAM_INT);
            $pdoStat->bindValue(':etatFacture', $facture->getEtatFacture(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $facture->getDescription(), PDO::PARAM_STR);
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
        $requete = $bdd->prepare("SELECT idFacture FROM factures ORDER BY idFacture DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idFacture'];

    }

    public static function getFakeLastId()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT idFacture FROM fakefactures ORDER BY idFacture DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idFacture'];

    }

    public static function findByFakeFactureCode($fakeCode)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakefactures WHERE idFacture = $fakeCode");
        $requete->execute();
        $facture = $requete->fetchAll();
		return $facture[0];
    }

    public static function findBycode($Code)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures WHERE idFacture = $Code");
        $requete->execute();
        $facture = $requete->fetchAll();
		return $facture;
    }

    public static function delete($idFact)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM factures WHERE idFacture = $idFact");
		$requete->execute();
    }

    public static function setEtat($idFact, $etat)
    {
        include 'db-connect.php';

        $sql = "UPDATE factures SET
                etatFacture = '$etat'
                WHERE idFacture = $idFact";

       // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

    public static function setDateReglee($idFact, $date)
    {
        include 'db-connect.php';

        $sql = "UPDATE factures SET
                dateReglee = '$date'
                WHERE idFacture = $idFact";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

    public static function getFactureByDate($date, $date2)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures WHERE dateFacture BETWEEN '$date' AND '$date2'");
        $requete->execute();
        
		return $requete->fetchAll();
    }

}



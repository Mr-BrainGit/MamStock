<?php

class Achat
{
    private $codeProduit;
    private $quantite;
    private $codeCommande;


    public function __construct($codeProduit, $quantite, $codeCommande)
    {
        $this->setCodeCommande($codeCommande);
        $this->setCodeProduit($codeProduit);
        $this->setQuantite($quantite);
    }

    public function getCodeProduit()
    {
        return $this->codeProduit;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getCodeCommande()
    {
        return $this->codeCommande;
    }


    public function setCodeProduit($codeProduit)
    {
        $this->codeProduit = $codeProduit;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function setCodeCommande($codeCommande)
    {
        $this->codeCommande = $codeCommande;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM achats");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getAllByCommandeId($idCommande)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM achats WHERE idCommande = $idCommande");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getAllByFakeCommandeId($idCommande)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakeachats WHERE idCommande = $idCommande");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function create(Achat $achat)
    {
        include 'db-connect.php';

        $pdoStat = $bdd->prepare('INSERT INTO achats VALUES (:idAchat, :idCommande, :idProduit, :quantite)');
        $pdoStat->bindValue(':idAchat', NULL);
        $pdoStat->bindValue(':idCommande', $achat->getCodeCommande(), PDO::PARAM_INT);
        $pdoStat->bindValue(':idProduit', $achat->getCodeProduit(), PDO::PARAM_INT);
        $pdoStat->bindValue(':quantite', $achat->getQuantite(), PDO::PARAM_INT);
        $insertOK = $pdoStat->execute();


        if ($insertOK) {
            echo "Utilistaeur ajouté avec success";
        } else {
            echo "Ajout echoué";
        }
    }

    public static function createFake(Achat $achat)
    {
        include 'db-connect.php';

        $pdoStat = $bdd->prepare('INSERT INTO fakeachats VALUES (:idAchat, :idCommande, :idProduit, :quantite)');
        $pdoStat->bindValue(':idAchat', NULL);
        $pdoStat->bindValue(':idCommande', $achat->getCodeCommande(), PDO::PARAM_INT);
        $pdoStat->bindValue(':idProduit', $achat->getCodeProduit(), PDO::PARAM_INT);
        $pdoStat->bindValue(':quantite', $achat->getQuantite(), PDO::PARAM_INT);
        $insertOK = $pdoStat->execute();


        if ($insertOK) {
            echo "Utilistaeur ajouté avec success";
        } else {
            echo "Ajout echoué";
        }
    }

    public static function delete($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM achats WHERE idProduit = $idProd");
        $requete->execute();
    }

    public static function deleteFake($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM fakeachats WHERE idProduit = $idProd");
        $requete->execute();
    }

    /**public static function truncateFakeTable()
    {
        include 'db-connect.php';
        $requete = "TRUNCATE TABLE fakecommandes";
        $bdd->query($requete);

        $requete = "TRUNCATE TABLE fakeachats";
        $bdd->query($requete);
    }*/

    public static function updateQte($idCommande, $idProduit, $qteFinale)
    {
        include 'db-connect.php';

        $sql = "UPDATE achats SET
                quantite = '$qteFinale'
                WHERE idCommande = $idCommande AND idProduit = $idProduit";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

    public static function sommeQte($table, $idCommande, $idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT SUM(quantite) AS qteTotale FROM $table WHERE idCommande = $idCommande AND idProduit = $idProduit");
        $requete->execute();
        return $requete->fetchAll();
    }
}

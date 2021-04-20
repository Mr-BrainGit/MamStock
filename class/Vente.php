<?php

class Vente
{
    private $codeProduit;
    private $quantite;
    private $codeFacture;


    public function __construct($codeProduit, $quantite, $codeFacture)
    {
        $this->setCodeFacture($codeFacture);
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

    public function getCodeFacture()
    {
        return $this->codeFacture;
    }


    public function setCodeProduit($codeProduit)
    {
        $this->codeProduit = $codeProduit;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function setCodeFacture($codeFacture)
    {
        $this->codeFacture = $codeFacture;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM ventes");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function getAllByCommandeId($idFacture)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM ventes WHERE idFacture = $idFacture");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getAllByFactureId($idFacture)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM ventes WHERE idFacture = $idFacture");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function getAllByFakeFactureId($idFacture)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakeventes WHERE idFacture = $idFacture");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function create(Vente $vente)
    {
        include 'db-connect.php';

            $pdoStat = $bdd->prepare('INSERT INTO ventes VALUES (:idVente, :idFacture, :idProduit, :quantite)');
            $pdoStat->bindValue(':idVente', NULL);
            $pdoStat->bindValue(':idFacture', $vente->getCodeFacture(), PDO::PARAM_INT);
            $pdoStat->bindValue(':idProduit', $vente->getCodeProduit(), PDO::PARAM_INT);
            $pdoStat->bindValue(':quantite', $vente->getQuantite(), PDO::PARAM_INT);
            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo " ";

            }
            else{
                echo "Ajout echoué";
            }



    }

    public static function createFake(Vente $vente)
    {
        include 'db-connect.php';

            $pdoStat = $bdd->prepare('INSERT INTO fakeventes VALUES (:idVente, :idFacture, :idProduit, :quantite)');
            $pdoStat->bindValue(':idVente', NULL);
            $pdoStat->bindValue(':idFacture', $vente->getCodeFacture(), PDO::PARAM_INT);
            $pdoStat->bindValue(':idProduit', $vente->getCodeProduit(), PDO::PARAM_INT);
            $pdoStat->bindValue(':quantite', $vente->getQuantite(), PDO::PARAM_INT);
            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo  " ";

            }
            else{
                echo "Ajout echoué";
            }

    }

    public static function delete($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM ventes WHERE idProduit = $idProd");
		$requete->execute();
    }

    public static function deleteFake($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM fakeventes WHERE idProduit = $idProd");
		$requete->execute();
    }

    /**public static function truncateFakeTable()
    {
        include 'db-connect.php';
        $requete = "TRUNCATE TABLE fakefactures";
        $bdd->query($requete);

        $requete = "TRUNCATE TABLE fakeventes";
        $bdd->query($requete);
    }*/

    public static function updateQte($idFacture, $idProduit, $qteFinale)
    {
        include 'db-connect.php';

        $sql = "UPDATE ventes SET
                quantite = '$qteFinale'
                WHERE idFacture = $idFacture AND idProduit = $idProduit";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
    }

    public static function sommeQte($table ,$idFacture, $idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT SUM(quantite) AS qteTotale FROM $table WHERE idFacture = $idFacture AND idProduit = $idProduit");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getProductSellNumber($table ,$idFacture)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT idProduit, SUM(quantite) AS qteTotale FROM $table WHERE idFacture = $idFacture GROUP BY idProduit");
        $requete->execute();
        return $requete->fetchAll();
    }


}

//echo '<pre>'; var_dump( Vente::getProductSellNumber('ventes', 44)); echo '</pre>';

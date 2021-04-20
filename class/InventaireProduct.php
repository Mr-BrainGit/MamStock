<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

class InventaireProduct
{
    private $codeProduit;
    private $quantite;
    private $codeInventaire;
    private $diff;
    

    public function __construct($codeProduit, $quantite, $codeInventaire, $diff)
    {
        $this->setCodeInventaire($codeInventaire);
        $this->setCodeProduit($codeProduit);
        $this->setQuantite($quantite);
        $this->setDiff($diff);
    }

    public function getCodeProduit()
    {
        return $this->codeProduit;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getCodeInventaire()
    {
        return $this->codeInventaire;
    }

    public function getDiff()
    {
        return $this->diff;
    }

    
    public function setCodeProduit($codeProduit)
    {
        $this->codeProduit = $codeProduit;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function setCodeInventaire($codeInventaire)
    {
        $this->codeInventaire = $codeInventaire;
    }

    public function setDiff($diff)
    {
        $this->diff = $diff;
    }

    


    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM inventairesproducts");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function getAllByInventaireId($idInventaire)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM inventairesproducts WHERE idInventaire = $idInventaire");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function getAllByFakeInventaireId($idInventaire)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakeinventairesproducts WHERE idInventaire = $idInventaire");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function create(InventaireProduct $inventaire)
    {
        include 'db-connect.php';
    
            $pdoStat = $bdd->prepare('INSERT INTO inventairesproducts VALUES (:idInventairesProducts, :idIventaire, :idProduit, :quantite, :diff)');
            $pdoStat->bindValue(':idInventairesProducts', NULL);
            $pdoStat->bindValue(':idIventaire', $inventaire->getCodeInventaire(), PDO::PARAM_INT);
            $pdoStat->bindValue(':idProduit', $inventaire->getCodeProduit(), PDO::PARAM_INT);
            $pdoStat->bindValue(':quantite', $inventaire->getQuantite(), PDO::PARAM_INT);
            $pdoStat->bindValue(':diff', $inventaire->getDiff(), PDO::PARAM_INT);
            $insertOK = $pdoStat->execute();

            
            if ($insertOK) {
                echo "Utilistaeur ajouté avec success";

            }
            else{
                echo "Ajout echoué";
            }
        
        
        
    }

    public static function createFake(InventaireProduct $inventaire)
    {
        include 'db-connect.php';
    
            $pdoStat = $bdd->prepare('INSERT INTO fakeinventairesproducts VALUES (:idInventairesProducts, :idIventaire, :idProduit, :quantite, :diff)');
            $pdoStat->bindValue(':idInventairesProducts', NULL);
            $pdoStat->bindValue(':idIventaire', $inventaire->getCodeInventaire(), PDO::PARAM_INT);
            $pdoStat->bindValue(':idProduit', $inventaire->getCodeProduit(), PDO::PARAM_INT);
            $pdoStat->bindValue(':quantite', $inventaire->getQuantite(), PDO::PARAM_INT);
            $pdoStat->bindValue(':diff', $inventaire->getDiff(), PDO::PARAM_INT);
            $insertOK = $pdoStat->execute();

            
            if ($insertOK) {
                echo "Utilistaeur ajouté avec success";

            }
            else{
                echo "Ajout echoué";
            }
        
        
        
    }

    public static function delete($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM inventairesproducts WHERE idProduit = $idProd");
		$requete->execute();
    }

    public static function deleteFake($idProd)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM fakeinventairesproducts WHERE idProduit = $idProd");
		$requete->execute();
    }

    public static function truncateFakeTable()
    {
        include 'db-connect.php';
        $requete = "TRUNCATE TABLE fakecommandes";
        $bdd->query($requete);

        $requete = "TRUNCATE TABLE fakeachats";
        $bdd->query($requete);
    }
}
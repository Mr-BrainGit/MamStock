<?php
ini_set('display_errors','on');
error_reporting(E_ALL);

class Inventaire
{
    private $codeInventaire;
    private $dateInventaire;
    private $etatInventaire;
    private $description;


    public function __construct($codeInventaire, $dateInventaire, $etatInventaire, $description)
    {
        $this->setCodeInventaire($codeInventaire);
        $this->setDateInventaire($dateInventaire);
        $this->setEtatInventaire($etatInventaire);
        $this->setDescription($description);
    }

    public function getCodeInventaire()
    {
        return $this->codeInventaire;
    }

    public function getDateInventaire()
    {
        return $this->dateInventaire;
    }


    public function getEtatInventaire()
    {
        return $this->etatInventaire;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setCodeInventaire($codeInventaire)
    {
        $this->codeInventaire = $codeInventaire;
    }

    public function setDateInventaire($dateInventaire)
    {
        $this->dateInventaire = $dateInventaire;
    }

   

    public function setEtatInventaire($etatInventaire)
    {
        $this->etatInventaire = $etatInventaire;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM inventaires");
		$requete->execute();
		return $requete->fetchAll();
    }

    public static function create(Inventaire $inventaire)
    {
        include 'db-connect.php';
        

        
        
        
        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO inventaires VALUES (:idInventaire, :dateInventaire, :etatInventaire, :commentaire)');
            $pdoStat->bindValue(':idInventaire', NULL);
            $pdoStat->bindValue(':dateInventaire', $inventaire->getDateInventaire(), PDO::PARAM_STR);
            $pdoStat->bindValue(':etatInventaire', $inventaire->getEtatInventaire(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $inventaire->getDescription(), PDO::PARAM_STR);
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

    public static function createFake(Inventaire $inventaire)
    {
        include 'db-connect.php';
        

        if (0 === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO fakeinventaires VALUES (:idInventaire, :dateInventaire, :etatInventaire, :commentaire)');
            $pdoStat->bindValue(':idInventaire', NULL);
            $pdoStat->bindValue(':dateInventaire', $inventaire->getDateInventaire(), PDO::PARAM_STR);
            $pdoStat->bindValue(':etatInventaire', $inventaire->getEtatInventaire(), PDO::PARAM_INT);
            $pdoStat->bindValue(':commentaire', $inventaire->getDescription(), PDO::PARAM_STR);
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
        $requete = $bdd->prepare("SELECT idInventaire FROM inventaires ORDER BY idInventaire DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idInventaire'];
		
    }

    public static function getFakeLastId()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT idInventaire FROM fakeinventaires ORDER BY idInventaire DESC LIMIT 1");
        $requete->execute();
        $result = $requete->fetchAll();
		return $result[0]['idInventaire'];
		
    }

    public static function findByFakeInventaireCode($fakeCode)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fakeinventaires WHERE idInventaire = $fakeCode");
        $requete->execute();
        $inventaire = $requete->fetchAll();
		return $inventaire[0];
    }

    public static function delete($idIven)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM inventaires WHERE idInventaire = $idIven");
		$requete->execute();
    }

    public static function setEtat($idInven, $etat)
    {
        include 'db-connect.php';
        
        $sql = "UPDATE inventaires SET 
                etatInventaire = '$etat'
                WHERE idInventaire = $idInven";
								
       // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();
        
        
    }
    
    public static function sommeQte($table, $idInventaire, $idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT SUM(quantite) AS qteTotale FROM $table WHERE idInventaire = $idInventaire AND idProduit = $idProduit");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getValue($idInventaire, $idProduit, $attribute)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT $attribute FROM inventairesproducts WHERE idInventaire = $idInventaire AND idProduit = $idProduit");
        $requete->execute();
        return $requete->fetchAll();
    }
}



<?php


class Produit
{
    private $codeProduit;
    private int $idCategorie;
    private $libelleProduit;
    private $stockMin;
    private $stockMax;
    private $stockActuel;
    private $prixUnitaire;
    private $prixAchat;
    private $emplacement;
    private $unite;
    private $securityDelay;

    public function __construct($codeProduit, $idCategorie, $libelleProduit, $stockMin, $stockMax, $stockActuel, $prixUnitaire, $prixAchat, $emplacement, $unite, $securityDelay)
    {
       $this->setCodeProduit($codeProduit);
       $this->setIdCategorie($idCategorie);
       $this->setLibelleProduit($libelleProduit);
       $this->setStockMin($stockMin);
       $this->setStockMax($stockMax);
       $this->setStockActuel($stockActuel);
       $this->setPrixUnitaire($prixUnitaire);
       $this->setPrixAchat($prixAchat);
       $this->setEmplacement($emplacement);
       $this->setUnite($unite);
       $this->setSecurityDelay($securityDelay);

    }

    public function getCodeProduit()
    {
        return $this->codeProduit;
    }

    public function setCodeProduit($codeProduit)
    {
        $this->codeProduit = $codeProduit;
    }

    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    }

    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    public function setLibelleProduit($libelleProduit)
    {
        $this->libelleProduit = $libelleProduit;
    }

    public function getLibelleProduit()
    {
        return $this->libelleProduit;
    }

    public function setStockMin($stockMin)
    {
        $this->stockMin = $stockMin;
    }

    public function getStockMin()
    {
        return $this->stockMin;
    }

    public function setStockMax($stockMax)
    {
        $this->stockMax = $stockMax;
    }

    public function getStockMax()
    {
        return $this->stockMax;
    }

    public function setStockActuel($stockActuel)
    {
        $this->stockActuel = $stockActuel;
    }

    public function getStockActuel()
    {
        return $this->stockActuel;
    }

    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    public function setPrixAchat($prixAchat)
    {
        $this->prixAchat = $prixAchat;
    }

    public function getUnite()
    {
        return $this->unite;
    }

    public function setUnite($unite)
    {
        $this->unite = $unite;
    }

    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;
    }

    public function getEmplacement()
    {
        return $this->emplacement;
    }

    public function setSecurityDelay($securityDelay)
    {
        $this->securityDelay = $securityDelay;
    }

    public function getSecurityDelay()
    {
        return $this->securityDelay;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits");
		$requete->execute();
		return $requete->fetchAll();
    }


    /**Méthode pour ajouter un produit */
    public static function create(Produit $produit)
    {
        include 'db-connect.php';
        $codeProduit = $produit->getCodeProduit();

        $requete = $bdd->prepare("SELECT * FROM produits WHERE codeProduit = '$codeProduit'");
		$requete->execute();
        $produits = $requete->fetchAll();


        if (count($produits) === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO produits VALUES (:idProduit, :codeProduit, :idCategorie, :libelleProduit, :qteProduitMin, :qteProduitMax, :stockActuelProduit, :prixUnit, :prixAchat,:idEmplacement, :unite, :securityDelay)');
            $pdoStat->bindValue(':idProduit', NULL);
            $pdoStat->bindValue(':codeProduit', $produit->getCodeProduit(), PDO::PARAM_STR);
            $pdoStat->bindValue(':idCategorie', $produit->getIdCategorie(), PDO::PARAM_INT);
            $pdoStat->bindValue(':libelleProduit', $produit->getLibelleProduit(), PDO::PARAM_STR);
            $pdoStat->bindValue(':qteProduitMin', $produit->getStockMin(), PDO::PARAM_INT);
            $pdoStat->bindValue(':qteProduitMax', $produit->getStockMax(), PDO::PARAM_INT);
            $pdoStat->bindValue(':stockActuelProduit', $produit->getStockActuel(), PDO::PARAM_INT);
            $pdoStat->bindValue(':prixUnit', $produit->getPrixUnitaire(), PDO::PARAM_INT);
            $pdoStat->bindValue(':prixAchat', $produit->getPrixAchat(), PDO::PARAM_INT);
            $pdoStat->bindValue(':idEmplacement', $produit->getEmplacement(), PDO::PARAM_INT);
            $pdoStat->bindValue(':unite', $produit->getUnite(), PDO::PARAM_STR);
            $pdoStat->bindValue(':securityDelay', $produit->getSecurityDelay(), PDO::PARAM_INT);

            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo "Utilistaeur ajouté avec success";

            }
            else{
                echo "Ajout echoué";
            }
        }else{
            $response = "Le produit à été déja créé";
            return $response;
        }


    }

    /**Méthode pour récupérer un produit a partir de son code */
    public static function findByCode($codeProduit)
    {

        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits WHERE codeProduit = '$codeProduit' LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();

        if (count($produit) !== 0) {
            return $produit;
        }else{
            $response = "Le produit recherché n'exixte pas!";
            return $response;
        }

    }

    public static function findById($idProduit)
    {

        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits WHERE idProduit = $idProduit LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();

        if (count($produit) !== 0) {
            return $produit[0];
        }else{
            $response = "Le produit recherché n'exixte pas!";
            return $response;
        }

    }

    /**Méthode pour supprimer un produit */
    public static function delete($idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM produits WHERE idProduit = $idProduit");
		$requete->execute();
    }

    //**Méthode pour faire la mise a jour d'un produit */
    public static function update(Produit $produit, $id)
    {
        include 'db-connect.php';

        $libele = $produit->getLibelleProduit();
        $codeProduit = $produit->getCodeProduit();
        $idCategorie = $produit->getIdCategorie();
        $qteMin = $produit->getStockMin();
        $qteMax = $produit->getStockMax();
        $prixUnitaire = $produit->getPrixUnitaire();
        $prixAchat = $produit->getPrixAchat();
        $idEmplacement = $produit->getEmplacement();
        $unite = $produit->getUnite();
        $securityDelay = $produit->getSecurityDelay();



        $sql = "UPDATE produits SET
                codeProduit = '$codeProduit',
                idCategorie = '$idCategorie',
                libelleProduit = '$libele',
                qteProduitMin = '$qteMin',
                qteProduitMax = '$qteMax',
                prixUnit = '$prixUnitaire',
                prixAchat = '$prixAchat',
                idEmplacement = '$idEmplacement',
                unite = '$unite',
                securityDelay = '$securityDelay'
                WHERE idProduit = $id";

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

    public static function updateQte($qte, $id)
    {
        include 'db-connect.php';


        $sql = "UPDATE produits SET
                stockActuelProduit = stockActuelProduit + '$qte'
                WHERE idProduit = $id";

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

    public static function updateQteSell($qte, $id)
    {
        include 'db-connect.php';


        $sql = "UPDATE produits SET
                stockActuelProduit = stockActuelProduit - '$qte'
                WHERE idProduit = $id";

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

}









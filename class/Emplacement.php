<?php
class Emplacement
{
    private $libelle;
    private $description;

    public function __construct($libelle, $description)
    {
        $this->setLibele($libelle);
        $this->setDescription($description);
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setLibele($libelle)
    {
        $this->libelle = $libelle;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM emplacements");
		$requete->execute();
		return $requete->fetchAll();
    }

    /**Méthode pour ajouter un emplacement */
    public static function create(Emplacement $emplacement)
    {
        include 'db-connect.php';
        $libelle = $emplacement->getLibelle();

        $requete = $bdd->prepare("SELECT * FROM emplacements WHERE libelleEmplacement = '$libelle'");
        $requete->execute();
        $emplacements = $requete->fetchAll();


        if (count($emplacements) === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO emplacements VALUES (:idEmplacement, :libelleEmplacement, :descriptionEmplacement)');
            $pdoStat->bindValue(':idEmplacement', NULL);
            $pdoStat->bindValue(':libelleEmplacement', $emplacement->getLibelle(), PDO::PARAM_STR);
            $pdoStat->bindValue(':descriptionEmplacement', $emplacement->getDescription(), PDO::PARAM_STR);


            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo "";
            } else {
                echo "Ajout echoué";
            }
        } else {
            $response = "L'emplacement à été déja créé";
            return $response;
        }
    }

    /**Méthode pour supprimer un produit */
    public static function delete($idEmplacement)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM emplacements WHERE idEmplacement = $idEmplacement");
        $requete->execute();
    }

    //**Méthode pour faire la mise a jour d'un emplacement */
    public static function update(Emplacement $emplacement, $id)
    {
        include 'db-connect.php';

        $libelle = $emplacement->getLibelle();
        $description = $emplacement->getDescription();


        $sql = "UPDATE emplacements SET
                libelleEmplacement = '$libelle',
                descriptionEmplacement = '$description'
                WHERE idEmplacement = $id";

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


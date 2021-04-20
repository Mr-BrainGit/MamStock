<?php
class Categorie
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
        $requete = $bdd->prepare("SELECT * FROM categories");
        $requete->execute();
        return $requete->fetchAll();
    }

    /**Méthode pour ajouter un categorie */
    public static function create(Categorie $categorie)
    {
        include 'db-connect.php';
        $libelle = $categorie->getLibelle();

        $requete = $bdd->prepare("SELECT * FROM categories WHERE libelleCategorie = '$libelle'");
        $requete->execute();
        $categories = $requete->fetchAll();


        if (count($categories) === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO categories VALUES (:idCategorie, :libelleCategorie, :descriptionCategorie)');
            $pdoStat->bindValue(':idCategorie', NULL);
            $pdoStat->bindValue(':libelleCategorie', $categorie->getLibelle(), PDO::PARAM_STR);
            $pdoStat->bindValue(':descriptionCategorie', $categorie->getDescription(), PDO::PARAM_STR);


            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo "";
            } else {
                echo "Ajout echoué";
            }
        } else {
            $response = "La categorie à été déja créée";
            return $response;
        }
    }

    /**Méthode pour supprimer un produit */
    public static function delete($idCategorie)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM categories WHERE idCategorie = $idCategorie");
        $requete->execute();
    }

    //**Méthode pour faire la mise a jour d'un categorie */
    public static function update(Categorie $categorie, $id)
    {
        include 'db-connect.php';

        $libelle = $categorie->getLibelle();
        $description = $categorie->getDescription();


        $sql = "UPDATE categories SET
                libelleCategorie = '$libelle',
                descriptionCategorie = '$description'
                WHERE idCategorie = $id";

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

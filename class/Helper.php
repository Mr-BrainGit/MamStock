<?php

class Helper
{
    public static function getCategorieName($idCategorie)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT libelleCategorie FROM categories WHERE idCategorie = $idCategorie LIMIT 1");
		$requete->execute();
        $categorie = $requete->fetchAll();
        return $categorie[0]['libelleCategorie'];
    }

    public static function getEmplacementName($idEmplacement)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT libelleEmplacement FROM emplacements WHERE idEmplacement = $idEmplacement LIMIT 1");
		$requete->execute();
        $emplacement = $requete->fetchAll();
        return $emplacement[0]['libelleEmplacement'];
    }

    public static function getFournisseurName($idFournisseur)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT nomFournisseur, prenomFournisseur FROM fournisseurs WHERE idFournisseur = $idFournisseur LIMIT 1");
		$requete->execute();
        $fournisseur = $requete->fetchAll();
        $nomPrenom = $fournisseur[0]['nomFournisseur']." ". $fournisseur[0]['prenomFournisseur'];
        return $nomPrenom;
    }

    public static function getClientName($idClient)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT nomClient, prenomClient FROM clients WHERE idClient = $idClient LIMIT 1");
		$requete->execute();
        $client = $requete->fetchAll();
        $nomPrenom = $client[0]['nomClient']." ". $client[0]['prenomClient'];
        return $nomPrenom;
    }

    public static function getProduitName($idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT libelleProduit FROM produits WHERE idProduit = $idProduit LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();
        return $produit[0]['libelleProduit'];
    }

    public static function getProduitPrice($idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT prixUnit FROM produits WHERE idProduit = $idProduit LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();
        return $produit[0]['prixUnit'];
    }

    public static function getStockActuel($idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT stockActuelProduit FROM produits WHERE idProduit = $idProduit LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();
        return $produit[0]['stockActuelProduit'];
    }

    public static function getStockMax($idProduit)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT qteProduitMax FROM produits WHERE idProduit = $idProduit LIMIT 1");
		$requete->execute();
        $produit = $requete->fetchAll();
        return $produit[0]['qteProduitMax'];
    }

    public static function getFactureProducts($idFacture)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT * FROM ventes WHERE idFacture = $idFacture");
		$requete->execute();
        $produit = $requete->fetchAll();
        return $produit;
    }
}


<?php
class Dashboard
{
    public static function getProductsNumber()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits");
        $requete->execute();
        $products = $requete->fetchAll();
        return count($products);
    }

    public static function getStockVal()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits");
        $requete->execute();
        $products = $requete->fetchAll();
        $valeur = 0;

        foreach ($products as $product) {
            $valeur = $valeur + ($product['prixUnit']*$product['stockActuelProduit']);
        }

        return $valeur;
    }

    public static function getCommendeEnAttente()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM commandes WHERE etatCommande = 0");
        $requete->execute();
        $commande = $requete->fetchAll();
        
        return count($commande);
    }

    public static function getFactureEnAttente()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures WHERE etatFacture = 0");
        $requete->execute();
        $factures = $requete->fetchAll();
        
        return count($factures);
    }

    public static function getAllProviders()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM fournisseurs");
        $requete->execute();
        $fournisseurs = $requete->fetchAll();
        
        return count($fournisseurs);
    }

    public static function getAllCustumers()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM clients");
        $requete->execute();
        $clients = $requete->fetchAll();
        
        return count($clients);
    }

    public static function getAllUsers()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM users");
        $requete->execute();
        $users = $requete->fetchAll();
        
        return count($users);
    }

    public static function getAllCategorie()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM categories");
        $requete->execute();
        $users = $requete->fetchAll();
        
        return count($users);
    }

    public static function getTop5Products()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT idProduit, SUM(quantite) qte FROM ventes GROUP BY idProduit ORDER BY SUM(quantite) DESC");
        $requete->execute();
        $products = $requete->fetchAll();
        return $products;
        
        
    }

    public static function getTopSellProducts($idProduit, $delaiSecurite)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures");
        $requete->execute();
        $factures = $requete->fetchAll();
        $a = 0;
        $qteVendue = [];
        foreach ($factures as $facture) {
            $now = date_create(date("Y-m-d"));
            $d = $facture['dateFacture'];
            $date = date_create($d);
            $idFact = $facture['idFacture'];
            $diff = date_diff($now,$date);
            $interval = $diff->format('%D');
            
            
                $requete = $bdd->prepare("SELECT * FROM ventes WHERE idFacture = $idFact AND idProduit = $idProduit");
                $requete->execute();
                $vente = $requete->fetchAll();
                
                if (count($vente) !== 0) {
                    $qteVendue[] = $vente[0]['quantite'];
                }
            
        }
        if (count($qteVendue) > 0) {
            return round(array_sum($qteVendue)/count($qteVendue));
        }else{
            return 0;
        }
        
    }

    public static function getProductDelay($idProduit)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM commandes");
        $requete->execute();
        $commandes = $requete->fetchAll();

        $requete2 = $bdd->prepare("SELECT * FROM achats WHERE idProduit = $idProduit");
        $requete2->execute();
        $produitsAchat = $requete2->fetchAll();

        $fournisseurs = [];
        $deliveryDelay = [];
        foreach ($commandes as $commande) {
            $idCommande = $commande['idCommande'];
            foreach ($produitsAchat as $produitAchat) {
                if ($produitAchat['idCommande'] === $idCommande) {
                    $fournisseurs[] = $commande['idFournisseur'];
                }
            }
            

        }
        //echo '<pre>' ;var_dump($fournisseurs); echo '</pre>';
        $k = count($fournisseurs);
        for ($j=0; $j < $k; $j++) { 
            
            $id = $fournisseurs[$j];
            $requete = $bdd->prepare("SELECT deliveryDelay FROM fournisseurs WHERE idFournisseur = $id");
            $requete->execute();
            $delay = $requete->fetchAll();
            $deliveryDelay[] = $delay[0][0];
            
        }

        if (count($deliveryDelay) > 0) {
            $moyenne = round(array_sum($deliveryDelay)/count($deliveryDelay));
        } else {
            $moyenne = 0;
        }
        
        //echo '<pre>' ;var_dump($moyenne); echo '</pre>';
        return $moyenne;
        
    }

    public static function getProducMargetDelay($idProduit)
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM commandes");
        $requete->execute();
        $commandes = $requete->fetchAll();

        $requete2 = $bdd->prepare("SELECT * FROM achats WHERE idProduit = $idProduit");
        $requete2->execute();
        $produitsAchat = $requete2->fetchAll();

        $fournisseurs = [];
        $marges = [];
        $deliveryDelayMarge = [];
        foreach ($commandes as $commande) {
            $idCommande = $commande['idCommande'];
            foreach ($produitsAchat as $produitAchat) {
                if ($produitAchat['idCommande'] === $idCommande) {
                    $fournisseurs[] = $commande['idFournisseur'];
                    $d = $commande['dateCommande'];
                    $d2 = $commande['dateArrivee'];
                    $date = date_create($d);
                    $date2 = date_create($d2);
                    $marges[] = date_diff($date2, $date)->format('%D');
                }
            }
            

        }
        //echo '<pre>' ;var_dump($fournisseurs); echo '</pre>';
        $k = count($fournisseurs);
        for ($j=0; $j < $k; $j++) { 
            
            $id = $fournisseurs[$j];
            $requete = $bdd->prepare("SELECT deliveryDelay FROM fournisseurs WHERE idFournisseur = $id");
            $requete->execute();
            $delay = $requete->fetchAll();
            $deliveryDelayMarge[] = $marges[$j] - $delay[0][0];
            
        }

        //$moyenne = round(array_sum($deliveryDelay)/count($deliveryDelay));
        //echo '<pre>' ;var_dump($deliveryDelayMarge); echo '</pre>';
        if (count($deliveryDelayMarge) > 0) {
            return max($deliveryDelayMarge);
        } else {
            return 0;
        }
        
        
    }


    public static function getAffluenceVente()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM factures");
        $requete->execute();
        return $requete->fetchAll();
        
    }

    
    public static function getStockMinProducts()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM produits WHERE stockActuelProduit <= qteProduitMin");
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function getStockAlerte($idProduit, $delaiSecurite)
    {
        $moyenneVente = Dashboard::getTopSellProducts($idProduit, $delaiSecurite);
        $delaiMoyenLivraison = Dashboard::getProductDelay($idProduit);
        $stockMin = $moyenneVente * $delaiMoyenLivraison;
        if (Dashboard::getProducMargetDelay($idProduit) > 0) {
            $stockSecurite = Dashboard::getProducMargetDelay($idProduit) * $moyenneVente;
        } else {
            $stockSecurite = 7 * $moyenneVente;
        }
        
        $stockAlerte = $stockMin + $stockSecurite;
        /*echo $moyenneVente;
        echo '<br> delais de livraison ';
        echo $delaiMoyenLivraison;
        echo '<br> stock min ';
        echo $stockMin;
        echo '<br> stock securite ';
        echo $stockSecurite;
        echo '<br> stock alerte ';*/
        return $stockAlerte;
    }

    public static function getStocMin($idProduit, $delaiSecurite)
    {
        $moyenneVente = Dashboard::getTopSellProducts($idProduit, $delaiSecurite);
        $delaiMoyenLivraison = Dashboard::getProductDelay($idProduit);
        $stockMin = $moyenneVente * $delaiMoyenLivraison;
        if (Dashboard::getProducMargetDelay($idProduit) > 0) {
            $stockSecurite = Dashboard::getProducMargetDelay($idProduit) * $moyenneVente;
        } else {
            $stockSecurite = 7 * $moyenneVente;
        }
        
        $stockAlerte = $stockMin + $stockSecurite;
        /*echo $moyenneVente;
        echo '<br> delais de livraison ';
        echo $delaiMoyenLivraison;
        echo '<br> stock min ';
        echo $stockMin;
        echo '<br> stock securite ';
        echo $stockSecurite;
        echo '<br> stock alerte ';*/
        return $stockMin;
    }

    

   
}


$fournisseurs = Dashboard::getStockAlerte(2, 1);









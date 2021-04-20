<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/InventaireProduct.php';
  include '../../class/Helper.php';

  $codeProduit = $_POST['codeProduit'];
  $quantite = $_POST['quantite'];
  $codeCommande = $_POST['codeCommande'];
  
  $produit = Produit::findById($codeProduit);
  $diff =  $quantite - $produit['stockActuelProduit'];

  $achat = new InventaireProduct($codeProduit, $quantite, $codeCommande, $diff);
  InventaireProduct::createFake($achat);
  
  
  

?>



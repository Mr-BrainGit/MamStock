<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/Achat.php';
  include '../../class/Helper.php';

  $codeProduit = $_POST['codeProduit'];
  $quantite = $_POST['quantite'];
  $codeCommande = $_POST['codeCommande'];
  
  $achat = new Achat($codeProduit, $quantite, $codeCommande);
  Achat::createFake($achat);
  
  

  
  

?>



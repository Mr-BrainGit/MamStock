 
<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Vente.php';
  include '../../class/Helper.php';

  $codeProduit = $_POST['codeProduit'];
  $quantite = $_POST['quantite'];
  $codeFacture = $_POST['codeFacture'];

  $vente = new Vente($codeProduit, $quantite, $codeFacture);
  Vente::createFake($vente);


?>
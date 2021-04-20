<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Vente.php';
  include '../../class/Helper.php';

  $codeProduit = $_POST['codeProduit'];
  $quantite = $_POST['quantite'];
  $codeFacture = $_POST['codeFacture'];

$sommeQte = Vente::sommeQte('fakeventes',$codeFacture,$codeProduit)[0]['qteTotale'];
$qteActuelle = Helper::getStockActuel($codeProduit);

if (($quantite > $qteActuelle) || ($sommeQte >= $qteActuelle)) {
  echo 1;
} else {
  echo 0;
}
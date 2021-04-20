<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Achat.php';
  include '../../class/Helper.php';

  $codeProduit = $_POST['codeProduit'];
  $quantite = $_POST['quantite'];
  $codeCommande = $_POST['codeCommande'];

$sommeQte = Achat::sommeQte('fakeachats',$codeCommande,$codeProduit)[0]['qteTotale'];
$qteMax = Helper::getStockMax($codeProduit);
$qteActuelle = Helper::getStockActuel($codeProduit);

$quantite = $quantite + $qteActuelle;
$sommeQte = $sommeQte + $qteActuelle;

if (($quantite > $qteMax) || ($sommeQte >= $qteMax)) {
  echo 1;
} else {
  echo 0;
}

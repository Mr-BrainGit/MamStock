<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Vente.php';
  include '../../class/Helper.php';


  $codeFacture = $_POST['codeFacture'];


  $facture = Facture::findByFakeFactureCode($codeFacture);


  $idFacture = $facture['idFacture'];
  $date = $facture['dateFacture'];
  $client = $facture['idClient'];
  $commentaire = $facture['commentaire'];

  $newFacture = new Facture(0, $date, $client, 0, $commentaire);
  Facture::create($newFacture);
  $validId = Facture::getLastId();

  $ventes = Vente::getAllByFakeFactureId($idFacture);

  foreach ($ventes as $vente) {
    $id = $vente['idProduit'];
    $qte = $vente['quantite'];
    $tmpvente = new Vente($id, $qte, $validId);
    Vente::create($tmpvente);
  }


  /*Vente::truncateFakeTable();*/
  echo "<meta http-equiv='refresh' content='1'>";



?>
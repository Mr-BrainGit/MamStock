<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Categorie.php';
  include '../../class/Helper.php';

  $date = $_POST['dateVente'];
  $idClient = $_POST['idClient'];
  $commentaire = $_POST['commentaire'];

  $facture = new Facture(2, $date, $idClient, 0, $commentaire);

  $result = Facture::createFake($facture);

  echo Facture::getFakeLastId();

?>
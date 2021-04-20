<?php
  include '../../class/Inventaire.php';
  include '../../class/Produit.php';
  include '../../class/Categorie.php';
  include '../../class/Helper.php';

  $date = $_POST['dateAppro'];
  $idFornisseur = $_POST['idFournisseur'];
  $commentaire = $_POST['commentaire'];

  $commande = new Inventaire(2, $date, 0, $commentaire);

  $result = Inventaire::createFake($commande);

  echo Inventaire::getFakeLastId();
  
 
  
  

?>



<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/Categorie.php';
  include '../../class/Helper.php';

  $date = $_POST['dateAppro'];
  $idFornisseur = $_POST['idFournisseur'];
  $commentaire = $_POST['commentaire'];

  $commande = new Commande(2, $date, $idFornisseur, 0, $commentaire);

  $result = Commande::createFake($commande);

  echo Commande::getFakeLastId();
  
 
  
  

?>



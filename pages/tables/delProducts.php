<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/Achat.php';
  include '../../class/Helper.php';

  
  $idProd = $_POST['idProd'];
  Achat::deleteFake($idProd);
  
  if (isset($_POST['idProduit'])) {
    $idCommProd = $_POST['idProduit'];

    Achat::delete($idCommProd);
    var_dump($idCommProd);
  }
  


?>



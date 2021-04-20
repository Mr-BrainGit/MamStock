<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/InventaireProduct.php';
  include '../../class/Helper.php';

  
  $idProd = $_POST['idProd'];
  InventaireProduct::deleteFake($idProd);
  
  if (isset($_POST['idProduit'])) {
    $idCommProd = $_POST['idProduit'];

    InventaireProduct::delete($idCommProd);
    var_dump($idCommProd);
  }
  


?>



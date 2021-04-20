 
<?php
  include '../../class/Facture.php';
  include '../../class/Produit.php';
  include '../../class/Vente.php';
  include '../../class/Helper.php';


$idProd = $_POST['idProd'];
Vente::deleteFake($idProd);

if (isset($_POST['idProduit'])) {
  $idFactProd = $_POST['idProduit'];

  Vente::delete($idFactProd);
}



?>
<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
  include '../../class/Inventaire.php';
  include '../../class/Produit.php';
  include '../../class/InventaireProduct.php';
  include '../../class/Helper.php';


  $codeCommande = $_POST['codeCommande'];
  
 
  $commande = Inventaire::findByFakeInventaireCode($codeCommande);
  

  $idCommande = $commande['idInventaire'];
  $date = $commande['dateInventaire'];
  $commentaire = $commande['commentaire'];

  $newCommande = new Inventaire(0, $date, 0, $commentaire);
  Inventaire::create($newCommande);
  $validId = Inventaire::getLastId();
  
  $achats = InventaireProduct::getAllByFakeInventaireId($idCommande);
  
  foreach ($achats as $achat) {
    $id = $achat['idProduit'];
    $qte = $achat['quantite'];
    $diff = $achat['diff'];
    $tmpachat = new InventaireProduct($id, $qte, $validId, $diff);
    InventaireProduct::create($tmpachat);
  }

  
  
  echo "<meta http-equiv='refresh' content='1'>";
  
  

?>



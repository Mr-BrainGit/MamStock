<?php
  include '../../class/Commande.php';
  include '../../class/Produit.php';
  include '../../class/Achat.php';
  include '../../class/Helper.php';


  $codeCommande = $_POST['codeCommande'];


  $commande = Commande::findByFakeCommandeCode($codeCommande);


  $idCommande = $commande['idCommande'];
  $date = $commande['dateCommande'];
  $fournisseur = $commande['idFournisseur'];
  $commentaire = $commande['commentaire'];

  $newCommande = new Commande(0, $date, $fournisseur, 0, $commentaire);
  Commande::create($newCommande);
  $validId = Commande::getLastId();

  $achats = Achat::getAllByFakeCommandeId($idCommande);

  foreach ($achats as $achat) {
    $id = $achat['idProduit'];
    $qte = $achat['quantite'];
    $tmpachat = new Achat($id, $qte, $validId);
    Achat::create($tmpachat);
  }


  // Achat::truncateFakeTable();
  echo "<meta http-equiv='refresh' content='1'>";



?>



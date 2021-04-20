<?php
include '../../class/Facture.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/Vente.php';
include '../../class/db-connect.php';

$codeProduit = $_POST['codeProduit'];
$quantite = $_POST['quantite'];
$idFacture = $_POST['codeFacture'];

$ventes = Vente::getAllByFakeFactureId($idFacture);

$requete = $bdd->prepare("SELECT * FROM fakefactures");
$requete->execute();

?>

<table id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix Unitaire</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prixTotal = 0;
        $id = [];
        foreach ($ventes as $vente) {
            if (in_array($vente['idProduit'], $id) != true) { ?>
                    <tr>
                        <td style="padding-top:17px;"><?= Helper::getProduitName($vente['idProduit']) ?></td>
                        <td style="padding-top:17px;"><?= number_format(Helper::getProduitPrice($vente['idProduit']), 0, NULL, " ")  ?></td>
                        <td style="padding-top:17px;"><?php
                                                        $prixTotal += Vente::sommeQte('fakeventes', $idFacture, $vente['idProduit'])[0]['qteTotale'] * Helper::getProduitPrice($vente['idProduit']);
                                                        echo Vente::sommeQte('fakeventes', $idFacture, $vente['idProduit'])[0]['qteTotale'];
                                                        ?></td>
                        <td style="padding-top:17px;">
                            <button id="delProd" onclick="del('<?= $vente['idProduit'] ?>')" type="button" data-idProd="<?= $vente['idProduit'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>


                <!--  -->
        <?php }
            $id[] = $vente['idProduit'];
        } ?>
    </tbody>
</table>

<div class="form-row">
    <div class=" form-group col-md-12">
        <label for="prixTotal">Somme à payer <span class="text-muted"> (FCFA)</span> </label>
        <input type="number" class="form-control" readonly value="<?= $prixTotal ?>" id="prixTotal" name="prixTotal">
    </div>
</div>


<script>
    for (i = 0; i < button.length; i++) {
        button[i].addEventListener('click', function(e) {
            var x = button[i].getAttribute('data-idProd');
            alert(x);
        })
    }
</script>
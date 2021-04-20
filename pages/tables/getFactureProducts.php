<?php
include '../../class/Facture.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/Vente.php';
include '../../class/db-connect.php';


$idFacture = $_POST['idFacture'];

$ventes = Vente::getAllByFactureId($idFacture);



?>

<table id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>

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
                    <td style="padding-top:17px;"><?php
                                                    $prixTotal += Vente::sommeQte('ventes', $idFacture, $vente['idProduit'])[0]['qteTotale'] * Helper::getProduitPrice($vente['idProduit']);
                                                    echo Vente::sommeQte('ventes', $idFacture, $vente['idProduit'])[0]['qteTotale'];
                                                    ?></td>
                </tr>


                <!--  -->
        <?php }
            $id[] = $vente['idProduit'];
        } ?>

    </tbody>

</table>

<div class="form-row">
    <div class=" form-group col-md-12">
        <label for="prixTotal">Somme reglée <span class="text-muted"> (FCFA)</span> </label>
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
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

<form method="post" id="form">
    <table id="example1" class="table table-bordered table-hover">
        <input type="hidden" value="<?php echo $idFacture ?>" name="idVente2" id="idvente">
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
                        <td style="padding-top:17px;"><input type="hidden" class="form-control" name="values[id][]" value="<?= $vente['idProduit'] ?>"> <?php echo Helper::getProduitName($vente['idProduit']);
                $prixTotal += Vente::sommeQte('ventes', $idFacture, $vente['idProduit'])[0]['qteTotale'] * Helper::getProduitPrice($vente['idProduit']);
                        ?></td>
                        <td style="padding-top:17px;"> <input type="hidden" class="form-control" name="values[qteFinale][]" value="<?= Vente::sommeQte('ventes', $idFacture, $vente['idProduit'])[0]['qteTotale'] ?>" min=0> <?= Vente::sommeQte('ventes', $idFacture, $vente['idProduit'])[0]['qteTotale'] ?>
                        </td>
                    </tr>

            <?php
                    }
                $id[] = $vente['idProduit'];
                }
            ?>
        </tbody>

    </table>


    <div class="form-row">
        <div class=" form-group col-md-12">
            <label for="prixTotal">Somme à payer <span class="text-muted"> (FCFA)</span> </label>
            <input type="number" class="form-control" readonly value="<?= $prixTotal ?>" id="prixTotal" name="prixTotal">
        </div>
    </div>

    <div class="" style="margin-left: 86%;">
        <button type="submit" name="upgrade" class="btn btn-info">Valider</button>
    </div><br>

</form>


<script>
    for (i = 0; i < button.length; i++) {
        button[i].addEventListener('click', function(e) {
            var x = button[i].getAttribute('data-idProd');
            alert(x);
        })
    }
</script>
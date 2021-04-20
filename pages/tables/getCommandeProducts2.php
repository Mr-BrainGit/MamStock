<?php
include '../../class/Commande.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/Achat.php';
include '../../class/db-connect.php';


$idCommande = $_POST['idCommande'];


$achats = Achat::getAllByCommandeId($idCommande);



?>

<form method="post" id="form">
    <table id="example1" class="table table-bordered table-hover">
        <input type="hidden" value="<?php echo $idCommande ?>" name="idComm2" id="idcom">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>

            </tr>
        </thead>
        <tbody>

            <?php
            $id = [];
            foreach ($achats as $achat) {

                $qteMax = Helper::getStockMax($achat['idProduit']);
                $qteActuelle = Helper::getStockActuel($achat['idProduit']);
                $qteMax = $qteMax - $qteActuelle;

                if (in_array($achat['idProduit'], $id) != true) { ?>
                    <tr>
                        <td style="padding-top:17px;"><input type="hidden" class="form-control" name="values[id][]" value="<?= $achat['idProduit'] ?>"><?= Helper::getProduitName($achat['idProduit']) ?></td>
                        <td style="padding-top:17px;"> <input type="number" class="form-control" name="values[qteFinale][]" value="<?= Achat::sommeQte('achats', $idCommande, $achat['idProduit'])[0]['qteTotale']; ?>" min=0 max=<?=$qteMax?>>
                    </tr>
            <?php }
                $id[] = $achat['idProduit'];
            } ?>


        </tbody>

    </table>
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

<?php
include '../../class/Commande.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/InventaireProduct.php';
include '../../class/Inventaire.php';
include '../../class/db-connect.php';


$idCommande = $_POST['idCommande'];

$achats = InventaireProduct::getAllByInventaireId($idCommande);



?>

<form method="post">
    <table id="example1" class="table table-bordered table-hover">
        <input type="hidden" value="<?php echo $idCommande ?>" name="idComm2" id="idcom">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité logique</th>
                <th>Quantité physique</th>
                <th>Difference</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $id = [];
            foreach ($achats as $achat) {
                if (in_array($achat['idProduit'], $id) != true) {
            ?>
                    <tr>
                        <td style="padding-top:17px;"><?php echo Helper::getProduitName($achat['idProduit']) ?></td>
                        <td style="padding-top:17px;">
                            <?php $prod = Produit::findById($achat['idProduit']);
                            echo $prod['stockActuelProduit']; ?>
                        </td>
                        <td style="padding-top:17px;"><?php
                                                        $somme = Inventaire::sommeQte('inventairesproducts', $idCommande, $achat['idProduit'])[0]['qteTotale'];
                                                        echo $somme;
                                                        ?></td>
                        <td style="padding-top:17px;">
                            <?php $prod = Produit::findById($achat['idProduit']);
                            $act = $prod['stockActuelProduit'];
                            $diff = $somme - $act;
                            if ($diff > 0) {
                                echo '+';
                            }
                            echo $diff;
                            ?>
                        </td>
                    </tr>
            <?php
                }
                $id[] = $achat['idProduit'];
            }
            ?>
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

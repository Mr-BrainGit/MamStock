<?php
include '../../class/Commande.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/InventaireProduct.php';
include '../../class/Inventaire.php';
include '../../class/db-connect.php';


$idCommande = $_POST['codeCommande'];

$achats = InventaireProduct::getAllByFakeInventaireId($idCommande);



?>

<table id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité logique</th>
            <th>Quantité Physique</th>
            <th>Différence</th>
            <th>Actions</th>
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
                                                    $somme = Inventaire::sommeQte('fakeinventairesproducts', $idCommande, $achat['idProduit'])[0]['qteTotale'];
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

                    <td style="padding-top:17px;">
                        <button id="delProd" onclick="del('<?php echo $achat['idProduit'] ?>')" type="button" data-idProd="<?php echo $achat['idProduit'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </td>

                </tr>
        <?php
            }
            $id[] = $achat['idProduit'];
        }
        ?>
    </tbody>

</table>

<script>
    for (i = 0; i < button.length; i++) {
        button[i].addEventListener('click', function(e) {
            var x = button[i].getAttribute('data-idProd');
            alert(x);
        })
    }
</script>

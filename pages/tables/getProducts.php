<?php
include '../../class/Commande.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/Achat.php';
include '../../class/db-connect.php';

$codeProduit = $_POST['codeProduit'];
$quantite = $_POST['quantite'];
$idCommande = $_POST['codeCommande'];

$achats = Achat::getAllByFakeCommandeId($idCommande);

$requete = $bdd->prepare("SELECT * FROM fakecommandes");
$requete->execute();

?>

<table id="example1" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $id = []; ?>
        <?php foreach ($achats as $achat) : ?>
            <?php if (in_array($achat['idProduit'], $id) != true) : ?>
                <tr>
                    <td style="padding-top:17px;"><?php echo Helper::getProduitName($achat['idProduit']) ?></td>
                    <td style="padding-top:17px;"><?= Achat::sommeQte('fakeachats', $idCommande, $achat['idProduit'])[0]['qteTotale']; ?></td>

                    <td style="padding-top:17px;">
                        <button id="delProd" onclick="del('<?php echo $achat['idProduit'] ?>')" type="button" data-idProd="<?php echo $achat['idProduit'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </td>

                </tr>
            <?php endif ?>
            <?php $id[] = $achat['idProduit']; ?>
        <?php endforeach ?>
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

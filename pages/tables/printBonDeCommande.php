
<?php 
include '../../class/db-connect.php';
include '../../class/Commande.php';
include '../../class/Fournisseur.php';
include '../../class/Achat.php';
include '../../class/Helper.php';
$id = $_GET['id'];
$requete = $bdd->prepare("SELECT * FROM achats WHERE idCommande = $id");
$requete->execute();
$produits = $requete->fetchAll();

$count = 1;

$commandes = Commande::findByCommandeCode($id);
$idFournisseur = $commandes['idFournisseur'];
$fournisseur = Fournisseur::findByCode($idFournisseur);
header('Refresh:.0001; URL=input.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MamStock</title>
  <link rel="icon" type="image/png" href="../../dist/img/logo.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/Mam_style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <style>
  
  </style>
</head>



<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->

    <div class="container" style="width: 78%;">
        <div class="row">
            <div class="col-md-9">
                <div class="container">
                    <img src="../../dist/img/logo.ico" style="margin-top: -30px;" alt="">
                    <div class="img" style=" margin-top: -50px; margin-left: 15px;">
                        <p>SOMGANDE, OUAGADOUGOU <br>
                        Adresse<span>&nbsp;</span>:  BP 202 Ouaga <br>
                        Tel (+226): 62 82 64 88, 66 59 48 66 , 66 68 03 54 <br>
                        Fax (+226): 25 35 67 62
                        </p>
                    </div><hr width="1000">
                    <div class="img" style=" margin-left: 15px;">
                        <p>Coordonnées du fournisseur<br>
                        Nom: <?php echo $fournisseur[0]['nomFournisseur']. ' '. $fournisseur[0]['prenomFournisseur'];?><?php if($fournisseur[0]['nomStructFournisseur'] != null):?> de <i><?php echo $fournisseur[0]['nomStructFournisseur']?></i> <?php endif?> <br>
                        Adresse<span>&nbsp;</span>:  <?php echo $fournisseur[0]['adresseFournisseur'];?> <br>
                        Tel: <?php echo $fournisseur[0]['telFournisseur'];?> <br>
                        Email: <?php echo $fournisseur[0]['emailFournisseur'];?>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="container" style="margin-top: 200px;">
                    <h4>COMMANDE N°<?php echo $id?></h4>
                    <h5>Date: <?php echo date("d-m-Y", strtotime($commandes['dateCommande']));?></h5>
                </div>
            </div>
        </div>
        
    </div> 
    
    <div class="container">
        
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
        <div style="text-align:center;">
              
            </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="container">

          <div class="row">
            <div class="" style="width: 120%; margin: auto;">

              <div class="card">


                <!-- /.card-header -->
                <div class="card-body">
                  
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr style="background-color: silver;">
                        <th>N°</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $idTab = []; ?>
                      <?php foreach ($produits as $produit) : ?>
                        <?php if(in_array($produit['idProduit'], $idTab) != true): ?>
                          <tr>
                            <td> <?php echo $count++; ?> </td>
                            <td><?php echo Helper::getProduitName($produit['idProduit']); ?></td>
                            <td><?php echo Achat::sommeQte('achats', $id, $produit['idProduit'])[0]['qteTotale']; ?></td>
                            
                          </tr>
                        <?php endif ?>
                        <?php $idTab[] = $produit['idProduit']; ?>
                        
                      <?php endforeach ?>

                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
              </div>

              <div class="container" style="margin-left: 85%;">
                <h3>Le gérant</h3>
              </div>
              
              <div class="container" style="margin-top: 150px; text-align: center;">
                <h4>Merci pour votre confiance !</h4>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
   
  </div>

  <script type="text/javascript">window.print();</script>
 
  

  
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  

  <!-- AJOUT -->
  


  
  <?php
			
			
		?>


  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/bootstrap/js/Mam_script.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../plugins/jszip/jszip.min.js"></script>
  <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="../../plugins/dist/bootstrap-select//bootstrap-select.min.js"></script>
  <script src="../../Js/DataTables.js"></script>
  <script type="text/javascript" src="../../Js/Alert.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>
  <script src="../../dist/js/demo.js"></script>

  <!-- Page specific script -->
  
</body>

</html>
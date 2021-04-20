<?php
include '../../class/Emplacement.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/User.php';
include '../../class/Dashboard.php';

User::forcedConnexion("login.php");

$emplacements = [];
$emplacements = Emplacement::getAll();

$categories = [];
$categories = Categorie::getAll();

$produits = [];
$produits = Produit::getAll();


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
  <!-- <script type="text/javascript">
    if (this.name != 'fullscreen') {
      window.open(location.href, 'fullscreen', 'fullscreen,scrollbars')
    }
  </script> -->
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php" role="button">
            <i class="fas fa-power-off"></i>
          </a>
        </li>

        <?php

            $produits = Produit::getAll();
            $nb = 0;
          ?>
            <?php foreach($produits as $p): ?>
              <?php if(Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay']) > $p['stockActuelProduit'] ): ?>
                <?php $nb++; ?>
              <?php endif ?>
            <?php endforeach ?>

          
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge"><?php echo $nb; ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><?php echo $nb;?> alerte<?php if($nb > 1){echo 's';} ?> de stock</span>
            <div class="dropdown-divider"></div>

            <?php foreach($produits as $p): ?>
              <?php $nb++; if(Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay']) > $p['stockActuelProduit'] ): ?>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i> Le produit <?php echo Helper::getProduitName($p['idProduit']); ?><br><i class="fas fa-enlvelope mr-4"></i> a ateint son stock d'alerte <?php echo Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay'])?>
                </a>
              <div class="dropdown-divider"></div>

              <?php endif ?>
            <?php endforeach ?>

            <?php if ($nb !== 0) : ?>
              <div class="dropdown-divider"></div>
                <a href="input.php" class="dropdown-item dropdown-footer">S'approvisionnez</a>
              </div>
            <?php endif; ?>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-info elevation-4" style="background-color: #eee">
      <!-- Brand Logo -->
      <a href="../../index.php" class="brand-link" style="background-color: white;">
        <img src="../../dist/img/logo.ico" alt="Mamstock Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text">Mam</span><span class="brand-text" id="target"></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <a href="users.php">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src=<?php echo $_SESSION['MM_Image']; ?> class="elevation-2" alt="User Image">
            </div>
            <div class="info">
              <?= $_SESSION['MM_Username']; ?>
            </div>
          </div>
        </a>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="../../index.php" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>
                  Tableau de bord
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="products.php" class="nav-link">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                  Produits
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="stocks.php" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                  Stock
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="input.php" class="nav-link">
                    <i class="far fas fa-cart-arrow-down nav-icon"></i>
                    <p>Entrées</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="output.php" class="nav-link">
                    <i class="far fas fa-dolly nav-icon"></i>
                    <p>Sorties</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="productsSellByDate.php" class="nav-link">
                    <i class="far fas fa-dolly nav-icon"></i>
                    <p>Etat des sorties</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="inventaire.php" class="nav-link">
                    <i class="far fas fa-retweet nav-icon"></i>
                    <p>Inventaires</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="provider.php" class="nav-link">
                <i class="nav-icon fas fa-truck-moving"></i>
                <p>
                  Fournisseurs
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="customers.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Clients
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="configuration.php" class="nav-link active">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Configuration
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="categories.php" class="nav-link">
                    <i class="far fas fa-cubes nav-icon"></i>
                    <p>Catégories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="locations.php" class="nav-link active">
                    <i class="far fas fa-map-marker-alt nav-icon"></i>
                    <p>Emplacements</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="users.php" class="nav-link">
                    <i class="far fa-user nav-icon"></i>
                    <p>Utilisateurs</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>



    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6" style="margin-left: 2%;">
              <h1>Emplacements</h1>
            </div>


          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <div class="container-fluid">
          <div class="row">
            <div class="" style="width: 95%; margin: auto;">

              <div class="card">


                <!-- /.card-header -->
                <div class="card-body">

                  <div class="container" style="width:15%; margin-left:90%; padding-bottom:10px;">
                    <button type="button" class="btn btn-info" data-type="ajout" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Ajouter</button>
                  </div>
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Libellé</th>
                        <th>Description</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($emplacements as $emplacement) : ?>
                        <tr>
                          <td style="padding-top:17px;"><?php echo $emplacement['libelleEmplacement'] ?></td>
                          <td style="padding-top:17px;"><?php
                                                        if ($emplacement['descriptionEmplacement'] == NULL) {
                                                          echo "Non défini";
                                                        } else {
                                                          echo $emplacement['descriptionEmplacement'];
                                                        }
                                                        ?></td>
                          <td>
                            <button type="button" id="edit" data-type="edit" data-idemplacement="<?php echo $emplacement['idEmplacement'] ?>" data-libelle="<?php echo $emplacement['libelleEmplacement'] ?>" data-description="<?php echo $emplacement['descriptionEmplacement'] ?>" data-toggle="modal" data-target="#modal-lg" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>
                            </button>
                            <button type="button" data-idemplacement="<?php echo $emplacement['idEmplacement'] ?>" data-toggle="modal" data-target="#confirm-modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </td>
                        </tr>
                      <?php endforeach ?>


                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
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
    <footer class="main-footer">
      <strong>Copyright &copy; 2020-2021 MamStock-Miage2/IBAM</strong>
      Tous droits reservés
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
      </div>
    </footer>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- AJOUT -->
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ajouter un emplacement

          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container">
          <!--<div class="alert alert-danger" role="alert">
          This is a danger alert—check it out!
        </div>-->
        </div>
        <div class="modal-body">
          <form id="forms" method="POST">
            <div class="container modal-body">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <input type="hidden" name="idEmplacement" id="idEmplacement">
                  <label for="libelle">Libellé de l'emplacement</label>
                  <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Emplacement du magasin">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="description">Description <span class="text-muted">(Optionnelle)</span></label>
                  <textarea rows="7" class="form-control" id="description" name="description" placeholder="Saisissez la description de l'emplacement..."> </textarea>
                </div>
              </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          <input type="submit" name="submit" id="save-btn" value="Enregistrer" class="btn btn-info">
          <input type="submit" name="update" id="update-btn" value="Modifier" class="btn btn-info">
        </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div>

  <div class="modal" id="confirm-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST">
          <input type="hidden" id="idDel" name="idEmplacement">
          <div class="modal-body">
            <p>Voulez-vous vraiment supprimer cet emplacement ?</p>
          </div>
          <div class="modal-footer">
            <button type="submit" name="delete" class="btn btn-danger">Oui</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
          </div>
        </form>

      </div>
    </div>
  </div>





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
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript" src="../../Js/Alert.js"></script>

  <script>
    /**Script pour préremplir les champs du formulaire de mise à jour */
    $('#modal-lg').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      if (button.data('type') === 'ajout') {
        $('.modal-title').text('Ajouter un emplacement');
        $('#libelle').val('');
        $('#description').val('');
        $('#update-btn').hide();
        $('#save-btn').show();
      } else {
        $('.modal-title').text('Modifier un emplacement');
        var idEmplacement = button.data('idemplacement');
        var libelle = button.data('libelle');
        var description = button.data('description');
        $('#idEmplacement').val(idEmplacement);
        $('#libelle').val(libelle);
        $('#description').val(description);
        $('#update-btn').show();
        $('#save-btn').hide();
      }

    })

    $('#confirm-modal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('idemplacement');
      $('.modal-title').text('Confirmation');
      $('#idDel').val(id);
    })
  </script>
  <!-- Logique de l'appli (PHP + JS) -->

  <?php if (isset($_POST['submit']) || isset($_POST['update'])) : ?>
    <?php if (isset($_POST['submit'])) : ?>
      <?php
      var_dump($_POST);
      $libelle = $_POST['libelle'];
      $description = $_POST['description'];

      $emplacement = new Emplacement($libelle, $description);
      Emplacement::create($emplacement);

      echo "<meta http-equiv='refresh' content='1'>";
      ?>
      <script>
        var text = 'Emplacement ajouté avec succès !';

        function alerter() {
          Swal.fire({
            title: text,
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
          })
        }
        alerter();
      </script>
    <?php endif ?>

    <?php if (isset($_POST['update'])) : ?>
      <?php
      $id = $_POST['idEmplacement'];
      $libelle = $_POST['libelle'];
      $description = $_POST['description'];

      $emplacement = new Emplacement($libelle, $description);
      Emplacement::update($emplacement, $id);

      echo "<meta http-equiv='refresh' content='1'>";
      ?>
      <script>
        var text = 'Mise à jour effectué avec succès!';

        function alerter() {
          Swal.fire({
            title: text,
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
          })
        }
        alerter();
      </script>
    <?php endif ?>

  <?php endif ?>

  <?php if (isset($_POST['delete'])) : ?>
    <?php
    $id = $_POST['idEmplacement'];
    Emplacement::delete($id);

    echo "<meta http-equiv='refresh' content='1'>";
    ?>
    <script>
      var text = 'Emplacement supprimé avec succès !';

      function alerter() {
        Swal.fire({
          title: text,
          text: '',
          icon: 'success',
          confirmButtonText: 'OK'
        })
      }
      alerter();
    </script>
  <?php endif ?>

  <script>
    /**Script pour la validation du formulaire d'ajout */
    $.validator.addMethod('greaterThan', function(value, element, param) {
      return this.optional(element) || parseInt(value) >= parseInt($(param).val());
    }, 'Invalid value');

    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "print", "colvis"],
        "language": {
          "emptyTable": "Aucune donnée disponible dans le tableau",
          "lengthMenu": "Afficher _MENU_ éléments",
          "loadingRecords": "Chargement...",
          "processing": "Traitement...",
          "zeroRecords": "Aucun élément correspondant trouvé",
          "paginate": {
            "first": "Premier",
            "last": "Dernier",
            "next": "Suivant",
            "previous": "Précédent"
          },
          "aria": {
            "sortAscending": ": activer pour trier la colonne par ordre croissant",
            "sortDescending": ": activer pour trier la colonne par ordre décroissant"
          },
          "select": {
            "rows": {
              "_": "%d lignes sélectionnées",
              "0": "Aucune ligne sélectionnée",
              "1": "1 ligne sélectionnée"
            },
            "1": "1 ligne selectionnée",
            "_": "%d lignes selectionnées",
            "cells": {
              "1": "1 cellule sélectionnée",
              "_": "%d cellules sélectionnées"
            },
            "columns": {
              "1": "1 colonne sélectionnée",
              "_": "%d colonnes sélectionnées"
            }
          },
          "autoFill": {
            "cancel": "Annuler",
            "fill": "Remplir toutes les cellules avec <i>%d<\/i>",
            "fillHorizontal": "Remplir les cellules horizontalement",
            "fillVertical": "Remplir les cellules verticalement",
            "info": "Exemple de remplissage automatique"
          },
          "searchBuilder": {
            "conditions": {
              "date": {
                "after": "Après le",
                "before": "Avant le",
                "between": "Entre",
                "empty": "Vide",
                "equals": "Egal à",
                "not": "Différent de",
                "notBetween": "Pas entre",
                "notEmpty": "Non vide"
              },
              "number": {
                "between": "Entre",
                "empty": "Vide",
                "equals": "Egal à",
                "gt": "Supérieur à",
                "gte": "Supérieur ou égal à",
                "lt": "Inférieur à",
                "lte": "Inférieur ou égal à",
                "not": "Différent de",
                "notBetween": "Pas entre",
                "notEmpty": "Non vide"
              },
              "string": {
                "contains": "Contient",
                "empty": "Vide",
                "endsWith": "Se termine par",
                "equals": "Egal à",
                "not": "Différent de",
                "notEmpty": "Non vide",
                "startsWith": "Commence par"
              },
              "array": {
                "equals": "Egal à",
                "empty": "Vide",
                "contains": "Contient",
                "not": "Différent de",
                "notEmpty": "Non vide",
                "without": "Sans"
              }
            },
            "add": "Ajouter une condition",
            "button": {
              "0": "Recherche avancée",
              "_": "Recherche avancée (%d)"
            },
            "clearAll": "Effacer tout",
            "condition": "Condition",
            "data": "Donnée",
            "deleteTitle": "Supprimer la règle de filtrage",
            "logicAnd": "Et",
            "logicOr": "Ou",
            "title": {
              "0": "Recherche avancée",
              "_": "Recherche avancée (%d)"
            },
            "value": "Valeur"
          },
          "searchPanes": {
            "clearMessage": "Effacer tout",
            "count": "{total}",
            "title": "Filtres actifs - %d",
            "collapse": {
              "0": "Volet de recherche",
              "_": "Volet de recherche (%d)"
            },
            "countFiltered": "{shown} ({total})",
            "emptyPanes": "Pas de volet de recherche",
            "loadMessage": "Chargement du volet de recherche..."
          },
          "buttons": {
            "copyKeys": "Appuyer sur ctrl ou u2318 + C pour copier les données du tableau dans votre presse-papier.",
            "collection": "Collection",
            "colvis": "Colonnes à afficher",
            "colvisRestore": "Rétablir visibilité",
            "copy": "Copier",
            "copySuccess": {
              "1": "1 ligne copiée dans le presse-papier",
              "_": "%ds lignes copiées dans le presse-papier"
            },
            "copyTitle": "Copier dans le presse-papier",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
              "-1": "Afficher toutes les lignes",
              "1": "Afficher 1 ligne",
              "_": "Afficher %d lignes"
            },
            "pdf": "PDF",
            "print": "Imprimer"
          },
          "decimal": ",",
          "info": "Affichage de _START_ à _END_ sur _TOTAL_ éléments",
          "infoEmpty": "Affichage de 0 à 0 sur 0 éléments",
          "infoFiltered": "(filtrés de _MAX_ éléments au total)",
          "infoThousands": ".",
          "search": "Rechercher:",
          "searchPlaceholder": "...",
          "thousands": ".",
          "datetime": {
            "previous": "précédent",
            "next": "suivant",
            "hours": "heures",
            "minutes": "minutes",
            "seconds": "secondes"
          }
        }
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

    $(function() {

      $('#forms').validate({

        rules: {
          libelle: {
            required: true
          },
          description: {
            required: false
          },
        },
        messages: {
          libelle: {
            required: "Le libellé de l'emplacement est requis !",
          },
          description: {
            required: "La description de l'emplacement est requise !",
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');

        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>

</html>

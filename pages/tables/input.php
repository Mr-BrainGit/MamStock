<?php
include '../../class/Commande.php';
include '../../class/Produit.php';
include '../../class/Categorie.php';
include '../../class/Helper.php';
include '../../class/Achat.php';
include '../../class/User.php';
include '../../class/Fournisseur.php';
include '../../class/Dashboard.php';

User::forcedConnexion("login.php");
$commandes = [];
$commandes = Commande::getAll();

$categories = [];
$categories = Categorie::getAll();

$produits = [];
$produits = Produit::getAll();

$fournisseurs = [];
$fournisseurs = Fournisseur::getAll();

setlocale(LC_TIME, 'fr_FR.utf8', 'fra');


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
        <?php foreach ($produits as $p) : ?>
          <?php if (Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay']) > $p['stockActuelProduit']) : ?>
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
            <span class="dropdown-item dropdown-header"><?php echo $nb; ?> alerte<?php if ($nb > 1) {
                                                                                    echo 's';
                                                                                  } ?> de stock</span>
            <div class="dropdown-divider"></div>

            <?php foreach ($produits as $p) : ?>
              <?php $nb++;
              if (Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay']) > $p['stockActuelProduit']) : ?>
                <a href="#" class="dropdown-item">
                  <i class="fas fa-envelope mr-2"></i> Le produit <?php echo Helper::getProduitName($p['idProduit']); ?><br><i class="fas fa-enlvelope mr-4"></i> a ateint son stock d'alerte <?php echo Dashboard::getStockAlerte($p['idProduit'], $p['securityDelay']) ?>
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
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo $_SESSION['MM_Image']; ?>" class="elevation-2" alt="User Image">
          </div>
          <div class="info">
            <?= $_SESSION['MM_Username']; ?>
          </div>
        </div>
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
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
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
              <a href="stocks.php" class="nav-link active">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                  Stock
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="input.php" class="nav-link active">
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
              <a href="configuration.php" class="nav-link">
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
                  <a href="locations.php" class="nav-link">
                    <i class="far fas fa-map-marker-alt nav-icon"></i>
                    <p>Emplacements</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="users.php" class="nav-link">
                    <i class="far fa-user-circle nav-icon"></i>
                    <p>Utilisateur</p>
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
              <h1>Approvisionnements</h1>
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
                    <button type="button" class="btn btn-info" id="add" data-type="ajout" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus"></i> Ajouter</button>
                  </div>
                  <table id="example1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Date de commande</th>
                        <th>Date d'arrivée</th>
                        <th>Fournisseur</th>
                        <th>Notes</th>
                        <th>Etat</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($commandes as $commande) : ?>
                        <tr>
                          <td style="padding-top:17px;"><?php echo (strftime("%A %d %B %G", strtotime($commande['dateCommande']))) ?></td>
                          <td style="padding-top:17px;"><?php
                                                        if ($commande['dateArrivee'] == NULL) {
                                                          echo "<span class='badge badge-info'>En commande</span>";
                                                        } else {
                                                          echo strftime("%A %d %B %G", strtotime($commande['dateArrivee']));
                                                        } ?></td>
                          <td style="padding-top:17px;"><?php echo Helper::getFournisseurName($commande['idFournisseur']) ?></td>
                          <td style="padding-top:17px;"><?php
                                                        if ($commande['commentaire'] == NULL) {
                                                          echo "Pas de note";
                                                        } else {
                                                          echo $commande['commentaire'];
                                                        } ?></td>
                          <?php if ($commande['etatCommande'] == 0) : ?>
                            <td style="padding-top:13px;"><span class="badge badge-danger">Non Validé</span>

                            </td>

                          <?php endif ?>
                          <?php if ($commande['etatCommande'] == 1) : ?>
                            <td style="padding-top:13px;"><span class="badge badge-success">Validé</span></td>
                          <?php endif ?>

                          <td>
                            <?php if ($commande['etatCommande'] == 0) : ?>
                              <button type="button" id="edit" data-idcommande="<?php echo $commande['idCommande'] ?>" data-toggle="modal" data-idcommande="<?php echo $commande['idCommande'] ?>" data-target="#modal-lg3" class="btn btn-success btn-sm"><i class="fa fa-check-circle"> </i> Valider
                              </button>
                            <?php endif ?>
                            <?php if ($commande['etatCommande'] == 1) : ?>
                              <button type="button" id="edit" data-toggle="modal" data-idcommande="<?php echo $commande['idCommande'] ?>" data-target="#modal-lg2" class="btn btn-success btn-sm"><i class="fa fa-info-circle"> </i> Details
                              </button>
                            <?php endif ?>
                            <?php if ($commande['etatCommande'] == 0) : ?>
                              <a type="button" href="printBonDeCommande.php?id=<?php echo $commande['idCommande']; ?>" id="edit" class="btn btn-success btn-sm"><i class="fa fa-print"> </i>
                              </a>
                            <?php endif ?>
                            <?php if ($commande['etatCommande'] == 0) : ?>
                              <button type="button" data-idcomm="<?php echo $commande['idCommande'] ?>" data-toggle="modal" data-target="#confirm-modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            <?php endif ?>


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

  <div class="modal fade" id="modal-lg2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container" style="width:70%; margin: auto; ">
          <br>
          <div class="resultat">

          </div>
        </div>

      </div>


    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="modal-lg3">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container" style="width:70%; margin: auto; ">
          <br>
          <div class="resultat2">

          </div>
        </div>

      </div>


    </div>
    <!-- /.modal-dialog -->
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
      <div class="modal-content" id="initAppro">
        <div class="modal-header">
          <h4 class="modal-title">Faire un approvisionnement</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="approForm" method="post" class="approform">
            <div class="container modal-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="hidden" name="idAppro" id="idAppro">
                  <label for="dateAppro">Date de l'approvisionnement</label>
                  <?php
                  date_default_timezone_set("Africa/Abidjan");
                  $date = date("Y-m-d", time());
                  ?>
                  <input type="date" class="form-control" name="dateAppro" id="dateAppro" value="<?= $date ?>" max="<?= $date ?>">
                </div>
                <div class="form-group col-md-6">
                  <label for="categorieProduit">Fournisseur</label>
                  <select id="idFournisseur" name="idFournisseur" class="form-control" required>
                    <option value="" disabled selected hidden>Choisissez</option>
                    <?php foreach ($fournisseurs as $fournisseur) : ?>
                      <option value="<?php echo $fournisseur['idFournisseur'] ?>" name="idFournisseur"> <?php echo $fournisseur['nomFournisseur'] . ' ' . $fournisseur['prenomFournisseur'] ?> </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="libelleProduit">Description <span class="text-muted">(Optionnelle)</span> </label>
                  <textarea rows="5" type="text" class="form-control" id="description" name="description" placeholder="Libelle"></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
              <input type="submit" value="Enregistrer" class="btn btn-info">
            </div>
          </form>
        </div>

      </div>

      <div class="modal-content" id="selectProduct">
        <div class="modal-header">
          <h4 class="modal-title">Selectionnez les produits</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="prodForm">
          <div class="container modal-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="categorieProduit">Produit</label>
                <select select class="form-control my-select" id="codeProduit" data-live-search="true">
                  <?php foreach ($produits as $produit) : ?>
                    <option data-subtext="<?php echo Helper::getCategorieName($produit['idCategorie']) ?>" value="<?php echo $produit['idProduit'] ?>"> <?php echo $produit['libelleProduit'] ?> </option>
                  <?php endforeach ?>
                </select>
                <input type="hidden" id="commandCode">
              </div>


              <div class="form-group col-md-5">
                <label for="categorieProduit">Quantité</label>
                <input type="number" class="form-control" id="qte" min=1 value=1>
              </div>


              <div class="form-group col-md-1">
                <label style="visibility: hidden">.</label>
                <button type="submit" form="prodForm" class="form-control btn btn-info" id=""><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>

          <div class="container" id="tableDesProduits">

          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="button" id="saveAll" class="btn btn-info">Enregistrer</button>
          </div>
        </form>
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
          <input type="hidden" id="idComm" name="idComm">
          <div class="modal-body">
            <p>Voulez-vous vraiment supprimer cet approvisionnement ?</p>
            <p><b>NB: La suppression de la commande supprimera également les produits qui y sont liés.
                Si la commande n'a pas été validée au préalable, aucunne modification ne sera faite en stock !</b>
            </p>
          </div>
          <div class="modal-footer">
            <button type="submit" name="delete" class="btn btn-danger">Oui</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <div class="result">

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
  <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="../../plugins/dist/bootstrap-select//bootstrap-select.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript" src="../../Js/Alert.js"></script>




  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
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

    var text = 'Produit ajouté avec success!';

    function alerter() {
      Swal.fire({
        title: text,
        text: '',
        icon: 'success',
        confirmButtonText: 'OK'
      })
    }

    /**Script pour faire apparaitre le formulaire d'initialisation
    et cacher celui de la selection des produit */
    $('#add').click(function() {
      $('#initAppro').show();
      $('#selectProduct').hide();
      $('.my-select').selectpicker();
    })



    $('.approform').submit(function() {

      var date = $('#dateAppro').val();
      var fournisseur = $('#idFournisseur').val();
      var description = $('#description').val();
      if (date == '' || fournisseur == '') {
        alerterErreur();
      } else {
        $.post('addCommande.php', {
          dateAppro: date,
          idFournisseur: fournisseur,
          commentaire: description
        }, function(data) {
          $('#commandCode').val(data)
        })

        $('#initAppro').hide();
        $('#selectProduct').show();

      }
      return false;
    });

    /**Script de la logique permettant dafficher de facon dynamique les
    produit liés a un approvisionnement spécifique */
    $('#prodForm').submit(function() {
      var codeProduit = $('#codeProduit').val();
      var quantite = $('#qte').val();
      var codeCommande = $('#commandCode').val();

      $.post('checkMaxQuantity.php', {
        codeProduit: codeProduit,
        quantite: quantite,
        codeCommande: codeCommande
      }, function(data) {
        if (data == 1) {
          alerterQte();
        } else {

          $.post('addProducts.php', {
            codeProduit: codeProduit,
            quantite: quantite,
            codeCommande: codeCommande
          }, function(data) {

            getProduct();
            // var codeProduit = $('#codeProduit').val('');
            var quantite = $('#qte').val('1');

          })
          return false;

        }

      })
      return false;
    });


    var texte = 'Quantité supérieure au stock maximum !';

    function alerterQte() {
      Swal.fire({
        title: texte,
        text: '',
        icon: 'error',
        confirmButtonText: 'OK'
      })
    }

    function del2(datas) {
      alert(datas);
      var id = datas
      $.post('delProducts.php', {
        idProduit: id
      }, function(data) {

      })

    }

    function del(data) {

      $.post('delProducts.php', {
        idProd: data
      }, function(data) {

      })
      setTimeout(() => {
        getProduct();
      }, 100);

    }



    /**Methode ajax permettant de recuperer les donner
    et les afficher sans rafraichir la page */
    function getProduct() {
      var codeProduit = $('#codeProduit').val();
      var quantite = $('#qte').val();
      var codeCommande = $('#commandCode').val();
      $.post('getProducts.php', {
        codeProduit: codeProduit,
        quantite: quantite,
        codeCommande: codeCommande
      }, function(data) {
        $('#tableDesProduits').html(data);
      })
    }


    function getCommandeProduct() {
      var codeCommande = $('#commandCode').val();
      $.post('saveAll.php', {
        codeCommande: codeCommande
      }, function(data) {
        $('.result').html(data);
        alerterSuccess();
      })

    }

    function getCommandeProduct2(datas) {
      var codeCommande = datas;

      $.post('getCommandeProducts2.php', {
        idCommande: codeCommande
      }, function(data) {
        $('.resultat2').html(data);

      })
    }



    $('#saveAll').click(function() {
      var codeCommande = $('#commandCode').val();
      $.post('saveAll.php', {
        codeCommande: codeCommande
      }, function(data) {
        $('.result').html(data);
        alerterSuccess();
      })

    })

    var text = 'Approvisionnement validé !';

    function alerterSuccess() {
      Swal.fire({
        title: text,
        text: '',
        icon: 'success',
        confirmButtonText: 'OK'
      })
    }


    function alerterErreur() {
      var text = 'Veuillez remplir tous les champs requis SVP !';
      Swal.fire({
        title: text,
        text: '',
        icon: 'error',
        confirmButtonText: 'OK'
      })
    }



    $('#confirm-modal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('idcomm');
      $('.modal-title').text('Confirmation');
      $('#idComm').val(id);
    })

    $('#confirm-modal2').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('idcommande');

      $('#idComm2').val(id);
    })

    $('#modal-lg2').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('idcommande');
      $.post('getCommandeProducts.php', {
        idCommande: id
      }, function(data) {
        $('.resultat').html(data);

      })

    })

    $('#modal-lg3').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('idcommande');
      $.post('getCommandeProducts2.php', {
        idCommande: id
      }, function(data) {
        $('.resultat2').html(data);

      })

    })
  </script>

  <?php if (isset($_POST['delete'])) : ?>
    <?php
    $idComm = $_POST['idComm'];

    Commande::delete($idComm);

    echo "<meta http-equiv='refresh' content='1'>";
    ?>
    <script>
      var text = 'Produit supprimé avec success!';

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

  <?php if (isset($_POST['upgrade'])) : ?>


    <?php
    $idComm = $_POST['idComm2'];

    for ($i = 0; $i < count($_POST['values']['id']); $i++) {
      Achat::updateQte($idComm, $_POST['values']['id'][$i], $_POST['values']['qteFinale'][$i]);
    }

    $listProduit = Achat::getAllByCommandeId($idComm);


    foreach ($listProduit as $produit) {
      $id = $produit['idProduit'];
      $qte = $produit['quantite'];
      Produit::updateQte($qte, $id);
    }

    Commande::setEtat($idComm, 1);

    $dateArrivee = date("Y-m-d", time());
    Commande::setDateArrivee($idComm, $dateArrivee);

    echo "<meta http-equiv='refresh' content='1'>";

    ?>
    <script>
      var text = 'Mise à jour du stock effectuée !';

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

  </script>
</body>

</html>

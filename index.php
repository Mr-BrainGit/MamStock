<?php
ini_set('display_errors','on');
error_reporting(E_ALL);

include 'class/User.php';
include 'class/Dashboard.php';
include 'class/Helper.php';
include 'class/Produit.php';

User::forcedConnexion("pages/tables/login.php");

if (User::isConnected()) {
}

Dashboard::getTop5Products();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MamStock</title>
  <link rel="icon" type="image/png" href="dist/img/logo.ico" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/Mam_style.css">
  <!--<script type="text/javascript">
    if (this.name != 'fullscreen') {
      window.open(location.href, 'fullscreen', 'fullscreen,scrollbars')
    }
  </script>-->
  <script src="plugins/chart.js/Chart.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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
            <a class="nav-link" href="pages/tables/logout.php" role="button">
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
      <a href="index.php" class="brand-link" style="background-color: white;">
        <img src="dist/img/logo.ico" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text">Mam</span><span class="brand-text" id="target"></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <a href="pages/tables/users.php">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src=<?php
                        $image = $_SESSION['MM_Image'];
                        $image = substr($image, 6);
                        echo $image;
                        ?> class="elevation-2" alt="User Image">
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
              <a href="index.php" class="nav-link active">
                <i class="nav-icon fas fa-chart-line"></i>
                <!-- tachometer-alt -->
                <p>
                  Tableau de bord
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/tables/products.php" class="nav-link">
                <i class="nav-icon fas fa-box-open"></i>
                <p>
                  Produits
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/tables/stocks.php" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                  Stock
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/tables/input.php" class="nav-link">
                    <i class="far fas fa-cart-arrow-down nav-icon"></i>
                    <p>Entrées</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/output.php" class="nav-link">
                    <i class="far fas fa-dolly nav-icon"></i>
                    <p>Sorties</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/productsSellByDate.php" class="nav-link">
                    <i class="far fas fa-dolly nav-icon"></i>
                    <p>Etat des sorties</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/inventaire.php" class="nav-link">
                    <i class="far fas fa-retweet nav-icon"></i>
                    <p>Inventaires</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="pages/tables/provider.php" class="nav-link">
                <i class="nav-icon fas fa-truck-moving"></i>
                <p>
                  Fournisseurs
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/tables/customers.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Clients
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/tables/configuration.php" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Configuration
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/tables/categories.php" class="nav-link">
                    <i class="far fas fa-cubes nav-icon"></i>
                    <p>Catégories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/locations.php" class="nav-link">
                    <i class="far fas fa-map-marker-alt nav-icon"></i>
                    <p>Emplacements</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/tables/users.php" class="nav-link">
                    <i class="far fa-user-circle nav-icon"></i>
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Tableau de bord</h1>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-boxes"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Nombre de produit</span>
                  <span class="info-box-number">
                    <?php echo Dashboard::getProductsNumber(); ?>

                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-dollar-sign"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Valeur du stock</span>
                  <span class="info-box-number"><?php echo number_format(Dashboard::getStockVal(), 0, NULL, " ") ?> F CFA</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cart-plus"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Commandes en attente</span>
                  <span class="info-box-number"><?php echo Dashboard::getCommendeEnAttente(); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Factures en attente</span>
                  <span class="info-box-number"><?php echo Dashboard::getFactureEnAttente(); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Catégories</span>
                  <span class="info-box-number">
                    <?php echo Dashboard::getAllCategorie(); ?>

                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-medical"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Fournisseurs</span>
                  <span class="info-box-number"><?php echo Dashboard::getAllProviders() ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Clients</span>
                  <span class="info-box-number"><?php echo Dashboard::getAllCustumers(); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Utilisateurs</span>
                  <span class="info-box-number"><?php echo Dashboard::getAllUsers(); ?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <?php

            $products = Dashboard::getTop5Products();

            $number = count($products);

            switch ($number) {
              case 1:
                $product1 = Helper::getProduitName($products[0]['idProduit']);
                $qte1 = $products[0]['qte'];
                break;
              case 2:
                $product1 = Helper::getProduitName($products[0]['idProduit']);
                $product2 = Helper::getProduitName($products[1]['idProduit']);
                $qte1 = $products[0]['qte'];
                $qte2 = $products[1]['qte'];
                break;
              case 3:
                $product1 = Helper::getProduitName($products[0]['idProduit']);
                $product2 = Helper::getProduitName($products[1]['idProduit']);
                $product3 = Helper::getProduitName($products[2]['idProduit']);
                $qte1 = $products[0]['qte'];
                $qte2 = $products[1]['qte'];
                $qte3 = $products[2]['qte'];
                break;
              case 4:
                $product1 = Helper::getProduitName($products[0]['idProduit']);
                $product2 = Helper::getProduitName($products[1]['idProduit']);
                $product3 = Helper::getProduitName($products[2]['idProduit']);
                $product4 = Helper::getProduitName($products[3]['idProduit']);
                $qte1 = $products[0]['qte'];
                $qte2 = $products[1]['qte'];
                $qte3 = $products[2]['qte'];
                $qte4 = $products[3]['qte'];
                break;
              case 5:
                $product1 = Helper::getProduitName($products[0]['idProduit']);
                $product2 = Helper::getProduitName($products[1]['idProduit']);
                $product3 = Helper::getProduitName($products[2]['idProduit']);
                $product4 = Helper::getProduitName($products[3]['idProduit']);
                $product5 = Helper::getProduitName($products[4]['idProduit']);
                $qte1 = $products[0]['qte'];
                $qte2 = $products[1]['qte'];
                $qte3 = $products[2]['qte'];
                $qte4 = $products[3]['qte'];
                $qte5 = $products[4]['qte'];
                break;

              default:
                # code...
                break;
            }


          ?>

        <?php

          $factures = Dashboard::getAffluenceVente();
          $Today = 0;$Day1 = 0;$Day2 = 0;$Day3 = 0;$Day4 = 0;$Day5 = 0;$Day6 = 0;
          $Today_benef = 0;$Day1_benef = 0;$Day2_benef = 0;$Day3_benef = 0;$Day4_benef = 0;$Day5_benef = 0;$Day6_benef = 0;
          foreach ($factures as $facture) {
              $datetime2 = date_create(date("Y-m-d"));
              $d = $facture['dateFacture'];
              $date = date_create($d);
              $diff = date_diff($datetime2,$date);
              $interval = $diff->format('%D');

              if ($interval<=7) {
                switch ($interval) {
                  case 0:
                    $Today += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                     $prod = Produit::findById($factProduct['idProduit']);
                     $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                     $Today_benef = $Today_benef + $benef;
                    }


                    break;
                  case 1:
                    $Day6 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day6_benef = $Day6_benef + $benef;
                    }

                    break;
                  case 2:
                    $Day5 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day5_benef = $Day5_benef + $benef;
                    }
                    break;
                  case 3:
                    $Day4 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day4_benef = $Day4_benef + $benef;
                    }
                    break;

                  case 4:
                    $Day3 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day3_benef = $Day3_benef + $benef;
                    }

                    break;
                  case 5:
                    $Day2 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day2_benef = $Day2_benef + $benef;
                    }
                    break;
                  case 6:
                    $Day1 += 1;
                    $factProducts = Helper::getFactureProducts($facture['idFacture']);
                    foreach ($factProducts as $factProduct) {
                      $prod = Produit::findById($factProduct['idProduit']);
                      $benef = ($prod['prixUnit'] - $prod['prixAchat'])*$factProduct['quantite'];
                      $Day1_benef = $Day1_benef + $benef;
                    }
                    break;
                  default:
                    # code...
                    break;
                }
              }

          }

        ?>


        <div class="container-fluid" style="width: 100%; margin: auto; border:10px solid transparent;">
            <div class="row">
              <div class="col-md-6">
                <div class="container" style="border-left: 5px solid green; width:98%; padding:12px; background-color: white;
                      -webkit-box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);
                      -moz-box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);
                      box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);">
                      <div class="libele" style="text-align: center;">
                        <h6 style="color: black;">TOP 5 des produits les plus vendus</h6>
                      </div>
                    <canvas id="myChart" width="200" height="100"></canvas>
                    <script>
                      var ctx = document.getElementById('myChart').getContext('2d');
                      var myChart = new Chart(ctx, {
                          type: 'pie',
                          data: {
                              labels:
                              [
                                <?php if (isset($product1)) {
                                  echo "'". $product1. "'";
                                }?>
                                <?php if (isset($product2)) {
                                  echo ",'". $product2. "'";
                                }?>
                                <?php if (isset($product3)) {
                                  echo ",'". $product3. "'";
                                }?>
                                <?php if (isset($product4)) {
                                  echo ",'". $product4. "'";
                                }?>
                                <?php if (isset($product5)) {
                                  echo ",'". $product5. "'";
                                }?>],
                              datasets: [{
                                  label: 'Teste',
                                  data:
                                  [
                                    <?php if (isset($qte1)) {
                                      echo $qte1;
                                    }?>
                                    <?php if (isset($qte2)) {
                                      echo ",". $qte2;
                                    }?>
                                    <?php if (isset($qte3)) {
                                      echo ",". $qte3;
                                    }?>
                                    <?php if (isset($qte4)) {
                                      echo ",". $qte4;
                                    }?>
                                    <?php if (isset($qte5)) {
                                      echo ",". $qte5;
                                    }?>],
                                  backgroundColor: [
                                      'rgba(255, 99, 132, 0.5)',
                                      'rgba(54, 162, 235, 0.5)',
                                      'rgba(255, 206, 86, 0.5)',
                                      '#90EE90',
                                      'rgba(153, 102, 255, 0.5)',
                                      'rgba(255, 159, 64, 0.5)'
                                  ],
                                  borderColor: [
                                      'rgba(255, 99, 132, 1)',
                                      'rgba(54, 162, 235, 1)',
                                      'rgba(255, 206, 86, 1)',
                                      '#90EE90',
                                      'rgba(153, 102, 255, 1)',
                                      'rgba(255, 159, 64, 1)'
                                  ],
                                  borderWidth: 2
                              }]
                          },
                          options: {

                              legend: {
                              display: true,
                              position: 'right',
                              labels: {
                                  fontColor: 'rgb(255, 99, 132)'
                              }
                          }

                          }
                      });
                    </script>
                </div>
              </div>

              <div class="col-md-6">

                  <div class="container" style="border-left: 5px solid green; width:98%; padding:12px; background-color: white;
                      -webkit-box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);
                      -moz-box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);
                      box-shadow: 4px 11px 34px -17px rgba(122,122,122,0.42);">
                      <div class="libele" style="text-align: center;">
                        <h6 style="color: black;">Statistiques sur les ventes</h6>
                      </div>
                      <canvas id="venteJour" width= "50%"></canvas>
                      <script>
                          var ctx = document.getElementById('venteJour').getContext('2d');
                          var myChart = new Chart(ctx, {
                              type: 'line',
                              data: {
                                  labels: ['Il ya 6 jours', 'Il ya 5 jours', 'Il ya 4 jours','Il ya 3 jours', 'Avant-hier', 'Hier','Aujourd\'hui'],
                                  datasets: [
                                  {
                                      label: 'Affluence des ventes',
                                      data: [<?php echo $Day1;?>, <?php echo $Day2;?>, <?php echo $Day3;?>, <?php echo $Day4;?>, <?php echo $Day5;?>, <?php echo $Day6;?>, <?php echo $Today;?> ],
                                      backgroundColor: [
                                          'rgba(255, 99, 132, 0.3)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)'
                                        ],
                                        borderWidth: 2

                                  },
                                  {
                                      label: 'Bénéfices',
                                      data: [<?php echo $Day1_benef;?>, <?php echo $Day2_benef;?>, <?php echo $Day3_benef;?>, <?php echo $Day4_benef;?>, <?php echo $Day5_benef;?>, <?php echo $Day6_benef;?>, <?php echo $Today_benef;?> ],
                                      backgroundColor: [
                                          'rgba(55, 176, 48, 0.3)'
                                        ],
                                        borderColor: [
                                            'rgba(55, 176, 48, 1)'
                                        ],
                                        borderWidth: 2

                                  },
                                  ]

                              },
                              options: {
                                  scales: {
                                      yAxes: [{
                                          ticks: {
                                              beginAtZero: true
                                          }
                                      }]
                                  }
                              }
                          });
                      </script>
                  </div>
              </div>
            </div>
        </div>
          <!-- /.row -->
        </div>
        <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2020-2021 MamStock-Miage2/IBAM</strong>
      Tous droits reservés
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.0.1
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <script src="plugins/bootstrap/js/Mam_script.js"></script>

  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>

  <!-- ChartJS -->



  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>


</body>

</html>

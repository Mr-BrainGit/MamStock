<?php
include '../../class/User.php';
$users = [];
$users = User::getAllUsers();

if (User::isConnected()) {
  header('Location: ../../index.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connnexion | MamStock</title>
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

<body class="hold-transition login-page" style="background-image: url(../../dist/img/fond.jpg);">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-info sidebar-light-info elevation-4">
      <div>
        <a href="../../index.php" class="brand-link" style="background-color: white;">
          <img src="../../dist/img/logo.ico" alt="Mamstock Logo" class="img-circle" width="100" style="margin-left: 34px">
          <span class="brand-text" style="font-size: 30px;margin-left: -15px">Mam</span><span class="brand-text" id="target" style="font-size: 30px;"></span>
        </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg" style="font-size: 25px;">Connexion</p>

        <form action="" method="post" id="quickForm">
          <div class="input-group mb-3 form-group">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="username" required>
          </div>
          <div class="input-group mb-3 form-group">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
          </div>
          <div class="row">
            <div class="col-6">
              <a href="registrer.php"><button type="button" class="btn btn-info btn-block">S'inscrire</button></a>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <button type="submit" class="btn btn-success btn-block" name="submit">Se connecter</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript" src="../../Js/Alert.js"></script>

  <?php if (isset($_POST['submit'])) : ?>

    <?php

    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($users = (User::loadConnexion($users, $username, $password))) {
      $role = $users['role'];
      $image = $users['image'];
      if ($role == 1) {
        $role = 'Administrateur';
      } else {
        $role = 'Employé';
      }
      User::connexionSuccess("../../index.php", $role, $image);
    }
    echo "<meta http-equiv='refresh' content='1  ; url= http://localhost/MamStock/pages/tables/login.php'>";
    ?>
    <script>
      var text = 'Accès non autorisé !';

      function alerter() {
        Swal.fire({
          title: text,
          text: '',
          icon: 'error',
          confirmButtonText: 'Rééssayer'
        })
      }
      alerter();
    </script>

  <?php endif ?>

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/bootstrap/js/Mam_script.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <script>
    $(function() {
      $.validator.setDefaults({});
      $('#quickForm').validate({
        rules: {
          username: {
            required: true,
          },
          password: {
            required: true,
            minlength: 5
          },
        },
        messages: {
          username: {
            required: "Le nom de l'utilisateur est requis !",
          },
          password: {
            required: "Le mot de passe est requis !",
            minlength: "Le mot de passe doit dépasser 5 caractères"
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

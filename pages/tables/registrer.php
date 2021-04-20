<?php
include '../../class/User.php';


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription | MamStock</title>
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
</head>

<body class="hold-transition register-page" style="background-image: url(../../dist/img/fond.jpg);">
  <div class="register-box">
    <div class="card card-outline card-info sidebar-light-info elevation-4">
      <div>
        <a href="../../index.php" class="brand-link" style="background-color: white;">
          <img src="../../dist/img/logo.ico" alt="Mamstock Logo" class="img-circle" width="100" style="margin-left: 34px">
          <span class="brand-text" style="font-size: 30px;margin-left: -15px">Mam</span><span class="brand-text" id="target" style="font-size: 30px;"></span>
        </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg" style="font-size: 25px;">Inscription</p>

        <form action="" method="post" id="quickForm" enctype="multipart/form-data">
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
          <div class="input-group mb-3 form-group">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
            <select name="role" id="role" class="form-control" required>
              <option value="" selected>Rôle de l'utilisateur </option>
              <option value="1">Administrateur</option>
              <option value="0">Employé</option>
            </select>
          </div>
          <div class="input-group mb-3 form-group">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-mobile"></span>
              </div>
            </div>
            <input type="tel" class="form-control" placeholder="Numéro de téléphone" name="phone" required>
          </div>
          <div class="input-group mb-3 form-group">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-image"></span>
              </div>
            </div>
            <input type="file" class="form-control" name="image" id="image">
          </div>
          <div class="row">
            <div class="col-6">
              <a href="../../index.php"><button type="button" class="btn btn-info btn-block">Dashboard</button></a>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <button type="submit" class="btn btn-success btn-block" name='submit'>S'inscrire</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script type="text/javascript" src="../../Js/Alert.js"></script>

  <?php if (isset($_POST['submit'])) : ?>

    <?php
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $phone = str_replace(" ", "", "$phone");

    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];
    $directory = "../../dist/img/";
    $image = User::modifyImageDirectory($fileName, $fileTmp, $directory , $phone);
    move_uploaded_file($fileTmp, $image);

    $user = new User($username, $password, $role, $phone, $image);
    User::createNewUser($user);

    echo "<meta http-equiv='refresh' content='2  ; url= http://localhost/MamStock/pages/tables/users.php'>";
    ?>
    <script>
      var text = 'Utilisateur ajouté avec succès !';

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
          role: {
            required: true,
          },
          phone: {
            required: true,
            minlength: 8
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
          role: {
            required: "Le role de l'utilisateur est requis !",
          },
          phone: {
            required: "Numéro de téléphone requis !",
            minlength: "Le numéro doit atteindre au moins 8 caractères"
          },
          password: {
            required: "Le mot de passe est requis !",
            minlength: "Le mot de passe doit atteindre au moins 5 caractères"
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

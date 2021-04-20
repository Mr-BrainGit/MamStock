<?php
session_start();
unset($_SESSION['connecte']);
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_Image']);
header('Location: login.php');
exit;

<?php
include '../../class/Dashboard.php';

include '../../class/db-connect.php';

$idProduit = $_POST['idProduit'];
$securityDelay = $_POST['securitydelay'];

echo Dashboard::getStocMin($idProduit, $securityDelay);



?>

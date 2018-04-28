<?php
session_start();
include("./function.php");
$con=connect();
//$query="UPDATE rilievo SET CF_SUPERUSER='".$_POST['CF']."' WHERE LONGITUDINE='".$_POST['LONGITUDINE']."' AND LATITUDINE='".$_POST['LATITUDINE']."'";
$query="UPDATE rilievo SET CF_SUPERUSER='DPNNTN92C05I805H' WHERE LONGITUDINE='14.7584533246552' AND LATITUDINE='40.7798599154694'";

$ris=run_query($query,$con);

$er=array();

$er['ERROR']='none';

echo json_encode($er);
close_connection($ris,$con);
?>
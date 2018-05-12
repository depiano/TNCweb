<?php
session_start();
include("./function.php");
$con=connect();
$query="UPDATE rilievo SET CF_SUPERUSER='".$_POST['CF']."',STATO='NON VALIDATO' WHERE LONGITUDINE='".$_POST['LONGITUDINE']."' AND LATITUDINE='".$_POST['LATITUDINE']."'";

$ris=run_query($query,$con);

$er=array();

$er['ERROR']='none';

echo json_encode($er);
close_connection($ris,$con);
?>
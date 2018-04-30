<?php
session_start();
include("./function.php");
$con=connect();
$passwordmd5=md5($_POST['PASSWORD']);
$query="UPDATE super_user SET PASSWORD='".$passwordmd5."',PHONE='".$_POST['PHONE']."' WHERE CF='".$_POST['CF']."'";

$ris=run_query($query,$con);

$er=array();

$er['ERROR']='none';

echo json_encode($er);
close_connection($ris,$con);
?>
<?php
include("./function.php");
$con=connect();
$query="select * from amministratore where email='".$_POST['email']."' AND password='".$_POST['password']."'";
$content='';
$error='';
$ris=run_query($query,$con);

$er=array();

if(mysql_num_rows($ris)>0)
{
	$r=mysql_fetch_array($ris);
	$er['fullname']=$r['Fullname'];
	$er['email']=$r['Email'];
	$er['error']='none';
}
else
	$er['error']='Riprova. Credenziali invalide!';
echo json_encode($er);
close_connection($ris,$con);
?>
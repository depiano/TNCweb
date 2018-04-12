<?php
session_start();
include("function.php");
$con=connect();
$query="select * from amministratore where email='".$_POST['email']."' AND password='".$_POST['password']."'";
$ris=run_query($query,$con);

$er=array();

if(mysql_num_rows($ris)>0)
{
	$r=mysql_fetch_array($ris);
    $er['fullname']=$r['Fullname'];
    $er['email']=$r['Email'];
    $er['error']='none';
	$_SESSION['Fullname']=$er['result'];
	$_SESSION['Email']=$r['Email'];
	//header('Location: ../pages/index.html');
}
else
	$er['error']='Riprova. Credenziali errate!';
echo json_encode($er);
close_connection($ris,$con);
?>
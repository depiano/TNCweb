<?php
/*
session_start();
include("function.php");
$con=connect();
$query="select * from amministratore where email='".$_POST['email']."' AND password='".$_POST['password']."'";
$content='';
$error='';
$ris=run_query($query,$con);

$er=array(
'result' => $content,
'error' => $error
);

if(mysql_num_rows($ris)>0)
{

	//echo "i dati ci sono\n";

	$r=mysql_fetch_array($ris);
		//echo "Risultato: ".$r."\n";
	//$fullname=(string)$r['Fullname'];
	//echo "Fullname: ".$fullname."\n";
	$er['result']=$r['Fullname'];
	$er['error']='none';
	$_SESSION['Fullname']=$er['result'];
	$_SESSION['Email']=$r['Email'];
	//header('Location: ../pages/index.html');
}
else
	$er['error']='yes';
echo json_encode($er);
close_connection($ris,$con);
*/
echo "ciaooo";
?>
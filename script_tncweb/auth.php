<?php
session_start();
include("./function.php");
$con=connect();
$query="select * from super_user where EMAIL='".$_POST['EMAIL']."' AND PASSWORD='".$_POST['PASSWORD']."'";
$ris=run_query($query,$con);

$er=array();
$auth_user = array();

if(mysql_num_rows($ris)>0)
{
	$r=mysql_fetch_array($ris);


    $auth_user['FULLNAME'] = $r['FULLNAME'];
    $auth_user['EMAIL'] = $r['EMAIL'];
    $auth_user['PHONE'] = $r['PHONE'];
    $auth_user['CF'] = $r['CF'];

    $er['RESULT']=$auth_user;
    $er['ERROR']='none';

	$_SESSION['CF']=$r['CF'];
	$_SESSION['FULLNAME']=$r['FULLNAME'];
	//header('Location: ../pages/index.html');
}
else
	$er['ERROR']='yes';
echo json_encode($er);
close_connection($ris,$con);
?>
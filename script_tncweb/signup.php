<?php
session_start();
include("./function.php");
$con=connect();
$query="select * from super_user where EMAIL='".$_POST['EMAIL']."' OR CF='".$_POST['CF']."'";
$ris=run_query($query,$con);

$er=array();

if(mysql_num_rows($ris)>0)
{    
    $er['ERROR']='yes';
}
else
{
    $er['ERROR']='none';
    $passwordmd5=md5($_POST['PASSWORD']);

    $query="INSERT INTO super_user(EMAIL,FULLNAME,PHONE,PASSWORD,CF) VALUES ('".$_POST['EMAIL']."','".$_POST['FULLNAME']."','".$_POST['PHONE']."','".$passwordmd5."','".$_POST['CF']."')";
   $ris=run_query($query,$con);
}
	
echo json_encode($er);
close_connection($ris,$con);
?>
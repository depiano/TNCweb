<?php
session_start();
include("./function.php");
$con=connect();
$query="select * from super_user where CF='".$_POST['CF']."'";
$ris=run_query($query,$con);

$er=array();

if(mysql_num_rows($ris)>0)
{
    $r=mysql_fetch_array($ris);

    $user_profile = array();
    $user_profile['FULLNAME'] = $r['FULLNAME'];
    $user_profile['EMAIL'] = $r['EMAIL'];
    $user_profile['PHONE'] = $r['PHONE'];
    $user_profile['CF'] = $r['CF'];

    $er['RESULT']=$user_profile;
    $er['ERROR']='none';
    //header('Location: ../pages/index.html');
}
else
    $er['ERROR']='yes';
echo json_encode($er);
close_connection($ris,$con);
?>
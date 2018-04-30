<?php
session_start();
include("./function.php");
$con=connect();
$passwordmd5=md5('antonio');

    $query="INSERT INTO super_user(EMAIL,FULLNAME,PHONE,PASSWORD,CF) VALUES ('depianoantonio@gmail.com','Antonio De Piano','3463316586','".$passwordmd5."','DPNNTN92C05I805H')";
   $ris=run_query($query,$con);
    $er['ERROR']='none';

echo json_encode($er);
close_connection($ris,$con);
?>
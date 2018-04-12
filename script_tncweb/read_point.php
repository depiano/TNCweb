<?php
session_start();
include("function.php");
$con=connect();
$query="select * from censimento";
$content='';
$error='none';
$ris=run_query($query,$con);

$er=array();

$censimenti=array();

if(mysql_num_rows($ris)>0)
{
    $er['error']='none';
    //header('Location: ../pages/index.html');

    while ($row = mysql_fetch_array($ris)) {
        $censimento = array();
        $censimento['Denominazione'] = $row['Denominazione'];
        $censimento['Latitudine'] = $row['Latitudine'];
        $censimento['Longitudine'] = $row['Longitudine'];
        $censimento['Civico'] = $row['Civico'];
        $censimento['Dug'] = $row['Dug'];
        $censimento['Esponente'] = $row['Esponente'];
        $censimento['PathFotoCivico'] = $row['PathFotoCivico'];
        $censimento['PathFotoAbitazione'] = $row['PathFotoAbitazione'];
        $censimento['EmailOperatore'] = $row['EmailOperatore'];
        $censimento['EmailAmministratore'] = $row['EmailAmministratore'];
        array_push($censimenti, $censimento);
    }
    $er['result']=$censimenti;

}
else
    $er['error']='Riprova. Credenziali errate!';
echo json_encode($er);
close_connection($ris,$con);
?>
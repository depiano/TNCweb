<?php
session_start();
include("function.php");
$con=connect();
$query="select * from rilievo where STATO='VALIDATO' OR STATO='IN ATTESA'";
$ris=run_query($query,$con);

$er=array();

$censimenti=array();

if(mysql_num_rows($ris)>0)
{
    $er['ERROR']='none';
    //header('Location: ../pages/index.html');

    while ($row = mysql_fetch_array($ris)) {
        $censimento = array();
        $censimento['DENOMINAZIONE'] = $row['DENOMINAZIONE'];
        $censimento['LATITUDINE'] = $row['LATITUDINE'];
        $censimento['LONGITUDINE'] = $row['LONGITUDINE'];
        $censimento['CIVICO'] = $row['CIVICO'];
        $censimento['DUG'] = $row['DUG'];
		$censimento['DATA'] = $row['DATA'];
        $censimento['ESPONENTE'] = $row['ESPONENTE'];
        $censimento['STATO']=$row['STATO'];
        $censimento['PATHFOTOCIVICO'] = $row['PATHFOTOCIVICO'];
        $censimento['PATHFOTOABITAZIONE'] = $row['PATHFOTOABITAZIONE'];
        $censimento['CF_USER'] = $row['CF_USER'];
        $censimento['CF_SUPERUSER'] = $row['CF_SUPERUSER'];
        array_push($censimenti, $censimento);
    }
    $er['RESULT']=$censimenti;

}
else
    $er['ERROR']='yes';
echo json_encode($er);
close_connection($ris,$con);
?>
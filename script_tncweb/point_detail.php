<?php
session_start();
include("function.php");
$con=connect();
$query="select * from rilievo where LATITUDINE=".$_POST['LATITUDINE']." AND LONGITUDINE=".$_POST['LONGITUDINE'];
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
        $censimento['PATHFOTOCIVICO'] = $row['PATHFOTOCIVICO'];
        $censimento['PATHFOTOABITAZIONE'] = $row['PATHFOTOABITAZIONE'];
        $censimento['CF_USER'] = $row['CF_USER'];
        $censimento['NOMECOMUNE'] = $row['NOMECOMUNE'];
        $censimento['CODISTAT'] = $row['CODISTAT'];
        $censimento['CF_SUPERUSER'] = $row['CF_SUPERUSER'];
        array_push($censimenti, $censimento);
    }
    $er['RESULT']=$censimenti;

}
else
    $er['ERROR']='yes';


$query="select * from user where CF='". $censimento['CF_USER']."'";
$ris=run_query($query,$con);
    
if(mysql_num_rows($ris)>0)
{
     $riss=mysql_fetch_array($ris);
    
    $user_profile = array();
    $user_profile['FULLNAME'] = $riss['FULLNAME'];
    $user_profile['EMAIL'] = $riss['EMAIL'];
    $user_profile['PHONE'] = $riss['PHONE'];
    $user_profile['TYPE'] = $riss['TYPE'];
    $user_profile['CF'] = $riss['CF'];
    
    $er['OPERATOR']=$user_profile;
        //header('Location: ../pages/index.html');
}
else
    $er['OPERATOR']='none';
echo json_encode($er);
close_connection($ris,$con);
?>
<?php
$host="localhost";
$db="tnc_db";
$us="admin";
$pas="";

function connect()
{
	global $us;
	global $pas;
	global $db;
	global $host;
	$con=@mysql_connect($host,$us,$pas) or die("Connessione fallita");
	@mysql_select_db($db,$con) or die("Impossibile selezionare il database");
	return $con;
}

function run_query($query,$con)
{
	$ris=@mysql_query($query,$con) or die("Query fallita");
	return $ris;
}

function close_connection($ris,$con)
{
	if(!is_bool($ris))
	{
		mysql_free_result($ris);
	}
	mysql_close($con);
}
?>

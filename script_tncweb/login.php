<?php
include("funzioni.php");
$con=connetti();
$query="select * from amministratore";
$ris=esegui_query($query,$con);
if(mysql_num_rows($ris)>0)
{

	echo "i dati ci sono\n";

	$r=mysql_fetch_array($ris);
		echo "Risultato: ".$r."\n";
	$fullname=(string)$r['Fullname'];
	echo "Fullname: ".$fullname."\n";
}
else
	echo "la query non restituisce dati";
chiudi_connessione($ris,$con);
?>

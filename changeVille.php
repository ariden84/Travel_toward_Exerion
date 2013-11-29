<?php

if($_POST['destination']=='' || $_POST['destination']=='Votre recherche'){
	header('Location: choixDates.php?k='.$_GET['k']);
}else{

$connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");

$UpdateSQL = 'UPDATE `Groupe` SET `Ville`="'.$_POST['destination'].'" WHERE `CleGroupe`="'.$_GET['k'].'"';

//$UpdateSQL = 'UPDATE `Groupe` SET `Ville`="Poki" WHERE `CleGroupe`="52976c2b5f5ac"';

//$UpdateSQL = "UPDATE `Groupe` SET `Ville`='Poki' WHERE `CleGroupe`=''";

//$UpdateSQL = 'UPDATE `Personne` SET `Vote`="1" WHERE `Pseudo`="ya"';
mysql_query ($UpdateSQL, $connectSQL);

mysql_close($connectSQL);

header('Location: api.php?k='.$_GET['k']);

}


?>
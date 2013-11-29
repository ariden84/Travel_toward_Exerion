<?php

/*$connectSQL = mysql_connect('fdb4.freehostingeu.com','1563171_gl','glproject2013') or die ("erreur de connexion");
mysql_select_db('1563171_gl',$connectSQL) or die ("erreur de connexion base");*/

$connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");
	
$UpdateSQL = 'UPDATE `Personne` SET `Vote`="'.$_GET['val'].'" WHERE `Pseudo`="'.$_GET['pseudo'].'"';
mysql_query ($UpdateSQL, $connectSQL);

mysql_close($connectSQL);

?>
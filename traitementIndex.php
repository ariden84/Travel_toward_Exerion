<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Go with Friends</title>
        <link rel="stylesheet" href="main_style.css" type="text/css">
	
<?php
// background-image: url("http://www.niffylux.com/image-gratuite/Neige__6_4d05573bb6a29.jpg");

if(!isset($_POST['nbPersonnes'])){
	header('Location: index.php'); 
}else{
	$nbPersonnes = $_POST['nbPersonnes'];
}

$personnes = array();
$flag = true;

for($i=1;$i<=$nbPersonnes;$i++){
	if($_POST['pseudo'.$i]!=''){
		$personnes[] = array("pseudo" => $_POST['pseudo'.$i], "email" => $_POST['email'.$i]);
	}else{
	
		//AVEC LE PREMIER SERVEUR
		header('Refresh: 3;url=index.php');
		
		//AVEC LE NOUVEAU SERVEUR
		//echo "<meta http-equiv='refresh' content='3;url=index.php'>";
		
		echo "</head>";
		echo "<body>Il manque au moins un pseudo (redirection en cours ...)</body>";
		$flag = false;
		break;
	}
}

//print_r($personnes);

//echo "<br/>";

if($flag){

	//echo "catched";

	$uniqid = uniqid();

	/*$connectSQL = mysql_connect('fdb4.freehostingeu.com','1563171_gl','glproject2013') or die ("erreur de connexion");
	mysql_select_db('1563171_gl',$connectSQL) or die ("erreur de connexion base");*/
	
	$connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
    mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");
	
	$InsertSQL = "INSERT INTO `Groupe`(`CleGroupe`, `NbPersonnes`) VALUES ('".$uniqid."','".$nbPersonnes."')";
	$objRS = mysql_query ($InsertSQL, $connectSQL);
	
	for($i=0;$i<$nbPersonnes;$i++){
	
		$InsertSQL = "INSERT INTO `Personne`(`Pseudo`, `Email`, `CleGroupe`) VALUES ('".$personnes[$i]['pseudo']."','".$personnes[$i]['email']."','".$uniqid."')";
		$objRS = mysql_query ($InsertSQL, $connectSQL);
		
	}

	mysql_close($connectSQL);
	
	echo "<body><p>Voici l'URL a envoyer a vos amis :</p>";
	echo "<a href='/choixDates.php?k=".$uniqid."'>Choose and share travel</a></body>";

}

?>

</html>
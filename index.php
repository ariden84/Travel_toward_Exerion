<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8" />
        <title>Go with Friends</title>
        <link rel="stylesheet" href="main_style.css" type="text/css">
    </head>

<?php 
//background-repeat: no-repeat;
//background-attachement: fixed;
//background-color:#ADADE8;
//background-image: url("http://www.niffylux.com/image-gratuite/Neige__6_4d05573bb6a29.jpg");
if(isset($_POST['nbPersonnes'])){

	//echo $_POST['nbPersonnes'].'catched !';
	$nbPersonnes = $_POST['nbPersonnes'];
	
	echo "<body>";
	
	echo "<form action='traitementIndex.php' method='post'>";
	
	echo "<input type='hidden' name='nbPersonnes' value=".$nbPersonnes."/>";
	
	echo "<br/>";
	echo "<br/>";
	
	echo "<p><h2>Veuillez entrer les informations sur vos amis :)</h2></p>";
	
	echo "<br/>";
	echo "<br/>";
	
	echo "<div>";
	
	echo "<table align='center'>";
	
		echo "<tr>";
			echo "<td>";
				echo "Pseudo";
			echo "</td>";
			echo "<td>";
				echo "Email (facultatif)";
			echo "</td>";
		echo "</tr>";
	
		for($i=1;$i<=$nbPersonnes;$i++){
			echo "<tr>";
				echo "<td>";
					echo "<input type='text' name='pseudo".$i."' style='height: 15px; width: 300px;' value=''/>";
				echo "</td>";
				echo "<td>";
					echo "<input type='text' name='email".$i."' style='height: 15px; width: 300px;' value=''/>";
				echo "</td>";
			echo "</tr>";
		}
	
	echo "</table>";
	
	echo "</div>";
	
	echo "<br/>";
	echo "<br/>";
	
	echo "<input type='submit' value='Valider'/>";
	
	echo "</form>";
	
	echo "</body>";

}else{

?>

    <body>
        
		<h2>Prepare and start a travel with your friends!</h2>
		
		<div>
			Combien de personnes prenderont part au voyage ?
		</div>
		
		<form action="index.php" method="post">
			
			<select name="nbPersonnes">
			
				<?php
					echo '<option value=2>2</option>';
					for($i=3;$i<10;$i++){
						echo '<option value='.$i.'>'.$i.'</option>';
					}
				?>
				
			</select>
		
			<input type='submit' value='Valider'/>
			
		</form>
		
		<br/>
		<br/>
		<br/>
		
		<IMG SRC="/images/Gyno.jpg" 
			ALT="Image manquante"
			TITLE="Pikachu vaincra !"
			width="500">
        
    </body>

<?php 

//SRC="http://postgradproblems.com/wp-content/uploads/2013/08/835bb25f8df8abb0f512d173baed5c0f.jpg"

}

echo "</html>";

?>
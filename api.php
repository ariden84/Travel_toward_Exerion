<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Choix Sejour</title>
    <!--header('Content-Type: application/json;charset=utf-8;');-->
    <style type="text/css">
        body {
            text-align: center;
            background-color: #ADADE8;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <script type="text/javascript">// <![CDATA[
        $(document).ready(function () {
// This part addresses an IE bug. without it, IE will only load the first number and will never refresh
            $.ajaxSetup({ cache: false });
            setInterval(function () {
                $('#ajax').load('ajaxtest.php');
            }, 3000); // the "3000" here refers to the time to refresh the div. it is in milliseconds.
        });
        // ]]>
    </script>

</head>


<body>
<?php
$k = $_GET["k"];
/*error_reporting(~0);
ini_set('display_errors', 1);

$adr = 'Sydney+NSW';
echo $adr;
$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$adr&sensor=false";
echo '<p>'.$url.'</p>';

$jsonData = file_get_contents($url);

print  var_dump($jsonData);

# Output information about allow_url_fopen:
if (ini_get('allow_url_fopen') == 1) {
echo '<p style="color: #0A0;">fopen is allowed on this host.</p>';
} else {
echo '<p style="color: #A00;">fopen is not allowed on this host.</p>';
}


# Decide what to do based on return value:
if ($jsonData === FALSE) {
echo "Failed to open the URL ", htmlspecialchars($url);
} elseif ($jsonData === NULL) {
echo "Function is disabled.";
} else {
echo $jsonData;
}*/
$city;
//$json = file_get_contents("http://api.outpost.travel/placeRentals?page=1&city=Paris");

$connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");

$SelectSQL = "SELECT * FROM `Groupe` WHERE `CleGroupe` = '".$k."'";
$objRS = mysql_query ($SelectSQL, $connectSQL);
$personnes = array();
while ($personne = mysql_fetch_assoc($objRS)) {

    $city = $personne['Ville'];
}

//$city = "Paris";

mysql_close($connectSQL);




$json_url = "http://api.outpost.travel/placeRentals?page=1&city=". $city;
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);

echo "<br/>";
echo "<br/>";

//print $data['items']['0']['description'];

echo "<br/>";
//$counter_hotel = 0;

?>
<div style="position: relative;">
<div style="max-width: 600px;">
<form action="restauration.php<?php echo "?k=$k"; ?>" method="post">

<table style="border: 1px solid">
	<tr>
		<th> Je suis d'acc </th>
		<th> Nom et prix </th>
		<th> Description </th>
	</tr>
<?php

foreach ($data['items'] as $value) {
    $lien = $value['link'];
    $prix = $value['price'];
    $nameH = $value['heading'];
    
    echo "<tr style=\"border: 1px solid\">";

    echo "<td>";
    echo "<input type='radio' name='logement' value=". $nameH.">";
    echo "</td>";
    $desc = str_replace('&/span&&&', '. ', $value['description']);
    str_replace('&amp;eacute;', 'e', $desc);
    echo "<td>";
    echo $nameH . " <a href= ' '. $lien .> Lien </a>, Prix: ". $prix ." € <br/>";
    echo "</td>";
    echo "<td>";
    echo $desc;
    echo "</td>";
    echo "</tr>";
}
?>
</table>
<p><input type="submit" value="Envoyer2"></p>
</form>
</div>

<div style="max-width: 400px">

    <?php


    ?>
    <br/>
    <br/>
    <form action="api.php<?php echo "?k=$k"; ?>" method="post">
        <p>Votre nom : <input type="text" name="name"/></p>

        <p>Commentaire : <textarea name="comment" autofocus placeholder="Entrez texte ici"> </textarea> </p>

        <p><input type="submit" value="Envoyer"></p>
    </form>
    <br/>
    <br/>
    <?php

    $name;
    $comment;

    date_default_timezone_set('Europe/Paris');
    $date = date('Y/m/d H:i:s', time());
    echo "heure actuelle : " . "$date";

    if(!isset($_POST['name'])){
        /*header('Location: testajax.php');*/
    }else{
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        /*$connectSQL = mysql_connect('fdb4.freehostingeu.com','1563171_gl','glproject2013') or die ("erreur de connexion");
        mysql_select_db('1563171_gl',$connectSQL) or die ("erreur de connexion base");*/

        $connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
        mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");

        $InsertSQL = "INSERT INTO `Topic`(`name`, `comment`, `date`, `groupID`) VALUES ('" . $name . "','" . $comment . "', '$date', '$k' )";
        $objRS = mysql_query($InsertSQL, $connectSQL);
        mysql_close($connectSQL);
        ?>
        <br/>
        <br/>

        <?php
        /*$connectiSQL = mysqli_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
        mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");*/
    }
    ?>



    <br/>

    <?php

    $connectiSQL = mysqli_connect("mysql.frogcp.com","u993568510_user","glproject","u993568510_gl");
    /*$connectiSQL = mysqli_connect("fdb4.freehostingeu.com","1563171_gl","glproject2013","1563171_gl");  */
    // Check connection
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $SelectSQL = "SELECT * from Topic where groupID = '$k'";
    $result = mysqli_query($connectiSQL, $SelectSQL);


    echo "<table>
                        <caption> Chat </caption>
                        <tr>
                                <th> Date </th>
                                <th> Nom </th>
                                <th> Commentaire </th>
                        </tr>

            ";

    while($row = mysqli_fetch_array($result))
    {
        //        $date = date('d/m h:i', $row['date']);
        $date = date_create($row['date'])->format('d-F H:i');
        echo "
                           <tr>
                                <td> [" . $date . "]  </td>
                                <td> [" . $row['name'] . "]  </td>
                                <td> [" . $row['comment'] . "]  </td>
                           </tr> ";
    }
    echo "</table>";
    mysqli_close($connectiSQL);

    ?>
    <br/>

</div>
</div>
<?php
echo "<br/>";



/*echo "<pre>";
print_r($data['items']);
echo "</pre>";
echo "<br/>";
echo "<pre>";
print_r($data);
echo "</pre>";*/


?>

</body>


</html>
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


</head>


<body>
<?php

//
// From http://non-diligent.com/articles/yelp-apiv2-php-example/
//

// Enter the path that the oauth library is in relation to the php file
require_once ('lib/OAuth.php');

// For example, request business with id 'the-waterboy-sacramento'
$k = $_GET["k"];
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

$unsigned_url = "http://api.yelp.com/v2/search?term=restaurants&location=". $city;

// For examaple, search for 'tacos' in 'sf'
//$unsigned_url = "http://api.yelp.com/v2/search?term=tacos&location=sf";


// Set your keys here
$consumer_key = "uyVSbe7Pd9jTg520_KhLdQ";
$consumer_secret = "RGkjiSV3CVfg4BpdHdu2o2iyUeI";
$token = "6hsfidUN33phug88UZBxIz_cUm_P08iO";
$token_secret = "aylnUTLTtPpX5jN71CkQBRmOIxY";

// Token object built using the OAuth library
$token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
$oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
$signed_url = $oauthrequest->to_url();

// Send Yelp API Call
/*$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);*/

$json_url = $signed_url;
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);


//print count($data['businesses']);

?>
<form>


<?php

echo "<table>";
echo "<tr>";
echo "<th> D'accord </th>";
echo "<th> Nom Restaurant </th>";
echo "<th> Adresse </th>";
echo "<th> Description </th>"; 

foreach ($data['businesses'] as $value) {
   
    if(isset($value['name'])){
        $nameR = $value['name'];
    }
    
    echo "<tr>";
    echo "<td>";
    echo "<input type=\"radio\" name=\"resto\" value=\" ". $nameR . " \"><p>";
    $adress = $value['location']['display_address'];
    $adressName = "";
    foreach ($adress as $value2) {
        $adressName = $adressName . ", " . $value2;
    }
    echo "</td>";
    if(isset($value['url'])){
    $lien = $value['url'];
    }

    if(isset($value['snippet_text'])){
        $desc = $value['snippet_text'];
    }
    echo "<td>";
    echo $nameR . " <a href=\" ". $lien ." \">Lien</a> <br/>";
    echo "</td>";
    
    echo "<td>";
    echo $adressName . "<br/>";
    echo "</td>"; 

    echo "<td>";  
    echo "$desc";
    echo "</td>";

    echo "</p><br/>";
    echo "</tr>";
}

echo "</table>";
?>
</form>


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

<?php

echo "<br/>";

/*echo "<pre>";
print_r($data);
echo "</pre>";*/

// Handle Yelp response data
//$response = json_decode($data);

// Print it for debugging
//print_r($response);

?>

</body>


</html>
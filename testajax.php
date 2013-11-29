<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Songs of Eurovision</title>
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

<div>
    <p>Combien de personnes prenderont part au voyage ?</p>
</div>


<br/>
<br/>

<div id="ajax">
    <p>Un jour je serai</p>
</div>
<br/>
<br/>

<!--<script type="text/javascript" src="http://www4.yourshoutbox.com/shoutbox/start.php?key=908487189"></script>-->

<form action="testajax.php" method="post">
    <p>Votre nom : <input type="text" name="name"/></p>

    <p>Commentaire : <input type="text" name="comment"/></p>

    <p><input type="submit" value="OK"></p>
</form>
<br/>
<br/>
<?php

    $name;
    $comment;
    date_default_timezone_set('Europe/Paris');
    $date = date('Y/m/d h:i:s', time());
    echo "$date";

    if(!isset($_POST['name'])){
        /*header('Location: testajax.php');*/
    }else{
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        $connectSQL = mysql_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
        mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");

        $InsertSQL = "INSERT INTO `Topic`(`name`, `comment`, `date`, ``groupID`) VALUES ('" . $name . "','" . $comment . "', '$date', '52976c2b5f5ac' )";
        $objRS = mysql_query($InsertSQL, $connectSQL);
        mysql_close($connectSQL);
?>
        <br/>
        <br/>

<?php
        /*$connectiSQL = mysqli_connect('mysql.frogcp.com', 'u993568510_user', 'glproject') or die ("erreur de connexion");
        mysql_select_db('u993568510_gl', $connectSQL) or die ("erreur de connexion base");*/
        $connectiSQL = mysqli_connect("mysql.frogcp.com","u993568510_user","glproject","u993568510_gl");
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $SelectSQL = "SELECT * from Topic";
        $result = mysqli_query($connectiSQL, $SelectSQL);

        while($row = mysqli_fetch_array($result))
        {
            echo $row['name'] . " " . $row['comment'];
            echo "<br>";
        }



    }


?>
<br/>
<br/>



</body>


</html>


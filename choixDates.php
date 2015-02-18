<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Choix Destination et Dates</title>
		<link rel="stylesheet" href="style_choix.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript">
			// librairie calendrier
 
			/* Inclure ce script dans l'entete */
 
			/* ##################### CONFIGURATION ##################### */
 
			/* ##- INITIALISATION DES VARIABLES -##*/
			var calendrierSortie = '';
			//Date actuelle
			var today = '';
			//Mois actuel
			var current_month = '';
			//Ann?actuelle
			var current_year = '' ;
			//Jours actuel
			var current_day = '';
			//Nombres de jours depuis le d?t de la semaine
			var current_day_since_start_week = '';
			//On initialise le nom des mois et le nom des jours en VF :)
			var month_name = new Array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
			var day_name = new Array('L','M','M','J','V','S','D');
			//permet de r?p?r l'input sur lequel on a click?t de le remplir avec la date format?
			var myObjectClick = null;
			//Classe qui sera d?ct?our afficher le calendrier
			var classMove = "calendrier";
			//Variable permettant de savoir si on doit garder en m?ire le champs input click?var lastInput = null;
			//Div du calendrier
			var div_calendar = "";
 
			//Fonction permettant d'initialiser les listeners
			function init_evenement(){
			//On commence par affecter une fonction ?haque ?nement de la souris
			if(window.attachEvent){
				document.onmousedown = start;
				document.onmouseup = drop;
			}
			else{
				document.addEventListener("mousedown",start, false);
				document.addEventListener("mouseup",drop, false);
			}
		}
		//Fonction permettant de r?p?r l'objet sur lequel on a click?et l'on r?p? sa classe
		function start(e){
			//On initialise l'?nement s'il n'a aps ? cr?( sous ie )
			if(!e){
				e = window.event;
			}
			//D?ction de l'?ment sur lequel on a click?    var monElement = null;
			monElement = (e.target)? e.target:e.srcElement;
			if(monElement != null && monElement)
			{
				//On appel la fonction permettant de r?p?r la classe de l'objet et assigner les variables
				getClassDrag(monElement);
        
				if(myObjectClick){
					initialiserCalendrier(monElement);
					lastInput = myObjectClick;
				}
			}
		}
		function drop(){
			myObjectClick = null;
		}
 
		function getClassDrag(myObject){
			with(myObject){
				var x = className;
				listeClass = x.split(" ");
				//On parcours le tableau pour voir si l'objet est de type calendrier
				for(var i = 0 ; i < listeClass.length ; i++){
					if(listeClass[i] == classMove){
						myObjectClick = myObject;
						break;
					}
				}
			}
		}
		window.onload = init_evenement;
 
//########################## Pour combler un bug d'ie 6 on masque les select ########################## //
		function masquerSelect(){
			var ua = navigator.userAgent.toLowerCase();
			var versionNav = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
			var isIE        = ( (ua.indexOf('msie') != -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) );
 
			if(isIE && (versionNav < 7)){
				svn=document.getElementsByTagName("SELECT");
				for (a=0;a<svn.length;a++){
					svn[a].style.visibility="hidden";
				}
			}
		}
 
		function montrerSelect(){
			var ua = navigator.userAgent.toLowerCase();
			var versionNav = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
			var isIE        = ( (ua.indexOf('msie') != -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) );
			if(isIE && versionNav < 7){
				svn=document.getElementsByTagName("SELECT");
				for (a=0;a<svn.length;a++){
					svn[a].style.visibility="visible";
				}
			}
		}
 
//########################## FIN DES FONCTION LISTENER ########################## //
 
// ## PARAMETRE D'AFFICHAGE du CALENDRIER ## //
//si enLigne est a true , le calendrier s'affiche sur une seule ligne,
//sinon il prend la taille sp?fi?ar d?ut;
 
var enLigne = false ;
var largeur = "175";
var formatage = "/";
 
/* ##################### FIN DE LA CONFIGURATION ##################### */
 
//Fonction permettant de passer a l'annee pr?dente
function annee_precedente(){
 
    //On r?p? l'annee actuelle puis on v?fit que l'on est pas en l'an 1 :-)
    if(current_year == 1){
        current_year = current_year;
    }
    else{
        current_year = current_year - 1 ;
    }
    //et on appel la fonction de g?ration de calendrier
    calendrier(    current_year , current_month, current_day);
}
 
//Fonction permettant de passer ?'annee suivante
function annee_suivante(){
    //Pas de limite pour l'ajout d'ann?
    current_year = current_year +1 ;
    //et on appel la fonction de g?ration de calendrier
    calendrier(    current_year , current_month, current_day);
}
 
 
 
 
//Fonction permettant de passer au mois pr?dent
function mois_precedent(){
 
    //On r?p? le mois actuel puis on v?fit que l'on est pas en janvier sinon on enl? une ann?
    if(current_month == 0){
        current_month = 11;
        current_year = current_year - 1;
    }
    else{
        current_month = current_month - 1 ;
    }
    //et on appel la fonction de g?ration de calendrier
    calendrier(    current_year , current_month, current_day);
}
 
//Fonction permettant de passer au mois suivant
function mois_suivant(){
    //On r?p? le mois actuel puis on v?fit que l'on est pas en janvier sinon on ajoute une ann?
    if(current_month == 12){
        current_month = 1;
        current_year = current_year  + 1;
    }
    else{
        current_month = current_month + 1;
    }
    //et on appel la fonction de g?ration de calendrier
    calendrier(    current_year , current_month, current_day);
}
 
//Fonction principale qui g?re le calendrier
//Elle prend en param?e, l'ann?, le mois , et le jour
//Si l'ann?et le mois ne sont pas renseign?, la date courante est affect?ar d?ut
function calendrier(year, month, day ){
 
    //Aujourd'hui si month et year ne sont pas renseign?
    if(month == null || year == null){
        today = new Date();
    }
    else{
        //month = month - 1;
        //Cr?ion d'une date en fonction de celle pass?en param?e
        today = new Date(year, month , day);
    }
 
    //Mois actuel
    current_month = today.getMonth()
    
    //Ann?actuelle
    current_year = today.getFullYear();
    
    //Jours actuel
    current_day = today.getDate();
    
    // On r?p? le premier jour de la semaine du mois
    var dateTemp = new Date(current_year, current_month,1);
    
    //test pour v?fier quel jour ?it le prmier du mois
    current_day_since_start_week = (( dateTemp.getDay()== 0 ) ? 6 : dateTemp.getDay() - 1);
    
    //variable permettant de v?fier si l'on est d? rentr?ans la condition pour ?ter une boucle infinit
    var verifJour = false;
    
    //On initialise le nombre de jour par mois
    var nbJoursfevrier = (current_year % 4) == 0 ? 29 : 28;
    //Initialisation du tableau indiquant le nombre de jours par mois
    var day_number = new Array(31,nbJoursfevrier,31,30,31,30,31,31,30,31,30,31);
    
    //On initialise la ligne qui comportera tous les noms des jours depuis le d?t du mois
    var list_day = '';
    var day_calendar = '';
    
    var x = 0
    
    //Lignes permettant de changer  de mois
	 
    var month_bef = "<a href=\"javascript:mois_precedent()\" style=\"float:left;margin-left:3px;\" > << </a>";
    var month_next = "<a href=\"javascript:mois_suivant()\" style=\"float:right;margin-right:3px;\" > >> </a>";
	 
	  /*   //Lignes permettant de changer l'ann?et de mois	  
	  var month_bef = "<a href=\"javascript:mois_precedent()\" style=\"margin-left:3px;\" > < </a>";
    var month_next = "<a href=\"javascript:mois_suivant()\" style=\"margin-right:3px;\"> > </a>";
    var year_next = "<a href=\"javascript:annee_suivante()\" style=\"float:right;margin-right:3px;\" >&nbsp;&nbsp; > > </a>";
    var year_bef = "<a href=\"javascript:annee_precedente()\" style=\"float:left;margin-left:3px;\"  > < < &nbsp;&nbsp;</a>";
	 */
    calendrierSortie = "<p class=\"titleMonth\"> <a href=\"javascript:alimenterChamps('')\" style=\"float:left;margin-left:3px;color:#cccccc;font-size:10px;\"> Effacer la date </a><a href=\"javascript:masquerCalendrier()\" style=\"float:right;margin-right:3px;color:red;font-weight:bold;font-size:12px;\">X</a>&nbsp;</p>";
    //On affiche le mois et l'ann?en titre
   // calendrierSortie += "<p class=\"titleMonth\" style=\"float:left;\">" + year_next + year_bef+  month_bef +  month_name[current_month]+ " "+ current_year + month_next+"</p>";
    calendrierSortie += "<p class=\"titleMonth\" style=\"float:left;\">" +  month_bef +  month_name[current_month]+ " "+ current_year + month_next+"</p>";
    //On remplit le calendrier avec le nombre de jour, en remplissant les premiers jours par des champs vides
    for(var nbjours = 0 ; nbjours < (day_number[current_month] + current_day_since_start_week) ; nbjours++){
        
        // On boucle tous les 7 jours pour cr? la ligne qui comportera le nom des jours en fonction des<br />
        // param?es d'affichage
        if(enLigne == true){
            // Si le premier jours de la semaine n'est pas un lundi alors on commence ce jours ci
            if(current_day_since_start_week != 1 && verifJour == false){
                i  = current_day_since_start_week - 1 ;
                if(x == 6){
                    list_day += "<span>" + day_name[x] + "</span>";
                    
                }
                else{
                    list_day += "<span>" + day_name[x] + "</span>";
                }
                verifJour = true;
            }
            else{
                if(x == 6){
                    list_day += "<span>" + day_name[x] + "</span>";
                    
                }
                else{
                    list_day += "<span>" + day_name[x] + "</span>";
                }
            }
            x = (x == 6) ? 0: x    + 1;
        }
        else if( enLigne == false && verifJour == false){
            for(x = 0 ; x < 7 ; x++){
                if(x == 6){
                    list_day += "<span>" + day_name[x] + "</span>";
                    
                }
                else{
                    list_day += "<span>" + day_name[x] + "</span>";
                }
            }
            verifJour = true;
        }
        //et enfin on ajoute les dates au calendrier
        //Pour g?r les jours "vide" et ?ter de faire une boucle on v?fit que le nombre de jours corespond bien au
        //nombre de jour du mois
        if(nbjours < day_number[current_month]){
            if(current_day == (nbjours+1)){
                day_calendar += "<span onclick=\"alimenterChamps(this.innerHTML)\" class=\"currentDay\">" + (nbjours+1) + "</span>";
            }
            else{
                day_calendar += "<span onclick=\"alimenterChamps(this.innerHTML)\">" + (nbjours+1) + "</span>";
            }
        }
    }
 
    //On ajoute les jours "vide" du d?t du mois
    for(i  = 0 ; i < current_day_since_start_week ; i ++){
        day_calendar = "<span>&nbsp;</span>" + day_calendar;
    }
    //Si aucun calendrier n'a encore ? cr?:
    if(!document.getElementById("calendrier")){
        //On cr?une div dynamiquement, en absolute, positionn?ous le champs input
        var div_calendar = document.createElement("div");
        
        //On lui attribut un id
        div_calendar.setAttribute("id","calendrier");
        
        //On d?nit les propri?s de cette div ( id et classe ) 
        div_calendar.className = "calendar_input";
        
        //Pour ajouter la div dans le document
        var mybody = document.getElementsByTagName("body")[0];
        
        //Pour finir on ajoute la div dans le document
        mybody.appendChild(div_calendar);
    }
    else{
            div_calendar = document.getElementById("calendrier");
    }
    
    //On ins?r dans la div, le contenu du calendrier g?r?    //On assigne la taille du calendrier de fa? dynamique ( on ajoute 10 px pour combler un bug sous ie )
    var width_calendar = ( enLigne == false ) ?  largeur+"px" : ((nbjours * 20) + ( nbjours * 4 ))+10+"px" ;
 
    calendrierSortie = calendrierSortie + list_day  + day_calendar + "<div class=\"separator\"></div>";
    div_calendar.innerHTML = calendrierSortie;
    div_calendar.style.width = width_calendar;
}
 
//Fonction permettant de trouver la position de l'?ment ( input ) pour pouvoir positioner le calendrier
function ds_getleft(el) {
    var tmp = el.offsetLeft;
    el = el.offsetParent
    while(el) {
        tmp += el.offsetLeft;
        el = el.offsetParent;
    }
    return tmp;
}
 
function ds_gettop(el) {
    var tmp = el.offsetTop;
    el = el.offsetParent
    while(el) {
        tmp += el.offsetTop;
        el = el.offsetParent;
    }
    return tmp;
}
 
//fonction permettant de positioner le calendrier
function positionCalendar(objetParent){
    //document.getElementById('calendrier').style.left = ds_getleft(objetParent) + "px";
    document.getElementById('calendrier').style.left = ds_getleft(objetParent) + "px";
    //document.getElementById('calendrier').style.top = ds_gettop(objetParent) + 20 + "px" ;
    document.getElementById('calendrier').style.top = ds_gettop(objetParent) + 20 + "px" ;
    // et on le rend visible
    document.getElementById('calendrier').style.visibility = "visible";
}
 
function initialiserCalendrier(objetClick){
        //on affecte la variable d?nissant sur quel input on a click?        myObjectClick = objetClick;
        
        if(myObjectClick.disabled != true){
            //On v?fit que le champs n'est pas d? remplit, sinon on va se positionner sur la date du champs
            if(myObjectClick.value != ''){
                //On utilise la chaine de formatage
                var reg=new RegExp("/", "g");
                var dateDuChamps = myObjectClick.value;
                var tableau=dateDuChamps.split(reg);
                calendrier(    tableau[2] , tableau[1] - 1 , tableau[0]);
            }
            else{
                //on cr? le calendrier
                calendrier(objetClick);
 
            }
            //puis on le positionne par rapport a l'objet sur lequel on a click?            //positionCalendar(objetClick);
            positionCalendar(objetClick);
            masquerSelect();
        }
 
}
 
//Fonction permettant d'alimenter le champs
function alimenterChamps(daySelect){
        if(daySelect != ''){
            lastInput.value= formatInfZero(daySelect) + formatage + formatInfZero((current_month+1)) + formatage +current_year;
        }
        else{
            lastInput.value = '';
        }
        masquerCalendrier();
}
function masquerCalendrier(){
        document.getElementById('calendrier').style.visibility = "hidden";
        montrerSelect();
}
 
function formatInfZero(numberFormat){
        if(parseInt(numberFormat) < 10){
                numberFormat = "0"+numberFormat;
        }
        
        return numberFormat;
}
 
</script>
 
</head>

<?php     

	if(isset($_GET['dateAller'])){
		$dateAller = $_GET['dateAller'];
	}else{
		$dateAller = '';
	}

	if (isset($_GET['k'])){
		$key = $_GET['k'];
	}else{
		header('Location: index.php');
	}

	/*$connectSQL = mysql_connect('...','...','...') or die ("erreur de connexion");
	mysql_select_db('1563171_gl',$connectSQL) or die ("erreur de connexion base");*/
	
	$connectSQL = mysql_connect('...', '...', '...') or die ("erreur de connexion");
    mysql_select_db('...', $connectSQL) or die ("erreur de connexion base");
	
	$SelectSQL = "SELECT * FROM `Personne` WHERE `CleGroupe` = '".$key."'";
	$objRS = mysql_query ($SelectSQL, $connectSQL);
	$personnes = array();
    $votes = array();
    while ($personne = mysql_fetch_assoc($objRS)) {
        $personnes[] = $personne['Pseudo'];
        $votes[] = $personne['Vote'];
    }

    mysql_close($connectSQL);

?>

<body>
<!-- Il faut conna?tre le nombre de personnes $nbPersonnes
        ainsi que le psuedo de ces personnes (pseudo 1, 2, 3 ;;;)-->

<form method="post" class="header" action="changeVille.php<?php echo "?k=".$key; ?>">
<div>
    <table class="titleMonth">

        <tr>
            <td>
                Destination
            </td>
            <td colspan="2">
                <input search="ville" class="ui-autocomplete-input" autocomplete="off" value="Votre recherche" name="destination" id="destination" type="text">
            </td>
        </tr>

        <tr>
            <td>
                Date de depart
            </td>
            <td colspan="2">
                <input type="text" name="dateAller" id="dateAller" class="calendrier"/>
            </td>
        </tr>

        <tr>
            <td>
                Date de retour
            </td>
            <td colspan="2">
                <input type="text" name="dateRetour" id="dateRetour" class="calendrier" />
            </td>
        </tr>

        <!-- pour r?cup?rer en php la valeur du bouton : $_POST["nom_groupe_radio_button"]-->

        <!--Ici on va ?crire le Php pour avoir le bon nombre de boutons "oui", "non" selon le nb de participants nbPersonnes -->

        <br>
        <br>
        <br>
        <br>
        <br>
        <tr>
            <td>     </td>
            <td> oui </td>
            <td> non </td>
        </tr>
        <?php
        for($i=0; $i<sizeof($personnes); $i++){
            echo "<tr>".
                "<td>".$personnes[$i]."</td>".
                "<td> <input type='radio' name='".$personnes[$i]."' value='1' ";
            if ($votes[$i] == 1){
                echo "checked";
            }
            echo "> </td>".
                "<td> <input type='radio' name='".$personnes[$i]."' value='0' ";
            if ($votes[$i] == 0){
                echo "checked";
            }
            echo "> </td>".
                "</tr>";
        }
        ?>

    </table>
	
	<input type="submit" value="Passer à l'étape suivante">
	
 </form>
 
 <div id="gynocratie"></div>
 
<?php
$k = $_GET["k"];
   $arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
//   echo json_encode($arr);
//$json = file_get_contents(api.outpost.travel/placeRentals?page=1&city=Paris);



//error_reporting(~0);
//ini_set('display_errors', 1);

$adr = 'Sydney+NSW';
//echo $adr;
$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$adr&sensor=false";
//echo '<p>'.$url.'</p>';

$jsonData = file_get_contents($url);

//print  var_dump($jsonData);

/*# Output information about allow_url_fopen:
if (ini_get('allow_url_fopen') == 1) {
        echo '<p style="color: #0A0;">fopen is allowed on this host.</p>';
} else {
    echo '<p style="color: #A00;">fopen is not allowed on this host.</p>';
}*/


/*# Decide what to do based on return value:
if ($jsonData === FALSE) {
    echo "Failed to open the URL ", htmlspecialchars($url);
} elseif ($jsonData === NULL) {
    echo "Function is disabled.";
} else {
    echo $jsonData;
}*/



?>
<br/>
<br/>

<div>
<form action="choixDates.php<?php echo "?k=$k"; ?>" method="post">
    <p>Votre nom : <input type="text" name="name"/></p>

    <p>Commentaire : <textarea name="comment" autofocus placeholder="Entrez texte ici"> </textarea> </p>

    <p><input type="submit" value="Envoyer"></p>
</form>

</div>
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
       
            
            echo "<table class='sidebar'>
                        <caption> Chat </caption
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
                                <td> " . $date . "  </td>
                                <td> " . $row['name'] . "  </td>
                                <td> " . $row['comment'] . "  </td>
                           </tr> ";              
            }
                echo "</table>";
            mysqli_close($connectiSQL);
        
        ?>
<br/>
 
 
<script>

$(document).ready(function () {

	$("input").click(function () {
		var fuckThisShit = ""+this.value;
		$('#gynocratie').load('changeVote.php?pseudo='+this.name+'&val='+fuckThisShit);
	});
	
});
	
</script>

<script type="text/javascript" src="http://www.citysearch-api.com/js/widget.js?appname=choose-and-share-travels&appkey=so664315f4880aec3434befb4ffd7b761666ecbbf3&needcss=1&sdefault=1&debug=0"></script> 
        
</body>
</html>

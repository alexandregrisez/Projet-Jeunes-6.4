<?php

function demandes_validees($email){
    $database=fopen("demandes.txt","r+");
    $buffer="123";
	$TAB=[];
    $tab=[];
	$i=0;
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[0])){
                if($email==$tab[0] && $tab[2]==0){
                   $TAB[$i]=$tab;
				   $i=$i+1;
                }
            }
        }
    }
    fclose($database);
	return $TAB;
}

session_start();
if(!(isset($_SESSION['derniereconnexion']))){
	$_SESSION['erreur']=2;
	header('Location: Connexion.php');
}

if(isset($_SESSION['derniereconnexion']) && time() - $_SESSION['derniereconnexion'] > 1200){
		$_SESSION['erreur']=3;
		header('Location: Connexion.php');
}

if(isset($_POST['email'])){
	
}

?>
<html>
<head>
    <title> Votre Espace - Jeunes 6.4</title>
    <link rel="stylesheet" href="EnvoiConsultant.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>
	<!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> ESPACE JEUNE </h1>
    </div>
    <div id=invisible></div>
	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">
		<p id="titre"> Envoi de vos références à un consultant :</p>
		</br>
		<form method='post' action='EnvoiConsultant.php'>
			<label for="email">Saisissez l'adresse e-mail de votre consultant : </label>
            <input type="email" id="email" name="email" required><br><br>
			<p id="txt2"> Veuillez sélectionner les références à envoyer : </p>
			<?php
				$i=0;
				$DEMANDES=demandes_validees($_SESSION['email']);
				if(count($DEMANDES)==0){
					echo "<p> Vous n'avez pas encore de demandes de références validées.</p>";
				}
				else{
					for($i=0;$i<count($DEMANDES);$i++){
				    	echo "<div class='demande'><input type='checkbox' id='demande".$DEMANDES[$i][1]."' name='demande$i'>
                              <label for='demande$i'> Demande de référence n°".$DEMANDES[$i][1]." à ".$DEMANDES[$i][7]." ".$DEMANDES[$i][8]." - ".							  $DEMANDES[$i][10]."</label></div> </br>";
					}
				}
				
			?>
			<input type="submit" id="boutonformulaire" value="Envoyer">
		</form>
		<div id=divlien> <a id="lien" href="CompteJeune.php"> Retour </a> </div>
	</div>
	</br>
	</br>
</body>
</html>

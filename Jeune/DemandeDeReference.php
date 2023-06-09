<?php
/*
Cette page contient un formulaire qui permet de soumettre une demande de référence.
*/

// Vérification de l'état de la session.
// Cela est nécéssaire sur le module Jeune car l'utilisateur est connecté où déconnecté.
// Si l'utilisateur n'est pas connecté, il ne doit pas être sur la page, il est renvoyé à la page de connexion avec l'erreur 2
// Si l'utilisateur est connecté depuis trop de temps, sa session expire avec l'erreur 3 (ici 20 minutes).
session_start();
if(!(isset($_SESSION['derniereconnexion']))){
	$_SESSION['erreur']=2;
	header('Location: Connexion.php');
}

if(isset($_SESSION['derniereconnexion']) && time() - $_SESSION['derniereconnexion'] > 1200){
		$_SESSION['erreur']=3;
		header('Location: Connexion.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> Votre Espace - Jeunes 6.4</title>
    <link rel="stylesheet" href="DemandeDeReference.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>

	<!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> ESPACE JEUNE </h1>
    </div>

    <!--Div invisible en positionnement relatif pour remplir la place que prendrait normalement l'entête sans 
    positionnement absolu.-->
    <!--Cela pour ne pas que le corps et l'entête se chevauchent.-->
    <div id=invisible></div>

	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">
        <p id="titre"> Création d'une demande de référence :</p>
        </br>
        <p> <b>Veuillez compléter ce formulaire : </b></p>

        <!--Formulaire de la demande de référence, en trois parties.
            1) Le référent
            2) L'engagement
            3) Les savoir-être
        -->
		<div id="formulaire">
            <form method='post' action='Resume.php'>
                <div id="tiers1">
                    <p id="txt1"> <b>Votre référent :</b></p>
                    <label for="nom">Nom : </label>
                    <input type="text" id="nom" name="nom" required><br><br>
                    <label for="prenom">Prénom : </label>
                    <input type="text" id="prenom" name="prenom" required><br><br>
                    <label for="metier">Métier : </label>
                    <input type="text" id="metier" name="metier" required><br><br>
                    <label for="email">Adresse e-mail : </label>
                    <input type="email" id="email" name="email" required><br><br>
                </div>
                <div id="tiers2">
                    <p id="txt2"> <b>Votre engagement :</b></p>
                    <label for="domaine">Domaine : </label>
                    <input type="text" id="domaine" name="domaine" required><br><br>
                    <label for="date1">Date de début : </label>
                    <input type="date" id="date1" name="date1" required><br><br>
                    <label for="date2">Date de fin : </label>
                    <input type="date" id="date2" name="date2" required><br><br>
                    <label for="desc">Description : </label>
                    <input type="text" id="desc" name="desc" required><br><br>
                </div>
                <div id="tiers3">
                    <!--Plein de cases à cocher, leur nom est qualité+i pour pouvoir les identifier facilement par la suite-->
                    <fieldset id="selection">  
                        <legend id="txt3"> <b>Votre savoir-être : </b></legend>
                        </br>
                        <input type="checkbox" id="qualite1" name="qualite1">
                        <label for="qualite1">Enthousiasme</label> </br>
                        <input type="checkbox" id="qualite2" name="qualite2">
                        <label for="qualite2">Communication</label></br>
                        <input type="checkbox" id="qualite3" name="qualite3">
                        <label for="qualite3">Bienveillance</label></br>
                        <input type="checkbox" id="qualite4" name="qualite4">
                        <label for="qualite4">Rigueur</label></br>
                        <input type="checkbox" id="qualite5" name="qualite5">
                        <label for="qualite5">Réactivité</label></br>
                        <input type="checkbox" id="qualite6" name="qualite6">
                        <label for="qualite6">Adaptation</label></br>
                        <input type="checkbox" id="qualite7" name="qualite7">
                        <label for="qualite7">Persévérance</label></br>
                        <input type="checkbox" id="qualite8" name="qualite8">
                        <label for="qualite8">Curiosité</label></br>
                        <input type="checkbox" id="qualite9" name="qualite9">
                        <label for="qualite9">Organisation</label></br>
                        <input type="checkbox" id="qualite10" name="qualite10">
                        <label for="qualite10">Rapidité</label></br>
                        <input type="checkbox" id="qualite11" name="qualite11">
                        <label for="qualite11">Travail en équipe</label></br>
                        <input type="checkbox" id="qualite12" name="qualite12">
                        <label for="qualite12">Prise de recul</label></br>
                        <input type="checkbox" id="qualite13" name="qualite13">
                        <label for="qualite13">Honnêteté</label>
                        <p>(4 maximum)</p>
                    </fieldset>
                </div>
		</div>
        <input type="submit" id="boutonformulaire" value="Valider">
        
        </form>
        <div id=divlien> <a id="lien" href="CompteJeune.php"> Retour </a> </div>
        
    </div>
	
	
	
</body>
</html>

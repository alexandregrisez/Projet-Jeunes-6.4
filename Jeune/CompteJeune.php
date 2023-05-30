<?php
/*
Cette page est le tableau de bord du jeune, il peut accéder à toutes les fonctionnalités et voir les informations de son compte.
*/

/*
Cette fonction prend un email en paramètre et renvoie un tableau de tableaux qui contient toutes 
les demandes de référence associées à l'email.
*/
function recherche_demandes($email){
    $database=fopen("demandes.txt","r+");
    $buffer="123";
	$TAB=[];
    $tab=[];
	$i=0;
	// Parcours du fichier de données, si l'email de la demande correspond, on ajoute la demande au grand tableau
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[0])){
                // $tab[0] est l'email de la ligne
                if($email==$tab[0]){
                   $TAB[$i]=$tab;
				   $i=$i+1;
                }
            }
        }
    }
    
    fclose($database);
	return $TAB;
}

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
    <link rel="stylesheet" href="CompteJeune.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>
	<!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> ESPACE JEUNE </h1>
    </div>

	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">

		<!--Une div qui contient les informations du jeune.-->
		<div id="infosperso">
			<p id="txt1"> Vos informations :</p>
			<div id="conteneur">
				<p class="nomargin" id="info1"> Nom : <?php echo $_SESSION['nom'];?></p>
				<p class="nomargin" id="info2"> Prénom : <?php echo $_SESSION['prenom'];?></p>
				<p class="nomargin" id="info3"> Né(e) le : <?php echo $_SESSION['ddn'];?> </p>
				<p class="nomargin" id="info4"> Adresse mail : <?php echo $_SESSION['email'];?> </p>
			</div>
			<p id="txt2"> Quelque chose ne va pas ? <a id="lien2" href="ModificationProfil.php"> Cliquez ici </a></p>
		</div>

		<!--Une div qui contient trois boutons (liens) pour accéder aux fonctionnalités du site.-->
		<div id="troisoptions">
			<div id=creationref class="bouton">
				<a class="lien" href="DemandeDeReference.php">Créer une demande de référence </a>
			</div>
			<div id=envoirefs class="bouton">
				<a class="lien" href="EnvoiConsultant.php">Envoyer ses références </a>
			</div>
			<div id=inclusionCV class="bouton">
				<a class="lien" href="DemandeDeReference.php">Inclure ses références dans son CV </a>
			</div>
		</div>
	</div>

	<!--Div invisible en positionnement relatif pour remplir la place que prendrait normalement tout ce qu'il y a avant sans 
    positionnement absolu.-->
    <!--Cela pour ne pas que le corps la partie qui suit se chevauchent.-->
	<div id=invisible></div>
	
	<!-- Div qui sert à afficher toutes les demandes de références du jeune.-->
	<div id=listerefs>
		<p id='vosdemandes'> Vos demandes de références  </p>
	
		<?php
			// On prend la liste de toutes les demandes du jeune et on les affiche en HTML.
			$liste=recherche_demandes($_SESSION['email']);
			if($liste==[]){
				echo "<p id='message'>Vous n'avez pas encore effectué de demande de références :( </p>";
			}
			else{
				$i=0;
				for($i=0;$i<count($liste);$i++){
					echo "<div class='demande'>";
					echo "<p class='referent'> À : ".$liste[$i][8]." ".$liste[$i][7]."</p>";
					// Le statut de la demande peut changer l'affichage
					if($liste[$i][2]==0){
						echo "<p class='statut'> Statut : <i class='statut0'> Validée </i></p>";
					}
					else{
						echo "<p class='statut'> Statut : <i class='statut1'> En revue </i></p>";
					}
					echo "<p class='iddemande'> N° demande : ".$liste[$i][1]."</p>";
					echo "<a href='Resume.php/?id=".$liste[$i][1]."' class='details'> Détails </a>";
					echo "</div>";
				}
			}
		?>
	</div>
	</br>
	</br>
	<!--Cette page permet de se déconnecter, elle envoie sur la page de connexion avec un paramètre GET spécifique
		pour que la page termine la session.-->
	<div id=divlien> <a id="lien" href='Connexion.php/?deco=1'> Déconnexion </a> </div>
	</br>
	</br>
</body>
</html>

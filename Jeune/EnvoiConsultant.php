<?php
/*
Cette page permet au jeune d'envoyer ses références à un consultant.
Il faut entrer l'adresse mail du consultant et cocher parmis les demandes de références validées du compte.
*/

// Envoi du mail au consultant :
// Inclusion des fonctions de PHPMailer au code.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";

/*
Cette fonction envoie le mail de présentation de Jeunes 6.4 au consultant. Celui-ci comprend le lien qui permet 
d'accéder à l'espace consultant.
Elle prend en paramètre l'email du consultant ainsi que la liste des IDs des références envoyées par le jeune.
Cette liste est de la forme "id1,id2,id3...etc". 
La fonction renvoie un entier qui correspond à l'issue atteinte lors de l'exécution du code. 0 est retourné
s'il n'y a pas eu de problème.
*/
function envoimail($email,$liste){
	// I
	// Le but est ici de récupérer tout ce qui peut personnaliser le mail : nom, prénom des personnes impliquées...
	// On récupère l'email du jeune qui va servir à avoir ses informations dans comptes.txt
    $emailjeune=$_SESSION['email'];

	// On ouvre ensuite le fichier de données.
    $buffer="123";
    $tab=[];
    $database=fopen("comptes.txt","r+");
    if(!$database){
		// Erreur n°100 : On ne peut pas ouvrir un fichier de données.
        return 100;
    }
	// Les fonctions de recherche dans les fichiers de données sont toutes très similaires :
	// On lit chaque ligne du fichier en la transformant en tableau à partir des virgules qui séparent les champs.
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
			// Si l'email de la ligne est bien défini...(sécurité contre les lignes vides)
            if(isset($tab[3])){
                if($emailjeune==$tab[3]){
					// Alors on peut récupérer les bons nom et prénom
                    $nomjeune=$tab[0];
                    $prenomjeune=$tab[1];
					// break pour arrêter de parcourir le fichier une fois les informations obtenues
                    break;
                }
            }
        }
    }
    fclose($database);

	// Ceci sont les liens qui pourront être suivis dans le mail.
	// Le premier envoie vers le module consultant, on ajoute la liste en argument de GET à la fin pour que la page
	// puisse afficher toutes les références
	// Le deuxième envoie simplement sur le portail du site.
	// Pour avoir la bonne adresse peu importe le port de localhost, on utilise la variable $_SERVER
    $lien1='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'/../../Consultant/Consultant.php/?liste='.$liste;
    $lien2='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'/../../Visiteur/Portail.html';

	// II
    // Configuration de PHPMailer et envoi du mail

	
    $mail = new PHPMailer();
	// Indique que nous utilisons un serveur smtp
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
	// Encodage
    $mail->CharSet="UTF-8";
	// Serveur gmail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;

	// Nous avons créé un compte google dédié pour l'envoi des mails, car sinon nos mots de passe personnels
	// seraient affichés sur le dépôt public
	// Cela constitue quand même une faille de sécurité car des personnes peuvent accéder à ce compte,
	// cependant l'authentification à 2 facteurs est activée ce qui empêche théoriquement d'autres que nous
	// d'accéder au compte.
    $mail->Username = 'equipe.jeunes64@gmail.com';
    $mail->Password = 'wxkkbpvoqgapovmh';

    // Élaboration du mail

	// Expéditeur
    $mail->setFrom($mail->Username, 'JEUNES 6.4');
	// Destinataire
    $mail->addAddress($email,"");
	// Objet
    $mail->Subject = 'Jeunes 6.4 | Envoi de références';

	// Corps en HTML
	// Le style est directement inclus dans <head>
	// Certains styles comme la couleur des liens fonctionnent sur certains appareils et pas sur d'autres...
	// nous ne savons pas ce qui cause cela.
	// Nous avons vu que le thème sombre modifie certaines couleurs et rend la div illisible, il est préférable 
	// d'avoir un thème clair classique sur la boîte mail
    $mail->Body = 
	"<html>

    <head>
    <style type='text/css'>
            p{
                margin-left:15px;
                margin-right:15px;
            }
            .corps{
                    color:grey;
                    font-family:"."'Lucida Sans'".", 'Lucida Sans Regular'"." !important;
                    background-image:linear-gradient(to bottom, #fff, #ccc);
                    border: 3px solid #e60080;
            }
            .lien{
                    color: #e60080;
                    text-decoration:none;
            }
    </style>
    </head>

    <body>
        <div class='corps'><p> <br> <br>
            Madame, Monsieur,<br> <br>
    
            Connaissez-vous JEUNES 6.4 ? C'est une plateforme qui permet à chaque jeune de la région aquitaine
            de faire valoir ses compétences en faisant certifier leur compte par des professionnels.<br> <br>
                   
            Le fait est qu'un jeune a décidé de vous montrer ses certifications afin que vous soyez sûr 
			de ses compétences !<br> <br>
                   
            En effet, {$prenomjeune} {$nomjeune} souhaite que vous jettiez un oeil à ses références sur
            notre plateforme.<br><br>
                   
            Veuillez suivre ce lien pour accéder aux références envoyées : <br>
            <a  class='lien' href='{$lien1}'> Accès à l'espace Consultant </a> <br> <br>

            À très bientôt sur <a class='lien' href='{$lien2}'> JEUNES 6.4 </a> ! <br> <br>
                   
            Cordialement,<br>
            L'équipe JEUNES 6.4<br><br>
            </p>
        </div>
    </body>
    </html>";

	// Corps alternatif s'il s'avère que la boîte mail de l'utilisateur ne prend pas en compte le HTML
	// Non testé
    $mail->AltBody = 
    "Madame, Monsieur,
    
    Connaissez-vous JEUNES 6.4 ? C'est une plateforme qui permet à chaque jeune de la région aquitaine
    de faire valoir ses compétences en faisant certifier leur compte par des professionnels.
    
    Le fait est qu'un jeune a décidé de vous montrer ses certifications afin que vous soyez sûr 
	de ses compétences !
    
	En effet, {$prenomjeune} {$nomjeune} souhaite que vous jettiez un oeil à ses références sur
	notre plateforme.
    
    Veuillez suivre ce lien pour accéder aux références envoyées :
    {$lien1}


    À très bientôt !
    
    Cordialement,
    L'équipe JEUNES 6.4";

	// Envoi du mail
	// Erreur n°105 si un problème est détecté, 0 sinon.
    if (!$mail->send()) {
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        return 105;
    } 
    else {
        // echo 'Message sent!';
        return 0;
    }
}

/*
Cette fonction renvoie un tableau de tableaux correspondant à toutes les demandes validées pour l'utilisateur à l'email $email.
Elle renvoie un tableau vide si un problème survient où si l'utilisateur n'a pas encore de demandes valides.
*/
function demandes_validees($email){
    $database=fopen("demandes.txt","r+");
	if(!$database){
        return [];
    }
    $buffer="123";
	$TAB=[];
    $tab=[];
	$i=0;
	// Les fonctions de recherche dans les fichiers de données sont toutes très similaires :
	// On lit chaque ligne du fichier en la transformant en tableau à partir des virgules qui séparent les champs.
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            // Si l'email de la ligne est bien défini...(sécurité contre les lignes vides)
            if(isset($tab[0])){
                // Si l'email de la ligne correspond à celui que l'on cherche et que le statut de la demande vaut 0 
                // (demande validée)
                if($email==$tab[0] && $tab[2]==0){
                   // Le tableau correspondant à toute la demande est ajouté au tableau global des demandes validées. 
                   $TAB[$i]=$tab;
				   $i=$i+1;
                }
            }
        }
    }
    fclose($database);
	return $TAB;
}

// Valeur initiale de l'erreur.
$erreur=-1;

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

// Si des informations ont été envoyées par le formulaire de la page, PHP doit en faire le traitement.
if(isset($_POST['email'])){
    // Ici, le traitement consiste à envoyer le mail au consultant.
    // Il faut d'abord la liste des IDs des demandes sélectionnées par le jeune
	$liste="";
    // On parcourt $_POST pour les avoir (chaque case qui était à cocher avait pour nom "demande"+son ID)
    // Les valeurs des cases à cocher sont inutiles, elles valent toutes 'on', il faut le nom d'origine contenu dans $cle
	foreach($_POST as $cle => $valeur){
        // On exclut la seule variable autre que les demandes cochées
		if($cle!='email'){
            // On enlève le "demande" du nom "demande"+id pour avoir l'ID et on le rajoute à la liste avec une virgule
			$id=substr($cle,7);
			$liste.=$id.',';
		}
	}
    // Si l'utilisateur n'a pas sélectionné de demandes, erreur n°5.
	if($liste==""){
		$erreur=5;
	}
    // On finit la liste de manière repérable
	$liste.='fin';

    // Si pas d'erreur, envoi du mail au consultant.
    if($erreur==-1){
        //$erreur=envoimail($_POST['email'],$liste);
    }
	
}

?>
<!DOCTYPE html>
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

    <!--Div invisible en positionnement relatif pour remplir la place que prendrait normalement l'entête sans 
    positionnement absolu.-->
    <!--Cela pour ne pas que le corps et l'entête se chevauchent.-->
    <div id=invisible></div>


	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">
		<p id="titre"> Envoi de vos références à un consultant :</p>
		</br>

        <!-- Div qui sert au PHP à relayer des messages à l'utilisateur-->
		<div id="annonceur"> 
			<?php
                // En fonction de la valeur de $erreur, un message différent est envoyé.
				switch($erreur){
					case 0:
						echo "<p class='vert'>Vos références ont bien été envoyées.</p>";
						break;
					case 5:
						echo "<p class='rouge'>Erreur : Vous n'avez sélectionné aucune référence.</p>";
						break;
					case 100:
						echo "<p class='rouge'>Erreur : Nous n'avons pas pu envoyer vos références.</p>";
						break;
					case 105:
						echo "<p class='rouge'>Erreur : Nous n'avons pas pu envoyer vos références.</p>";
						break;
					default:
						echo "";
						break;
				}
			?>
		</div>
		</br>

        <!-- Le formulaire de la page, qui sert au jeune à indiquer l'adresse du consultant ainsi qu'à sélectionner
             les références souhaitées-->
		<form method='post' action='EnvoiConsultant.php'>
			<label for="email">Saisissez l'adresse e-mail de votre consultant : </label>
            <input type="email" id="email" name="email" required><br><br>
			<p id="txt2"> Veuillez sélectionner les références à envoyer : </p>
			<?php
                // Pour la deuxième partie du formulaire, nous devons afficher chaque demande validée avec une option pour
                // l'inclure ou non.
				$i=0;
                // $DEMANDES sera toutes les demandes validées du jeune.
				$DEMANDES=demandes_validees($_SESSION['email']);
				if(count($DEMANDES)==0){
                    // Cas où le jeune n'a pas encore de demandes validées.
					echo "<p> Vous n'avez pas encore de demandes de références validées.</p>";
				}
				else{
                    // Pour chaque demande validée, on crée une checkbox avec des attributs qui permettront d'identifier la
                    // demande par son ID et on affiche quelques informations sur la demande pour qu'elle soit facilement
                    // identifiable par le jeune.
                    // Tout cela est mis dans une div qui sera stylisée.
					for($i=0;$i<count($DEMANDES);$i++){
				    	echo "<div class='demande'><input type='checkbox' id='demande".$DEMANDES[$i][1]."' name='demande".$DEMANDES[$i][1]."'>
                              <label for='demande".$DEMANDES[$i][1]."'> Demande de référence n°".$DEMANDES[$i][1]." à ".$DEMANDES[$i][7]." ".$DEMANDES[$i][8]." - ".							  $DEMANDES[$i][10]."</label></div> </br>";
					}
				}
				
			?>
            <!-- Fin du formulaire -->
			<input type="submit" id="boutonformulaire" value="Envoyer">
		</form>
		<div id=divlien> <a id="lien" href="CompteJeune.php"> Retour </a> </div>
	</div>
	</br>
	</br>
</body>
</html>

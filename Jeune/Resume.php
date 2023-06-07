<?php
/*
Cette page permet au jeune de consulter les détails d'une demande de référence.
On peut y accéder en cliquant sur "détails" dans la liste des demandes de son compte, elle s'affiche aussi automatiquement
après avoir créé une demande de référence.
C'est elle qui gère la création de la demande de référence avec PHP et l'envoi du mail au référent. 
*/

// Envoi du mail au référent :
// Inclusion des fonctions de PHPMailer au code.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../PHPMailer/src/Exception.php";
require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";


/*
Cette fonction envoie le mail de présentation de Jeunes 6.4 au référent. Celui-ci comprend le lien qui permet 
d'accéder à l'espace référent.
Elle prend en paramètre l'id de la demande qui vient d'être créée 
La fonction renvoie un entier qui correspond à l'issue atteinte lors de l'exécution du code. 0 est retourné
s'il n'y a pas eu de problème.
*/
function envoimail($id){
    // I
	// Le but est ici de récupérer tout ce qui peut personnaliser le mail : nom, prénom des personnes impliquées...
    $buffer="123";
    $tab=[];
    $database=fopen("demandes.txt","r+");
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
            // Si l'id de la ligne est bien défini...(sécurité contre les lignes vides)
            if(isset($tab[1])){
                // Si l'id de la ligne correspond, on récupère les informations du référent ainsi que l'email du jeune
                if($id==$tab[1]){
                    $emailjeune=$tab[0];
                    $domaine=$tab[6];
                    $nomref=$tab[7];
                    $prenomref=$tab[8];
                    $emailref=$tab[9];
                    // break pour arrêter de parcourir le fichier une fois les informations obtenues
                    break;
                }
            }
        }
    }
    fclose($database);

    // Par le même procédé, on récupère les informations du jeune grâce à son email dans comptes.txt
    $buffer="123";
    $tab=[];
    $database=fopen("comptes.txt","r+");
    if(!$database){
        return 100;
    }
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[3])){
                if($emailjeune==$tab[3]){
                    $nomjeune=$tab[0];
                    $prenomjeune=$tab[1];
                    break;
                }
            }
        }
    }
    fclose($database);

    // Ceci sont les liens qui pourront être suivis dans le mail.
	// Le premier envoie vers le module référent, on ajoute l'id de la demande en argument de GET à la fin pour que la page
	// puisse afficher la demande de référence au référent
	// Le deuxième envoie simplement sur le portail du site.
	// Pour avoir la bonne adresse peu importe le port de localhost, on utilise la variable $_SERVER
    $lien1='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'/../../Referent/Referent.php/?id='.$id;
    $lien2='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'/../../Visiteur/Portail.html';

    // Configuration de PHPMailer
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
    $mail->addAddress($emailref, $prenomref." ".$nomref);
    // Objet
    $mail->Subject = 'Jeunes 6.4 | Nouvelle demande de référence';

    // Corps en HTML
	// Le style est directement inclus dans <head>
	// Certains styles comme la couleur des liens fonctionnent sur certains appareils et pas sur d'autres...
	// nous ne savons pas ce qui cause cela.
	// Nous avons vu que le thème sombre modifie certaines couleurs et rend la div illisible, il est préférable 
	// d'avoir un thème clair classique sur la boîte mail
    $mail->Body = "<html>

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
                   Bonjour {$prenomref},<br> <br>
    
                   Connaissez-vous JEUNES 6.4 ? C'est une plateforme qui permet à chaque jeune de la région aquitaine
                   de faire valoir ses compétences en faisant certifier leur compte par des professionnels.<br> <br>
                   
                   Eh bien, bonne nouvelle, un jeune a estimé que vous pouviez certifier ses compétences !<br> <br>
                   
                   En effet, {$prenomjeune} {$nomjeune} souhaite que vous validiez sa demande de référence sur
                   notre plateforme.<br>
                   Il estime avoir acquis de l'expérience dans le domaine suivant : {$domaine} <br><br>
                   
                   Veuillez suivre ce lien pour lui permettre de bénéficier de votre validation : <br>
                   <a  class='lien' href='{$lien1}'> Accès à l'espace Référent </a> <br> <br>

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
    "Bonjour {$prenomref},
    
    Connaissez-vous JEUNES 6.4 ? C'est une plateforme qui permet à chaque jeune de la région aquitaine
    de faire valoir ses compétences en faisant certifier leur compte par des professionnels.
    
    Eh bien, bonne nouvelle, un jeune a estimé que vous pouviez certifier ses compétences !
    
    En effet, {$prenomjeune} {$nomjeune} souhaite que vous validiez sa demande de référence sur
    notre plateforme.
    Il estime avoir acquis de l'expérience dans le domaine suivant : {$domaine}
    
    Veuillez suivre ce lien pour lui permettre de bénéficier de votre validation :
    {$lien1}

    À très bientôt !
    
    Cordialement,
    L'équipe JEUNES 6.4";

    // Envoi du mail
	// Erreur n°105 si un problème est détecté, 0 sinon.
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return 105;
    } 
    else {
        echo 'Message sent!';
        return 0;
    }
}


/*
Cette fonction vérifie si la demande d'id $id est bien associée au compte jeune d'adresse $email. 
*/
function verificationGET($id,$email){
	$buffer="123";
    $tab=[];

    // On parcourt le fichier de la même manière que précédemment dans la fonction mail
    $database=fopen("demandes.txt","r+");
    if(!$database){
        return 1;
    }

    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
				// Il faut que l'email + l'id correspondent tout les deux
                if($id==$tab[1] && $email==$tab[0]){
                    return 0;
                }
            }
        }
    }
    fclose($database);
    return 1;
}

/*
Cette fonction prend un nombre en paramètre et renvoie la qualité associée (str)
(Utilsée pour gérer la sélection des savoir-être)
*/
function listequalites($nb){
    switch($nb){
        case 1:
            return "Enthousiasme";
        case 2:
            return "Communication";
        case 3:
            return "Bienveillance";
        case 4:
            return "Rigueur";
        case 5:
            return "Réactivité";
        case 6:
            return "Adaptation";
        case 7:
            return "Persévérance";
        case 8:
            return "Curiosité";
        case 9:
            return "Organisation";
        case 10:
            return "Rapidité";
        case 11:
            return "Travail en équipe";
        case 12:
            return "Prise de recul";
        case 13:
            return "Honnêteté";
        default:
            return "erreur";
    }
}

/*
Cette fonction crée et renvoie un id inutilisé pour une nouvelle demande de référence sur le site.
*/
function creationid(){
    $id=100;
    $buffer="123";
    $tab=[];

    // On parcourt le fichier de la même manière que précédemment dans la fonction mail
    $database=fopen("demandes.txt","r+");
    if(!$database){
        return $id;
    }

    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                // On prend le maximum+1 de tout les IDs
                if($id<=$tab[1]){
                    $id=$tab[1]+1;
                }
            }
        }
    }
    fclose($database);
    return $id;
}

/*
Cette fonction prend en paramètre le nécéssaire à la création d'une demande de référence et l'écrit dans le fichier de données.
Elle renvoie un entier : 0 si il n'a pas eu de problème, autre chose sinon.
*/
function demandedereference($id,$nom,$prenom,$metier,$email1,$desc,$domaine,$date1,$date2,$qual1,$qual2,$qual3,$qual4,$email2){
    // Si le fichier de demandes n'existe pas, on le crée en l'ouvrant avec w
    if(!file_exists("demandes.txt")){
    	$temp=fopen("demandes.txt","w");
    	fclose($temp);
    }
    $database=fopen("demandes.txt","r+");
    if(!$database){
        // Erreur : On n'arrive pas à ouvrir le fichier de données
        return 1;
    }
    // Une boucle pour arriver à la fin du fichier.
    while(fgets($database)!=false){
        $i=1;
    }

    // En fonction du nombre de savoir-être sélectionnés par le jeune, le nombre d'arguments utilisés est différent
    // On détermine le nombre de savoir-être sélectionnés en regardant à partir duquel  $qual/i/ vaut ""
    // Erreur si l'écriture ne fonctionne pas.
    if($qual2==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1."\n")==false){
            return 1;
        }
    }
    else if($qual3==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2."\n")==false){
            return 1;
        }
    }
    else if($qual4==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2.";".$qual3."\n")==false){
            return 1;
        }
    }
    else{
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2.";".$qual3.";".$qual4."\n")==false){
            return 1;
        }
    } 
    fclose($database);
    return 0;
}

/*
Cette fonction prend un id en paramètre et affiche la demande de référence correspondante en HTML
Elle renvoie 0 si tout s'est bien passé, autre chose sinon.
*/
function affichedemande($id){
    $buffer="123";
    $tab=[];

    $database=fopen("demandes.txt","r+");
    if(!$database){
        return 1;
    }

    // Parcours du fichier de données par le même procédé que précédemment
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                // Si l'ID correspond, on prend toutes les informations de la demande
                if($id==$tab[1]){
                    $emailjeune=$tab[0];
                    $statut=$tab[2];
                    $desc=$tab[3];
                    $date1=$tab[4];
                    $date2=$tab[5];
                    $domaine=$tab[6];
                    $nom=$tab[7];
                    $prenom=$tab[8];
                    $emailref=$tab[9];
                    $metier=$tab[10];
                    $qualites=explode(";",$tab[11]);
                    break;
                }
            }
        }
    }
    fclose($database);
    
    // Affichage de la demande de référence sous la forme d'une div
    // La div comporte trois parties, une pour les informations du référent, une pour l'engagement du jeune, une pour ses 
    // savoir-être
    echo "<div id='demande'>
              <p> Vous (".$emailjeune.") avez émis la demande de référence n°".$id." :</p>
              <div id='tiers1'>
                  <p id='affichage1'> Votre référent : </p>
                  <p> Nom : ".$nom."</p>
                  <p> Prénom : ".$prenom."</p>
                  <p> E-mail : ".$emailref."</p>
                  <p> Métier : ".$metier."</p>
              </div>
              </br>
              <div id='tiers2'>
                  <p id='affichage2'> Votre engagement : </p>
                  <p> Domaine : ".$domaine."</p>
                  <p> Du ".$date1." au ".$date2." </p>
                  <p> Description : ".$desc."</p>
              </div>
              </br>
              <div id='tiers3'>
                  <p id='affichage3'> Vos qualités démontrées : </p>";
    // Pour les savoir-être, on doit faire au cas par cas selon le nombre de qualités que le jeune a sélectionné.
    // Cela aurait pu être mis sous la forme d'une boucle
    $nb=count($qualites);
    if($nb==1){
        echo "<p>-".$qualites[0]."</p>";
    }
    else if($nb==2){
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
    }
    else if($nb==3){
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
        echo "<p>-".$qualites[2]."</p>";
    }
    else{
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
        echo "<p>-".$qualites[2]."</p>";
        echo "<p>-".$qualites[3]."</p>";
    }
    echo "    </div>
          </div>";
          
    return 0;
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
// Valeur initiale de l'erreur
$erreur=-1;

// Deux cas se présentent : 
// 1) Le jeune arrive après avoir rempli le formulaire de la demande de référence
// 2) Le jeune arrive en ayant cliqué sur "détails" sur son tableau de bord 
$cas=0;

// Si aucun des cas, erreur
if(!isset($_POST['nom']) && !isset($_GET['id'])){
    $erreur=5;
}

// Détermination du cas
if($erreur==-1){
    if(isset($_POST['nom'])){
        $cas=1;
    }
    else{
        $cas=2;
    }
}

// Dans le cas 1, il faut vérifier certaines choses avant d'écrire la demande dans le fichier, d'envoyer le mail au référent,
// et d'en afficher le résumé.
if($cas==1){
    // On compte d'abord le nombre de qualités sélectionnées dans le formulaire et on en fait la liste
    $i=0;
    $j=0;
    $qualites=[];
    // Il y a 13 qualités possibles, on vérifie pour chacune d'elles si elle est active et on la met dans la liste
    // avec la fonction dédiée
    for($i=1;$i<14;$i++){
        if(isset($_POST['qualite'.strval($i)])){
            $qualites[$j]=listequalites($i);
            $j+=1;
        }
    }
    // Si pas de qualités sélectionnées, erreur
    if($j==0){
        $erreur=9;
    }

    // Pour des raisons d'arguments de fonction, il faudra que les quatre $qual soient définis, on déclare donc ceux qui manquent
    if($j==1){
        $qualites[1]="";
        $qualites[2]="";
        $qualites[3]="";
    }
    if($j==2){
        $qualites[2]="";
        $qualites[3]="";
    }
    if($j==3){
        $qualites[3]="";
    }
    // Si plus de 4 qualités sélectionnées, erreur
    if($j>4){
        $erreur=10;
    }
    // Si pas d'erreur jusque là, on peut créer un id et écrire la demande de référence dans demandes.txt
    // Si toujours aucune erreur, on envoie le mail.
    if($erreur==-1){
        $id=creationid();
        $erreur=demandedereference($id,$_POST['nom'],$_POST['prenom'],$_POST['metier'],$_POST['email'],$_POST['desc'],
                                   $_POST['domaine'],$_POST['date1'],$_POST['date2'],$qualites[0],$qualites[1],
                                   $qualites[2],$qualites[3],$_SESSION['email']);
        if($erreur==0){
             //$erreur=envoimail($id);
        }
    }
}

// Dans le cas 2, il faut juste vérifier si l'utilisateur n'essaye pas d'accéder à une demande qui n'est pas une des siennes.
if($cas==2){
    $erreur=999;
	if(verificationGET($_GET['id'],$_SESSION['email'])!=0){
		session_unset();
		session_destroy();
		header('Location: Connexion.html');
	}
}

?>


<!DOCTYPE html>
<html>
<head>
    <title> Demande de référence - Jeunes 6.4</title>
    <?php
        // Quand on est dans le cas 2, il y a un / de plus dans l'URL, il faut le prendre en compte quand on écrit les chemins
        // vers les fichiers
    	if($cas==1){
    		echo "<link rel='stylesheet' type='text/css' href='Resume.css'";
    	}
    	else{
    		echo "<link rel='stylesheet' type='text/css' href='../Resume.css'>";
    	}
    ?>
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="nomargin">
    <div id="entete">
        <?php
        	if($cas==1){
    			echo "<a href='../Visiteur/Presentation.html'><img src='../Images/logo1.png' id='imageentete'></a>";
    		}
    		else{
    			echo "<a href='../../Visiteur/Presentation.html'><img src='../../Images/logo1.png' id='imageentete'></a>" ;
    		}
        ?>
        
        </a>
        <h1 id="titreentete1"> ESPACE JEUNE </h1>
    </div>

    <!--Div invisible en positionnement relatif pour remplir la place que prendrait normalement l'entête sans 
    positionnement absolu.-->
    <!--Cela pour ne pas que le corps et l'entête se chevauchent.-->
    <div id="invisible"> </div>

    <!-- Div qui sert au PHP à relayer des messages à l'utilisateur-->
    <div id="annonceur"> 
        <?php
            // En fonction de la valeur de $erreur, un message différent est envoyé.
            switch($erreur){
                case 0:
                    echo "<p class='vert'>Votre demande de référence a bien été prise en compte.</p>";
                    break;
                case 1:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Nous avons eu un problème avec la base de données. </p>";
                    break;
                case 9:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Vous n'avez séléctionné aucune qualité sur le questionnaire. </p>";
                    break;
                case 10:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Vous avez sélectionné trop de qualités sur le questionnaire. </p>";
                    break;
                case 100:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Nous n'avons pas pu envoyer la demande à votre référent. </p>";
                    break;
                case 105:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Nous n'avons pas pu envoyer la demande à votre référent. </p>";
                    break;
                default:
                    echo "";
                    break;
            }
        ?>
    </div>

    <!--Une div qui sert à afficher la demande de référence.-->
    <div id="recapitulatif">
        <p id="titre"> Votre demande de référence : </p>
        <?php
            // En fonction du cas, on affiche avec un paramètre différent 
            if($cas==1){
                affichedemande($id);
                echo "</br>";
            }
            else if($cas==2){
                affichedemande($_GET['id']);
            }
            else{
                echo "<p>La demande de référence n'a pas pu être chargée.</p>";
            }
        ?>
    </div>
    <div id=divlien> <a id="lien"
    <?php
    	if($cas==1){
    		echo "href='CompteJeune.php'";
    	}
    	else{
    		echo "href='../CompteJeune.php'";
    	}
    ?>
    > Retour à votre espace</a> </div>

</body>
</html>

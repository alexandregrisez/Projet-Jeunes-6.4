<?php
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

/*
Cette fonction prend un id de demande de référence et renvoie l'email du jeune associé dans le fichier de données.
Elle renvoie 2 si l'email n'est pas trouvé.
*/
function rechercheemail($id){
    $database=fopen("demandes.txt","r+");
	if(!$database){
		return 2;
	}
    $buffer="123";
    $tab=[];
	// Parcours du fichier de données, si l'email de la demande correspond, on ajoute la demande au grand tableau
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[1])){
                if($id==$tab[1]){
					fclose($database);
                    return $tab[0];
                }
            }
        }
    }
    
    fclose($database);
	return 2;
}

/*
Cette fonction prend un email de jeune en paramètre et renvoie le nom du jeune associé à cet email dans le fichier de données.
Elle renvoie 0 si le nom n'est pas trouvé.
*/
function recherchenom($email){
	// Ouverture du fichier de données et vérification.
    $database=fopen("comptes.txt","r");
    if(!$database){
        return 0;
    }
    // Initialisation des variables de parcours.
    $buffer="123";
    $tab=[];
    // Quand fgets est à la fin du fichier ou produit une erreur, elle renvoie false, ce qui sert ici pour la boucle.
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[3])){
                // $tab[3] est l'email de la ligne
                if($email==$tab[3]){
					fclose($database);
                    return $tab[0];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

/*
Cette fonction prend un email de jeune en paramètre et renvoie le prénom du jeune associé à cet email dans le fichier de données.
Elle renvoie 0 si le prénom n'est pas trouvé.
*/
function rechercheprenom($email){
	// Ouverture du fichier de données et vérification.
    $database=fopen("comptes.txt","r");
    if(!$database){
        return 0;
    }
    // Initialisation des variables de parcours.
    $buffer="123";
    $tab=[];
    // Quand fgets est à la fin du fichier ou produit une erreur, elle renvoie false, ce qui sert ici pour la boucle.
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[3])){
                // $tab[3] est l'email de la ligne
                if($email==$tab[3]){
					fclose($database);
                    return $tab[1];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

/*
Cette fonction prend un email de jeune en paramètre et renvoie la date de naissance du jeune associé à cet email dans le fichier de données.
Elle renvoie 0 si la date de naissance n'est pas trouvée.
*/
function rechercheddn($email){
	// Ouverture du fichier de données et vérification.
    $database=fopen("comptes.txt","r");
    if(!$database){
        return 0;
    }
    // Initialisation des variables de parcours.
    $buffer="123";
    $tab=[];
    // Quand fgets est à la fin du fichier ou produit une erreur, elle renvoie false, ce qui sert ici pour la boucle.
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[3])){
                // $tab[3] est l'email de la ligne
                if($email==$tab[3]){
					fclose($database);
                    return $tab[2];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

/*
Cette fonction prend un id de demande de référence et renvoie toute la demande associée dans le fichier de données.
Elle renvoie 2 si l'email n'est pas trouvé.
*/
function recherchedemande($id){
    $database=fopen("demandes.txt","r+");
	if(!$database){
		return 2;
	}
    $buffer="123";
    $tab=[];
	// Parcours du fichier de données, si l'email de la demande correspond, on ajoute la demande au grand tableau
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[1])){
                if($id==$tab[1]){
				    fclose($database);
                    return $tab;
                }
            }
        }
    }
    
    fclose($database);
	return 2;
}

/*
Cette fonction prend en paramètre une liste d'IDs séparés par des virgules et finissant par 'fin' et génère un document
contenant les demandes de références correspondantes ainsi que le profil du jeune associé.
*/
// A besoin de l'extension GD
function pdf($liste){
	$ids=explode(',',$liste);

	// Obtention des informations personnelles du jeune
	$emailjeune=rechercheemail($ids[0]);
	$nomjeune=recherchenom($emailjeune);
	$prenomjeune=rechercheprenom($emailjeune);
	$ddnjeune=rechercheddn($emailjeune);
	
	// Obtention du tableau des demandes
	$i=0;
	$DEMANDES=[];
	while($ids[$i]!='fin'){
		$DEMANDES[$i]=recherchedemande($ids[$i]);
		$i++;
	}

	// Ces lignes rendent l'affichage d'une image plus simple.
	$options=new Options();
	$options->set('isRemoteEnabled',true);
	$dompdf=new Dompdf($options);
	$dompdf->getOptions()->setChroot($_SERVER['DOCUMENT_ROOT']);
	$HTML="";
	// Style du document
	$HTML.=
	"<html>

    <head>
    <style type='text/css'>
			#entete{
				position:relative;
			}
			#image{
				width:250px;
				height:155px;
				float:right;
			}
            #corps{
					font-family: DejaVu Sans,Helvetica;
					position:relative;
					border: 5px solid #e60080;
            }
			#titre{
				text-align:center;
				color : black;
				font-size:16pt;
				text-decoration:underline;
			}
			#infosjeune{
				margin-left:20px;
				position:relative;
				width:50%;
				color: black;
			}
			#trait{
				position:relative;
				height:1px;
				width:90%;
				left:5%;
				right:5%;
				border: solid 4px #e60080;
			}
			#references{
				font-size: 10pt;
				position:relative;
				margin-left:10px;
			}
			.reference{
				overflow-wrap: break-word;
				position:relative;
			}
			.souligne{
				text-decoration:underline;
			}
			.rose{
				color:#e60080;
			}
    </style>
    </head>
	<body>";

	// Entête + texte introductif
	$HTML.=
	"<div id='corps'>
	 	<div id='entete'> 
	 		<p id='titre'> Fiche JEUNES 6.4 </p>
	 		<img id='image' src='".$_SERVER['DOCUMENT_ROOT']."/Images/logo1.png'>
	 	</div>
		<div id='infosjeune'>
			<p> Nom : {$nomjeune}</p>
			<p> Prénom : {$prenomjeune}</p>
			<p> Né(e) le : {$ddnjeune}</p>
			<p> Contact : {$emailjeune}</p>
			<br>
		</div>
		<div id='trait'> </div>
		<br>
		<div id='references'>";


	for($i=0;$i<count($DEMANDES);$i++){
		$HTML.="
			   <div class='reference'>
					<p> L'engagement de <b class='rose'>{$prenomjeune}</b> a été validé dans le domaine suivant : {$DEMANDES[$i][6]} </p>
					<p> <b class='souligne'>Référent :</b> {$DEMANDES[$i][7]} {$DEMANDES[$i][8]} - {$DEMANDES[$i][10]} </p>
					<p> <b class='souligne'>Contact référent :</b> {$DEMANDES[$i][9]} </p>
					<p> <b class='souligne'>Description de l'engagement :</b> {$DEMANDES[$i][3]} </p>
					<p> <b class='souligne'>Savoirs-être démontrés :</b> {$DEMANDES[$i][11]} </p>
					<p> <b class='souligne'>Commentaire du référent :</b> {$DEMANDES[$i][12]}  </p>
			   </div><br>  ";
	}


	$HTML.="
		</div>
		<p> À très bientôt sur JEUNES 6.4 !</p>
     </div>
	 </body>
	 </html>";

	// Génération du PDF
	$dompdf->loadHtml($HTML);
	$dompdf->render();
	$dompdf->stream();
	return 0;
}
/*
Cette fonction renvoie un tableau de tableaux correspondant à toutes les demandes validées pour l'utilisateur à l'email $email.
Elle renvoie un tableau vide si un problème survient où si l'utilisateur n'a pas encore de demandes valides.
*/
function demandes_validees($email){
    if(!(file_exists("demandes.txt"))){
		return [];
	}
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
if(count($_POST)!=0){
    // Ici, le traitement consiste à générer le document demandé.
    // Il faut d'abord la liste des IDs des demandes sélectionnées par le jeune
	$liste="";
    // On parcourt $_POST pour les avoir (chaque case qui était à cocher avait pour nom "demande"+son ID)
    // Les valeurs des cases à cocher sont inutiles, elles valent toutes 'on', il faut le nom d'origine contenu dans $cle
	foreach($_POST as $cle => $valeur){
        // On enlève le "demande" du nom "demande"+id pour avoir l'ID et on le rajoute à la liste avec une virgule
		$id=substr($cle,7);
		$liste.=$id.',';
	}
    // Si l'utilisateur n'a pas sélectionné de demandes, erreur n°5.
	if($liste==""){
		$erreur=5;
	}
    // On finit la liste de manière repérable
	$liste.='fin';

    // Si pas d'erreur on essaye de créer le PDF.
    if($erreur==-1){
        $erreur=pdf($liste);
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
		<p id="titre"> Inclusion de vos références au format PDF :</p>
		<p> JEUNES 6.4 vous permet d'inclure des références sur un document PDF afin de compléter votre
			CV. Sélectionnez les références à inclure et cliquez sur "Générer" pour disposer d'un document
			formatté immédiatement !
		</p>
        </hr>

        <!-- Div qui sert au PHP à relayer des messages à l'utilisateur-->
		<div id="annonceur"> 
			<?php
                // En fonction de la valeur de $erreur, un message différent est envoyé.
				switch($erreur){
					case 0:
						echo "<p class='vert'>Le document a bien été généré.</p>";
						break;
					case 5:
						echo "<p class='rouge'>Erreur : Vous n'avez sélectionné aucune référence.</p>";
						break;
					case 100:
						echo "<p class='rouge'>Erreur : Nous n'avons pas pu générer le document.</p>";
						break;
					case 105:
						echo "<p class='rouge'>Erreur : Nous n'avons pas pu générer le document.</p>";
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
		<form method='post' action='GenerationPDF.php'>
			<p id="txt2"> Veuillez sélectionner les références à inclure sur le document : </p>
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
			<input type="submit" id="boutonformulaire" value="Générer">
		</form>
		<div id=divlien> <a id="lien" href="CompteJeune.php"> Retour </a> </div>
	</div>
	</br>
	</br>
</body>
</html>

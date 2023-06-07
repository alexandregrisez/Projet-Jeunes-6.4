<?php

function rechercheemail($id){
    $database=fopen("../Jeune/demandes.txt","r+");
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
    $database=fopen("../Jeune/comptes.txt","r");
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
    $database=fopen("../Jeune/comptes.txt","r");
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
    $database=fopen("../Jeune/comptes.txt","r");
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

function recherchedemande($id){
    $database=fopen("../Jeune/demandes.txt","r+");
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

function references($liste){
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

	$HTML="";
	$HTML.="
        <p class='bleu'> <b>Voici le profil du jeune qui vous a contacté :</b> </p>
		<div id='infosjeune'>
			<p> <b class='souligne'> Nom</b> : {$nomjeune}</p>
			<p><b class='souligne'> Prénom</b> : {$prenomjeune}</p>
			<p><b class='souligne'> Né(e) le</b> : {$ddnjeune}</p>
			<p><b class='souligne'> Contact</b> : {$emailjeune}</p>
			<br>
		</div>
		<br>
		<div id='references'>
        <p class='bleu'><b> Voici la liste de ses références :</b> </p>";


	for($i=0;$i<count($DEMANDES);$i++){
		$HTML.="
			   <div class='reference'>
					<p> L'engagement de <b class='rose'>{$prenomjeune}</b> a été validé dans le domaine suivant : {$DEMANDES[$i][6]} </p>
					<p> <b class='souligne'>Référent</b> : {$DEMANDES[$i][7]} {$DEMANDES[$i][8]} - {$DEMANDES[$i][10]} </p>
					<p> <b class='souligne'>Contact référent</b> : {$DEMANDES[$i][9]} </p>
					<p> <b class='souligne'>Description de l'engagement</b> : {$DEMANDES[$i][3]} </p>
					<p> <b class='souligne'>Savoirs-être démontrés</b> : {$DEMANDES[$i][11]} </p>
					<p> <b class='souligne'>Commentaire du référent</b> : {$DEMANDES[$i][12]}  </p>
			   </div><br>  ";
	}


	$HTML.="
		</div>
	 </body>
	 </html>";
	echo $HTML;
	return 0;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title> Votre Espace - Jeunes 6.4</title>
    <link rel="stylesheet" href="../ResumeConsultant.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>
	<!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../../Visiteur/Presentation.html"> <img src="../../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> CONSULTANT </h1>
    </div>

    <!--Div invisible en positionnement relatif pour remplir la place que prendrait normalement l'entête sans 
    positionnement absolu.-->
    <!--Cela pour ne pas que le corps et l'entête se chevauchent.-->
    <div id=invisible></div>


	<div id="corps">
        <div id='intro'>
            <br>
            <p> Bienvenue sur JEUNES 6.4 !</p> 
            <p> JEUNES 6.4 permet aux recruteurs d'accéder à des profils de jeunes certifiés en recherche d'emploi. Les références sont validées personnellement par les experts de leur domaine. </p>
            <p> Vous n'avez rien à faire ! Il vous suffit de recevoir les références d'un des jeunes concernés par mail. Ni compte à créér, ni procédure particulère ne sont nécéssaires pour utiliser nos services. </p>
            <p> Un jeune vient d'utiliser notre plateforme pour vous envoyer un message. Il souhaite que vous jettiez un oeil à ses qualifications pour possiblement les prendre en compte dans un recrutement.</p>
            <p> Toutes les informations sont affichées ci-dessous !</p>
        </div>
		<?php
            $liste=$_GET['list_id'];
            if(isset($liste)){
                references($liste);
            }
            else{
                echo "<p> Une erreur est survenue. Veuillez réessayer.</p>";
            }
        ?>
	</div>
	</br>
	</br>
</body>
</html>

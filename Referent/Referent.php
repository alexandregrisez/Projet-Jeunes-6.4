<?php

function recherchenom0($email){
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
                    return $tab[0];
                }
            }   
        }
    }
    fclose($database);
    return "Compte non trouvé";
}

function rechercheprenom0($email){
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
                    return $tab[1];
                }
            }   
        }
    }
    fclose($database);
    return "/";
}

function rechercheddn0($email){
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
                    return $tab[2];
                }
            }   
        }
    }
    fclose($database);
    return "/";
}

function info_jeune($id){
	$database=fopen("demande_reference.txt","r+");
	$buffer="123";
	$tab=[];
	while($buffer!=false){
    	$buffer=fgets($database);
   	 	if($buffer!=false){
      		  // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
       		 $tab=explode(",",$buffer);
        	// Une condition en plus pour la sécurité.
       		 // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
       		 if(isset($tab[1])){
         	   // $tab[3] est l'email de la ligne
         	 	if($id==$tab[1]){
                   	$mail=$tab[0];
                    $TAB=[];
                   	$TAB[0]=recherchenom0($mail);
                    $TAB[1]=rechercheprenom0($mail);
                    $TAB[2]=rechercheddn0($mail);
                    fclose($database);
                    return $TAB;
                }
        	}   
    	}
	}
}

function recherche_ref($id){
    $database=fopen("demande_reference.txt","r+");
    $buffer="123";
    $tab=[];
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[1])){
                // $tab[3] est l'email de la ligne
                if($id==$tab[1]){
                    // Vérification du mot de passe
                    // On ajoute le saut de ligne à la fin de $mdp car 
                    // explode ne l'a pas enlevé automatiquement de $tab[4]
                    if($tab[1]==$id){
                        return $tab;
                    }
            	}   
        	}
    	}
    }
    fclose($database);
}

?>

<!DOCTYPE html>
<!--HTML DE LA PAGE REFERENT DU MODULE VISITEUR-->
<html>
<head>
    <title> Accueil - Jeunes 6.4</title>
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8"  name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="nomargin">

    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="Presentation.html"> <img src="Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> RÉFÉRENT </h1>
        <p id="titreentete2"> Je confirme la valeur de ton engagement </p>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <!--Le fond de la page est la version "référent" du logo de JEUNES 6.4-->
        <img id="fond" src="Images/logo3.JPG">
        
        <div id="texte">
            <p> Avec JEUNES 6.4, vous pouvez désormais référencer les jeunes avec qui vous avez collaboré et attester leurs compétences. Ils profiteront de cette certification dans leur recherche d'emploi.</p>
            <p> Vous n'avez rien à faire ! Il vous suffit de recevoir une demande de certification par mail d'un des jeunes concernés et vous devrez seulement remplir le formulaire attestant témoignant de ses compétences. Ni compte à créér, ni procédure particulère ne sont nécéssaires pour utiliser nos services. </p>
            <p> Nos ingénieurs spécialisés dans la création de sites web ont travaillé d'arrache-pied pour que l'utilisation de JEUNES 6.4 soit la plus simple pour vous, alors n'attendez plus !</p>
            <p id="special"> <b>Commencez dès maintenant à valider l'expérience des jeunes de votre entourage !</b> </p>
        </div>
    </div>

    <div id=affichage_php>
        <?php
        $demande_reference=recherche_ref("100");
        $info_jeune=info_jeune("100");
		?>
        <div id=infos_jeune>
			<?php
            echo "<p>Voici les infos du Jeune qui vous demande des références\n
            nom:$info_jeune[0]\n
            prenom:$info_jeune[1]\n
            date de naissance:$info_jeune[2]\n
            mail:$demande_reference[0]\n
            </p>";
			?>
        </div>
        <div id=demande_reference>
			<?php
            echo "<p>Voici la demande de référence\n
            description: $demande_reference[3]\n
            date début:$demande_reference[4]\n
            date fin:$demande_reference[5]\n
            domaine engagement:$demande_reference[6]\n 
            </p>";
			?>
        </div>
        <div id=infos_referent>
			<?php
            echo "<p>Voici vos informations personnelles\n
            nom:$demande_reference[7]\n
            prenom:$demande_reference[8]\n
            mail:$demande_reference[9]\n
            metier:$demande_reference[10]\n
            </p>";
			?>
        </div>
    </div>
</body>
</html>

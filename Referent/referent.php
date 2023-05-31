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
	$database=fopen("demandes.txt","r+");
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
    fclose($database);
}

function recherche_ref($id){
    $database=fopen("demandes.txt","r+");
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
                // $tab[1] est l'id de la ligne
                if($id==$tab[1]){
                        return $tab;
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
    <!--<link rel="stylesheet" href="referent.css">-->
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

      <!--Le menu est une bande divisée en 4 parties égales (les "quarts" ci-dessous) qui contiennent chacune un lien.-->
    <div id="menu">
        <div id="quart1" > <a href="Jeune.html" id="lien1"> JEUNE </a> </div>
        <div id="quart2" > <a href="Referent.html" id="lien2"> RÉFÉRENT </a></div>
        <div id="quart3" > <a href="Consultant.html" id="lien3"> CONSULTANT </a></div>
        <div id="quart4" > <a href="Partenaires.html" id="lien4"> PARTENAIRES </a> </div>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <!--Le fond de la page est la version "référent" du logo de JEUNES 6.4-->
        <img id="fond" src="Images/logo3.JPG">
        
        <div id="texte">
            <p>Confirmez cette expérience et ce que vous avez pu constater au contact de ce jeune</p>
        </div>
    </div>

    <div id=affichage_php>
        <?php
        $demande_reference=recherche_ref(2);
        $info_jeune=info_jeune(2);
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

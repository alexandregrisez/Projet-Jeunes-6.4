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
    <link rel="stylesheet" href="referent.css">
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
        <p>Confirmez cette expérience et ce que vous avez pu constater au contact de ce jeune</p>

        <div id=comm>
            <p>COMMENTAIRES</p>
        </div>

        <div id=savoirs>
            <p>SAVOIRS-ETRES</p>
        </div>

        <a href=modifref.php><button type="button" id="bouton1">Voir vos informations personnelles</button>

        <div id=affichage_php>
            <?php
            $demande_reference=recherche_ref(2);
            $info_jeune=info_jeune(2);
		    ?>
            <div id=infos>
			    <?php
                echo "<p>
                NOM:    $info_jeune[0]<br>
                PRENOM: $info_jeune[1]<br>
                DATE DE NAISSANCE:  $info_jeune[2]<br>
                MAIL:   $demande_reference[0]<br>
                <br>
                DESCRIPTION:    $demande_reference[3]<br>
                DATE DE DEBUT:  $demande_reference[4]<br>
                DATE DE FIN:    $demande_reference[5]<br>
                DOMAINE D'ENGAGEMENT:   $demande_reference[6]<br>
                </p>";
			    ?>
            </div>
            <div id=infos_referent>
			    <!--<?php
                echo "<p>Voici vos informations personnelles<br>
                <br>
                NOM:$demande_reference[7]<br>
                PRENOM:$demande_reference[8]<br>
                MAIL:$demande_reference[9]<br>
                METIER:$demande_reference[10]<br>
                </p>"
			    ?>
            </div>
        </div>    
    </div>
</div>
</body>
</html>

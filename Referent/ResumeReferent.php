<?php

function verifstatut($id){
    $database=fopen("../Jeune/demandes.txt","r+");
    if(!$database){
        return 300;
    }
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
                if($id==$tab[1]){
                    fclose($database);
                    if($tab[2]==0){
                        return 123;
                    }
                    else{
                        return 0;
                    } 
                }  
        	}
    	}
    }
    fclose($database);
    return 122;
}

function creation_savoiretre($id){
    $database=fopen("../Jeune/demandes.txt","r");
    if(!$database){
        return 0;
    }
    $buffer="123";
    $tab=[];
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            // Séparation de chaque ligne en plusieurs morceaux grâce aux virgules.
            $tab=explode(",",$buffer);
            // Une condition en plus pour la sécurité.
            // Il peut arriver que buffer soit vide s'il y a une ligne vide dans le fichier de données.
            if(isset($tab[11])){
                if($id==$tab[1]){
                    $quals=explode(';',$tab[11]);
                    break;
                }  
        	}
    	}
    }
    fclose($database);
    if(!isset($quals)){
        return 2;
    }
    for($i=0;$i<count($quals);$i++){
        echo "<input type='checkbox' id='qualite{$i}' name='qualite{$i}'>
              <label for='qualite{$i}'>{$quals[$i]}</label> </br>";
    }
    for($i=0;$i<count($quals);$i++){
        echo "<input type='hidden' id='nomqualite{$i}' name='nomqualite{$i}' value='{$quals[$i]}'>";
    }
    echo "<input type='hidden' id='id' name='id' value='{$id}'>";
    return 0;
}

function recherchenom0($email){
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
    return "/";
}

function info_jeune($id){
	$database=fopen("../Jeune/demandes.txt","r+");
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
                   	$email=$tab[0];
                    $TAB=[];
                   	$TAB[0]=recherchenom0($email);
                    $TAB[1]=rechercheprenom0($email);
                    $TAB[2]=rechercheddn0($email);
                    fclose($database);
                    return $TAB;
                }
        	}   
    	}
	}
    fclose($database);
}

function recherche_ref($id){
    $database=fopen("../Jeune/demandes.txt","r+");
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
                    fclose($database);
                    return $tab;
            	}   
        	}
    	}
    }
    fclose($database);
}
$erreur=-1;

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $erreur=verifstatut($id);
}
else{
    $erreur=500;
}

?>

<!DOCTYPE html>
<!--HTML DE LA PAGE REFERENT DU MODULE VISITEUR-->
<html>
<head>
    <title> Référent - Jeunes 6.4</title>
    <?php
    if(isset($_GET['id'])){
        echo "<link rel='stylesheet' href='../ResumeReferent.css'>";
    }
    else{
        echo "<link rel='stylesheet' href='ResumeReferent.css'>";
    }
    ?>
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8"  name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="nomargin">

    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <?php
        if(isset($_GET['id'])){
            echo "<a href='../../Visiteur/Presentation.html'> <img src='../../Images/logo1.png' id='imageentete'> </a>";
        }
        else{
            echo "<a href='../Visiteur/Presentation.html'> <img src='../Images/logo1.png' id='imageentete'> </a>";
        }
        ?>
        <h1 id="titreentete1"> RÉFÉRENT </h1>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <div id=affichage_php>
            <?php
            if($erreur==0){
                $demande_reference=recherche_ref($id);
                $info_jeune=info_jeune($id);
                echo "<div id='infos'><p>
                NOM:    $info_jeune[0]<br>
                PRENOM: $info_jeune[1]<br>
                DATE DE NAISSANCE:  $info_jeune[2]<br>
                MAIL:   $demande_reference[0]<br>
                <br>
                DESCRIPTION:    $demande_reference[3]<br>
                DATE DE DEBUT:  $demande_reference[4]<br>
                DATE DE FIN:    $demande_reference[5]<br>
                DOMAINE D'ENGAGEMENT:   $demande_reference[6]<br>
                </p></div>";
            }
            else{
                echo "<p class='rouge'>Une erreur est survenue. Veuillez réessayer. </p>";
            }
		    ?>
        </div> 

        <p>Confirmez l'expérience et ce que vous avez pu constater au contact de ce jeune</p>

        <div id="formulaire">
            <form method='post' action='../PageDeConfirmation.php'>
            <label for="comm"><br><br><br>COMMENTAIRE:<br><br><br></label>
            <input type="text" id="comm" name="comm" required><br><br>
            <input type="submit" id="boutonformulaire" value="Valider la demande de référence">
            <div id=savoirs>
                <p>SAVOIRS ÊTRE :</p>
                <?php
                    if(isset($_GET['id'])){
                        creation_savoiretre($id);
                    }
                ?>
                </div>
            </form>
        </div>

        <?php
        if(isset($_GET['id'])){
            if($erreur==0){
                echo "<a href='../ModificationProfilReferent.php/?id={$id}'><button type='button' id='bouton1'>Modifiez vos informations personnelles</button>";
            }
        }
        
        ?>
    </div>
</div>
</body>
</html>

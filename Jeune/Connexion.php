<?php
 session_start();
/*
Une fonction qui permet de vérifier si un couple e-mail / mot de passe est correct.
Elle prend les deux en paramètre.
Renvoie 1 s'il est correct, 0 sinon.
*/
function veriflogin($email,$mdp){
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
                    // Vérification du mot de passe
                    // On ajoute le saut de ligne à la fin de $mdp car 
                    // explode ne l'a pas enlevé automatiquement de $tab[4]
                    if($tab[4]==$mdp."\n"){
                        fclose($database);
                        return 1;
                    }
                    else{
                        fclose($database);
                        return 0;
                    }
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

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
                    return $tab[0];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

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
                    return $tab[1];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

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
                    return $tab[2];
                }
            }   
        }
    }
    fclose($database);
    return 0;
}

$erreur=0;

if(isset($_GET['deco'])){
	session_unset();
	session_destroy();
	header('Location: ../Connexion.html');
}

// Les variables du formulaire
if(isset($_POST['email']) && isset($_POST['mdp'])){
    $email=$_POST['email'];
    $mdp=$_POST['mdp'];
}


// Si l'utilisateur a réussi sa connexion, on initialise une session et on l'envoie sur son espace avec header
if(veriflogin($email,$mdp)==1){
	$_SESSION['derniereconnexion']=time();
    $_SESSION['email']=$email;
    $_SESSION['nom']=recherchenom($email);
    $_SESSION['prenom']=rechercheprenom($email);
    $_SESSION['ddn']=rechercheddn($email);
    header('Location: CompteJeune.php');
}
else{
    $erreur=1;
}

if(isset($_SESSION['erreur'])){
    if($_SESSION['erreur']==2){
        $erreur=2;
    }
    else if($_SESSION['erreur']==3){
        session_unset();
		session_destroy();
        $erreur=3;
    }
}
?>


<!DOCTYPE html>
<!--HTML DE LA PAGE JEUNE DU MODULE VISITEUR-->
<html>
<head>
    <title> Connexion - Jeunes 6.4</title>
    <link rel="stylesheet" href="Connexion.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="nomargin">
    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> JEUNE </h1>
        <p id="titreentete2"> Je donne de la valeur à mon engagement </p>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <!--Le fond de la page est la version "jeune" du logo de JEUNES 6.4-->
        <img id="fond" src="../Images/logo2.JPG">

        <!--La zone du formulaire de connexion-->
        <div id="login">
            <h2 id="titre"> Accéder à son espace Jeune </h2>
            <form action="Connexion.php" method="post">
                <label for="email">Adresse e-mail : </label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="mdp">Mot de passe : </label>
                <input type="password" id="mdp" name="mdp" required><br><br>
                <input type="submit" id="boutonformulaire" value="Connexion">
            </form>
        </div>

        <!--La zone de l'annonceur, utilisée pour transmettre des messages via PHP-->
        <div id="annonceur"> 
            <?php
                if($erreur==2){
                    echo "<p>Veuillez vous connecter pour accéder à votre espace.</p>";
                }
                else if($erreur==3){
                    echo "<p>Votre session a expiré, veuillez vous reconnecter.</p>";
                }
                else{
                    echo "<p>L'adresse e-mail ou mot de passe est incorrect.</p>";
                }
                
            ?>
        </div>
    </div>


</body>
</html>

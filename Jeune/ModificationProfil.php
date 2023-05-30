<?php
/*
Cette page permet au jeune de modifier son profil.
*/

/*
Cette fonction prend un email en paramètre et renvoie 1 si l'email existe dans le fichier des comptes utilisateurs et 0 sinon
*/
function recherchecompte($mail){
    // Vérification de l'existence du fichier de données
    if(file_exists("comptes.txt")==false){
        return 0;
    }
    else{
        $database=fopen("comptes.txt","r");
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
                    if($mail==$tab[3]){
                        fclose($database);
                        return 1;
                    }
                }   
            }
        }
        fclose($database);
        return 0;
    }
}

/*
Cette fonction modifie le compte jeune associé à $email en remplaçant les champs par $nom,$prenom,$ddn,$nvemail
Elle renvoie 0 s'il n'y a pas de problème lors de l'exécution, un autre entier sinon
*/
function modifcompte($email,$nom,$prenom,$ddn,$nvemail){
    // La procédure est de copier entièrement le fichier comptes.txt, sauf sur la ligne à modifier qui est remplacée par 
    // la nouvelle version du compte
    $database=fopen("comptes.txt","r");
    // Un fichier temporaire est créé
    $temp=fopen("temp.txt","w");
    if((!$database) || (!$temp)){
        return 1;
    }
    $buffer="123";
    $tab=[];
    $ok=-1;
    // Le parcours du fichier est le même que précédemment
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[3])){
                // SI l'email correspond, on réécrit la ligne du compte du jeune.
                if($email==$tab[3]){
                    $ok=0;
                    $mdp=$tab[4];
                    // ok = 1 si il y a un problème avec l'écriture
                    if(fwrite($temp,$nom.",".$prenom.",".$ddn.",".$nvemail.",".$mdp."\n")==false){
                        $ok=1;
                    }
                }
                // Si l'email de la ligne ne correspond pas à celui du jeune qui modifie son compte, on copie la ligne dans temp
                else{
                    fputs($temp,$buffer);
                }
            }   
        }
    }
    fclose($database);
    fclose($temp);
    
    // Si pas de problème, temp devient le nouveau comptes.txt
    if($ok==0){
        unlink("comptes.txt");
        rename("temp.txt","comptes.txt");
        return 0;
    }
    // Sinon, on préserve toutes les informations en supprimant temp et en gardant comptes.txt
    else{
        unlink("temp.txt");
        return 1;
    }
}

/*
Lorsqu'un jeune modifie son email avec la modification du compte, ses demandes doivent continuer d'exister sur son nouveau
compte. Cette fonction assure cela.
Elle prend l'ancien ainsi que le nouveau emails du jeune
*/
function modifdemandes($email,$nvemail){
    // Même principe que la fonction précédente, mais sur le fichier des demandes
    $database=fopen("demandes.txt","r");
    $temp=fopen("temp.txt","w");
    if((!$database) || (!$temp)){
        return 1;
    }
    $buffer="123";
    $tab=[];
    $ok=0;
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[0])){
                if($email==$tab[0]){
                    if(fwrite($temp,$nvemail.",".$tab[1].",".$tab[2].",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8].",".$tab[9].",".$tab[10].",".$tab[11]."\n")==false){
                        $ok=1;
                    }
                }
                else{
                    fputs($temp,$buffer);
                }
            }   
        }
    }
    fclose($database);
    fclose($temp);
    
    if($ok==0){
        unlink("demandes.txt");
        rename("temp.txt","demandes.txt");
        return 0;
    }
    else{
        unlink("temp.txt");
        return 1;
    }
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

<?php
// Deux erreurs pour la modification de comptes.txt et celle de demandes.txt
$erreur=-1;
$erreur2=-1;

// Si l'utilisateur a envoyé le formulaire, traitement des informations.
if(isset($_POST['nom'])){

    // Cas où l'utilisateur change son email pour un qui existe déjà dans la base de données
    if( ($_SESSION['email']!=$_POST['email']) && (recherchecompte($_POST['email'])==1)){
        $erreur=5;
    }

    // Il ne faut pas de virgules dans les champs, comme c'est notre séparateur dans le code 
    // On aurait pu choisir un séparateur moins commun
    if(strpos($_POST['nom'],',')!=false || strpos($_POST['prenom'],',')!=false){
        $erreur=6;
    }

    // Si pas d'erreur, on fait les deux modifications.
    if($erreur==-1){
        $erreur=modifcompte($_SESSION['email'],$_POST['nom'],$_POST['prenom'],$_POST['ddn'],$_POST['email']);
        $erreur2=modifdemandes($_SESSION['email'],$_POST['email']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Votre Espace - Jeunes 6.4</title>
    <link rel="stylesheet" href="ModificationProfil.css">
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
        <p id="titre"> Modification de votre profil :</p>
        <p> <b>Veuillez saisir vos données personnelles : </b></p>
		<div id="formulaire">
            <form method='post' action='ModificationProfil.php'>
                <label for="nom">Nom : </label>
                <input type="text" id="nom" name="nom" required><br><br>
                <label for="prenom">Prénom : </label>
                <input type="text" id="prenom" name="prenom" required><br><br>
                <label for="ddn">Date de naissance : </label>
                <input type="date" id="ddn" name="ddn" required><br><br>
                <label for="email">Adresse e-mail : </label>
                <input type="email" id="email" name="email" required><br><br>
                <input type="submit" id="boutonformulaire" value="Valider">
            </form>
		</div>

        <!-- Div qui sert au PHP à relayer des messages à l'utilisateur-->
        <div id=annonceur>
            <?php
                // En fonction de la valeur de $erreur/$erreur2, un message différent est envoyé.
                // Il vaut mieux que l'utilisateur se reconnecte après une modification de son compte.
                if($erreur==0 && $erreur2==0){
                    echo "<p class='vert'> Votre profil a bien été modifié.</p>";
                    echo "<p class='vert'> Vous allez devoir vous reconnecter.</p>";
					session_unset();
                	session_destroy();
                }
                else if($erreur==-1){
                    echo "";
                }
                else if($erreur==6){
                    echo "<p id='rouge'> Veuillez ne pas utiliser de caractères spéciaux.</p>";
                }
                else if($erreur==5){
                    echo "<p id='rouge'> Un compte avec cette adresse mail existe déjà.</p>";
                }
                else{
                    echo "<p id='rouge'> Une erreur est survenue, veuillez réessayer.</p>";
                }
            ?>
        </div>

        <div id=divlien> <a id="lien" href="Connexion.html"> Reconnexion </a> </div>
    </div>
	
	
	
</body>
</html>

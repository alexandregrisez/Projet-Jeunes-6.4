<?php

function modifdemande($email,$nom,$prenom,$metier,$nvemail){
	$temp=fopen("temp.txt","w+");
    if(file_exists("demandes.txt")==false){
        return 0;
    }
    if(file_exists("temp.txt")==false){
        return 30;
    }
    $database=fopen("demandes.txt","r+");
    if((!$database) || (!$temp)){
        return 2;
    }
    $buffer="123";
    $tab=[];
    $ok=-1;
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[9])){
                if($email==$tab[9]){
                    $ok=0;
                    $mdp=$tab[4];
                    if(fwrite($temp,tab[0].",".tab[1].",".tab[2].",".tab[3].",".tab[4].",".tab[6].",".$nom.",".$prenom.",".$nvemail.",".$metier.",".tab[11]."\n")==false){
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
        return 29;
    }
}
/**session_start();
if(!(isset($_SESSION['derniereconnexion']))){
	$_SESSION['erreur']=2;
	header('Location: Connexion.php');
}

if(isset($_SESSION['derniereconnexion']) && time() - $_SESSION['derniereconnexion'] > 1200){
		$_SESSION['erreur']=3;
		header('Location: Connexion.php');
}
?>**/

$erreur=modifdemande($email,$nom,$prenom,$metier,$nvemail);


/**if(isset($_POST['nom'])){
    if( ($_SESSION['email']!=$_POST['email']) && (recherchecompte($_POST['email'])==1)){
        $erreur=5;
    }
    if(strpos($_POST['nom'],',')!=false || strpos($_POST['prenom'],',')!=false){
        $erreur=6;
    }
    if($erreur==-1){
        $erreur=modifcompte($_SESSION['email'],$_POST['nom'],$_POST['prenom'],$_POST['ddn'],$_POST['email']);
        $erreur2=modifdemandes($_SESSION['email'],$_POST['email']);
    }
}**/
?>

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
        <h1 id="titreentete1"> REFERENT </h1>
    </div>
    <div id=invisible></div>
	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">
        <p id="titre"> Modification de votre profil </p>
        <p> <b>Veuillez saisir vos données personnelles : </b></p>
		<div id="formulaire">
            <form method='post' action='modificationprofilref.php'>
                <label for="nom">Nom : </label>
                <input type="text" id="nom" name="nom" required><br><br>
                <label for="prenom">Prénom : </label>
                <input type="text" id="prenom" name="prenom" required><br><br>
                <label for="email">Adresse e-mail : </label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="metier">Metier : </label>
                <input type="metier" id="metier" name="metier" required><br><br>
                <input type="submit" id="boutonformulaire" value="Valider">
            </form>
		</div>

        <div id=annonceur>
            <?php
            echo $erreur;
                /**if($erreur==0){
                    echo "<p class='vert'> Votre profil a bien été modifié.</p>";
                    /**echo "<p class='vert'> Vous allez devoir vous reconnecter.</p>";
                    session_unset();
                    session_destroy();**/
            
                /**else if($erreur==-1){
                    echo "";
                }
                else if($erreur==6){
                    echo "<p id='rouge'> Veuillez ne pas utiliser de caractères spéciaux.</p>";
                }
                else if($erreur==5){
                    echo "<p id='rouge'> Un compte avec cette adresse mail existe déjà.</p>";
                }**/
                /**else{
                    echo "<p id='rouge'> Une erreur est survenue, veuillez réessayer.</p>";
                }**/
            ?>
        </div>

        <!--<div id=divlien> <a id="lien" href="Connexion.html"> Reconnexion </a> </div>
    </div>-->
	
	
	
</body>
</html>
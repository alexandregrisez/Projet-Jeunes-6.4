<?php

function modifdemande($id,$nom,$prenom,$email,$metier){
    if(file_exists("../ProjetFini/demandes.txt")==false){
        return 2;
    }
    $database=fopen("../ProjetFini/demandes.txt","r");
    $temp=fopen("temp.txt","w");
    if((!$temp)){
        return 3;
    }
    if((!$database)){
        return 5;
    }
    $buffer="123";
    $tab=[];
    $ok=-1;
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                if($id==$tab[1]){
                    $ok=0;
                    if(fwrite($temp,$tab[0].",".$tab[1].",".$tab[2].",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$nom.",".$prenom.",".$email.",".$metier.",".$tab[11].",".$tab[12]."\n")==false){ 
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
        unlink("../ProjetFini/demandes.txt");
        rename("temp.txt","../ProjetFini/demandes.txt");
        return 1;
    }
   else{
        unlink("temp.txt");
        return 500;
    }
}

if(isset($_POST['nom'])){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $email=$_POST['email'];
    $metier=$_POST ['metier'];
}
$erreur=-1;
$erreur=modifdemande(102,$nom,$prenom,$email,$metier);


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
    <link rel="stylesheet" href="">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>
	<!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> REFERENT </h1>
    </div>
    <?php echo "Erreur : {$erreur}"; ?>
    <div id=invisible></div>
	<div id="corps">
		<img id="fond" src="../Images/logo2.JPG">
        <p id="titre"> Modification de votre profil </p>
        <p> <b>Veuillez saisir vos données personnelles : </b></p>
		<div id="formulaire">
            <form method='post' action='ModificationProfilReferent.php'>
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

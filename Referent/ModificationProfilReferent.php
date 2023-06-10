<?php

function modifdemande($id,$nom,$prenom,$email,$metier){
    if(file_exists("../Jeune/demandes.txt")==false){
        return 2;
    }
    $database=fopen("../Jeune/demandes.txt","r");
    $temp=fopen("../Jeune/temp.txt","w");
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
        unlink("../Jeune/demandes.txt");
        rename("../Jeune/temp.txt","../Jeune/demandes.txt");
        return 0;
    }
   else{
        unlink("../Jeune/temp.txt");
        return 500;
    }
}


$erreur=-1;
if(isset($_GET['id'])){
    $id=$_GET['id'];
    if(isset($_POST['nom'])){
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $email=$_POST['email'];
        $metier=$_POST['metier'];
        if(strpos($_POST['nom'],',')!=false || strpos($_POST['prenom'],',')!=false){
            $erreur=6;
        }
        if($erreur==-1){
            $erreur=modifdemande($id,$nom,$prenom,$email,$metier);
        }  
    }
}
else{
    $erreur=333;
}



?>

<html>
<head>
    <title> Référent - Jeunes 6.4</title>
    <?php
    if(isset($_GET['id'])){
        echo "<link rel='stylesheet' href='../ModificationProfilReferent.css'>";
    }
    else{
        echo "<link rel='stylesheet' href='ModificationProfilReferent.css'>";
    }
    ?>
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class=nomargin>
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
        <h1 id="titreentete1"> REFERENT </h1>
    </div>
    <div id=invisible></div>
	<div id="corps">
        <p id="titre"> Modification de votre profil </p>
        <p> <b>Veuillez saisir vos données personnelles : </b></p>
		<div id="formulaire">
            <?php
            echo "<form method='post' action='../ModificationProfilReferent.php/?id={$id}'>";
            ?>
                <label for="nom">Nom : </label>
                <input type="text" id="nom" name="nom" required><br><br>
                <label for="prenom">Prénom : </label>
                <input type="text" id="prenom" name="prenom" required><br><br>
                <label for="email">Adresse e-mail : </label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="metier">Metier : </label>
                <input type="text" id="metier" name="metier" required><br><br>
                <input type="submit" id="boutonformulaire" value="Valider">
            </form>
		</div>

    </div>
	<div id=annonceur>
            <?php
                switch($erreur){
                    case -1:
                        echo "";                      
                        break;
                    case 0:
                        echo "<p class='vert'> Votre profil a bien été modifié.</p>";
                        echo "<a href='../ResumeReferent.php/?id={$id}' id='lien'> Retour à la demande de référence</a>";                        
                        break;
                    default:
                        echo "<p class='rouge'> Une erreur est survenue. Veuillez réessayer.</p>";
                        break;
                }
            ?>
    </div>
	
	
</body>
</html>

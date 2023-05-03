<?php

function veriflogin($email,$mdp){
    $database=fopen("comptes.txt","r");
    if(!$database){
        return 0;
    }
    $buffer="123";
    $tab=[];
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[3])){
                if($email==$tab[3]){
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

$erreur=0;
$email=$_POST['email'];
$mdp=$_POST['mdp'];


if(veriflogin($email,$mdp)==1){
    session_start()
    $_SESSION['email']=$email
    $_SESSION['nom']=recherchenom($email);
    $_SESSION['prenom']=rechercheprenom($email);
    $_SESSION['ddn']=rechercheddn($email);
    header('Location: MonCompte.php');
}
else{
    $erreur=1;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title> Connexion - Jeunes 6.4</title>
    <link rel="stylesheet" href="Connexion.css">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="nomargin">
    <div id="entete">
        <a href="Presentation.html"> <img src="Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> JEUNE </h1>
        <p id="titreentete2"> Je donne de la valeur à mon engagement </p>
    </div>

    <div id="corps">
        <img id="fond" src="Images/logo2.JPG">
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
        <div id="annonceur"> 
            <?php
                echo "<p>L'adresse e-mail ou mot de passe est incorrect.</p>";
            ?>
        </div>
    </div>


</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title> Inscription - Jeunes 6.4</title>
    <link rel="stylesheet" href="Inscription.css">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php

        function recherchecompte($mail){
            if(file_exists("comptes.txt")==false){
                return 0;
            }
            else{
                $database=fopen("comptes.txt","r");
                $buffer="123";
                $tab=[];
                while($buffer!=false){
                    $buffer=fgets($database);
                    if($buffer!=false){
                        $tab=explode(",",$buffer);
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
    ?>

</head>

<body class="nomargin">
    <?php
        if(file_exists("comptes.txt")==false){
            $temp=fopen("comptes.txt","w");
            fclose($temp);
        }

        $erreur=5;
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $ddn=$_POST['ddn'];
        $email=$_POST['email'];
        $mdp=$_POST['mdp'];

        if($nom=="" || $prenom=="" || $ddn=="" || $email=="" || $mdp==""){
            $erreur=3;
        }

        if(strpos($nom,',')!=false || strpos($prenom,',')!=false || strpos($email,',')!=false || strpos($mdp,',')!=false){
            $erreur=1;
        }

        if($erreur==5){
            if(recherchecompte($email)==0){
                $erreur=0;
                $database=fopen("comptes.txt","r+");
                if($database){
                    while(fgets($database)!=false){
                        $i=1;
                    }
                    if(fwrite($database,$nom.",".$prenom.",".$ddn.",".$email.",".$mdp."\n")==false){
                        $erreur=2;
                    }
                    fclose($database);
                }
                else{
                    $erreur=5;
                }
            }
            else{
                $erreur=4;
            }
        }
        


    ?>

<div id="entete">
        <a href="Presentation.html"> <img src="Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> JEUNE </h1>
        <p id="titreentete2"> Je donne de la valeur à mon engagement </p>
    </div>


    <div id="corps">
        <img id="fond" src="Images/logo2.JPG">
        <h1 id="titre"> Création de votre compte Jeune </h1>
        <div id=formulaire>
            <form method="post" action="Inscription.php">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom"><br><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom"><br><br>
                <label for="ddn">Date de naissance :</label>
                <input type="date" id="ddn" name="ddn" min="2000-01-01"><br><br>
                <label for="email">Adresse e-mail : </label>
                <input type="email" id="email" name="email"><br><br>
                <label for="mdp">Mot de passe : </label>
                <input type="password" id="mdp" name="mdp"><br><br>
                <input type="submit" id="boutonformulaire" value="Inscription">
            </form>
        </div>

        <div id="rappelconnexion">
            <h2 id="phrase"> Vous avez déjà un compte ?</h2>
            <a href="Connexion.html" id="lienconnexion"> Accéder à votre espace</a>
        </div>
        <div id="annonceur">
        <?php

            switch($erreur){
                case 0:
                    echo "<p class='vert'>Votre compte a bien été créé.</p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
                case 1:
                    echo "<p class='rouge'> Un problème est survenu lors de la création du compte. </p>";
                    echo "<p class='rouge'> Un symbole non-autorisé a été utilisé. Veuillez réessayer. </p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
                case 2:
                    echo "<p class='rouge'> Un problème est survenu lors de la création du compte. </p>";
                    echo "<p class='rouge'> L'écriture dans la base de données a échoué. Veuillez réessayer. </p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
                case 3:
                    echo "<p class='rouge'> Un problème est survenu lors de la création du compte. </p>";
                    echo "<p class='rouge'> Tous les champs sont obligatoires. Veuillez réessayer. </p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
                case 4:
                    echo "<p class='rouge'> Un problème est survenu lors de la création du compte. </p>";
                    echo "<p class='rouge'> Un compte utilisant cette adresse e-mail existe déjà. </p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
                case 5:
                    echo "<p class='rouge'> Un problème est survenu lors de la création du compte. </p>";
                    echo "<p class='rouge'> L'accès à la base de données est impossible. Veuillez réessayer plus tard. </p>";
                    echo "<p><a href='Presentation.html' id='retouraccueil'> Retour à l'accueil </a></p>";
                    break;
            }
        ?>
        </div>
    </div>

</body>
</html>
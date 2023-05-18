<!DOCTYPE html>
<!--HTML DE LA PAGE INSCRIPTION DU MODULE VISITEUR-->
<html>
<head>
    <title> Inscription - Jeunes 6.4</title>
    <link rel="stylesheet" href="Inscription.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php
        // Cette fonction recherche si un email existe dans les comptes du fichier de données.
        // Elle prend l'email en paramètre.
        // Elle renvoie 0 si l'email n'est pas présent, 1 sinon.
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
    ?>

</head>

<body class="nomargin">

    <?php
        // Si le fichier de données n'existe pas, il est créé à l'arivée sur la page. 
        if(file_exists("comptes.txt")==false){
            $temp=fopen("comptes.txt","w");
            fclose($temp);
        }

        // Initialisation de la variable d'erreur et de celles du formulaire.
        $erreur=5;
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $ddn=$_POST['ddn'];
        $email=$_POST['email'];
        $mdp=$_POST['mdp'];

        // Tous les champs sont obligatoires.
        if($nom=="" || $prenom=="" || $ddn=="" || $email=="" || $mdp==""){
            $erreur=3;
        }

        // Pas de virgule dans les champs car c'est un séparateur.
        if(strpos($nom,',')!=false || strpos($prenom,',')!=false || strpos($email,',')!=false || strpos($mdp,',')!=false){
            $erreur=1;
        }

        // Si la variable d'erreur n'a pas été modifiée, il n'y a pas encore d'erreur.
        if($erreur==5){
            if(recherchecompte($email)==0){
                // Si le mail n'est pas encore dans le fichier de données, $erreur passe à 0 : pas d'erreur.
                // $erreur est modifiée par la suite si un problème survient
                $erreur=0;
                $database=fopen("comptes.txt","r+");
                if($database){
                    // Parcours du fichier jusqu'à la fin.
                    while(fgets($database)!=false){
                        $i=1;
                    }
                    if(fwrite($database,$nom.",".$prenom.",".$ddn.",".$email.",".$mdp."\n")==false){
                        // Erreur 2 : l'écriture dans le fichier n'a pas fonctionné
                        $erreur=2;
                    }
                    fclose($database);
                }
                else{
                    // Erreur 5 : le fichier de données n'a pas pu être ouvert.
                    $erreur=5;
                }
            }
            else{
                // Erreur 4 : le mail existe déja dans le fichier de données.
                $erreur=4;
            }
        }
        


    ?>
    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="Presentation.html"> <img src="Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> JEUNE </h1>
        <p id="titreentete2"> Je donne de la valeur à mon engagement </p>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <!--Le fond de la page est la version "jeune" du logo de JEUNES 6.4-->
        <img id="fond" src="Images/logo2.JPG">

        <h1 id="titre"> Création de votre compte Jeune </h1>

        <!--Zone du formulaire d'inscription-->
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

        <!--Div utilisée pour rappeler à l'utilisateur qu'il peut se connecter s'il a un compte.-->
        <div id="rappelconnexion">
            <h2 id="phrase"> Vous avez déjà un compte ?</h2>
            <a href="Connexion.html" id="lienconnexion"> Accéder à votre espace</a>
        </div>

        <!--La zone de l'annonceur, utilisée pour transmettre des messages via PHP-->
        <div id="annonceur">

        <?php
            // Affichage d'un message en fonction de la valeur de $erreur.
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
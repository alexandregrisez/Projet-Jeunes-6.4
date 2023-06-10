<?php

function modifdemande($id,$comm,$qual1,$qual2,$qual3,$qual4){
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
                    if($qual2==""){
                        if(fwrite($temp,$tab[0].",".$tab[1].","."0".",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8].",".$tab[9].",".$tab[10].",".$qual1.",".$comm."\n")==false){ 
                            $ok=1;
                        }
                    }
                    else if($qual3==""){
                        if(fwrite($temp,$tab[0].",".$tab[1].","."0".",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8].",".$tab[9].",".$tab[10].",".$qual1.";".$qual2.",".$comm."\n")==false){ 
                            $ok=1;
                        }
                    }
                    else if($qual4==""){
                        if(fwrite($temp,$tab[0].",".$tab[1].","."0".",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8].",".$tab[9].",".$tab[10].",".$qual1.";".$qual2.";".$qual3.",".$comm."\n")==false){ 
                            $ok=1;
                        }
                    }
                    else{
                        if(fwrite($temp,$tab[0].",".$tab[1].","."0".",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8].",".$tab[9].",".$tab[10].",".$qual1.";".$qual2.";".$qual3.";".$qual4.",".$comm."\n")==false){ 
                            $ok=1;
                        }
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
if(isset($_POST['comm'])){
    $comm=$_POST['comm'];
    $id=$_POST['id'];
    if(isset($_POST['qualite3'])){
        $erreur=modifdemande($id,$comm,$_POST['nomqualite0'],$_POST['nomqualite1'],$_POST['nomqualite2'],$_POST['nomqualite3']);
    }
    else if(isset($_POST['qualite2'])){
        $erreur=modifdemande($id,$comm,$_POST['nomqualite0'],$_POST['nomqualite1'],$_POST['nomqualite2'],"");
    }
    else if(isset($_POST['qualite1'])){
        $erreur=modifdemande($id,$comm,$_POST['nomqualite0'],$_POST['nomqualite1'],"","");
    }
    else if(isset($_POST['qualite0'])){
        $erreur=modifdemande($id,$comm,$_POST['nomqualite0'],"","","");
    }
    else{
        $erreur=200;
    }    
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
    <link rel='stylesheet' href='PageDeConfirmation.css'>
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8"  name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="nomargin">

    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href='../Visiteur/Presentation.html'> <img src='../Images/logo1.png' id='imageentete'> </a>
        <h1 id="titreentete1"> RÉFÉRENT </h1>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <div id="annonceur">
            <?php
            switch($erreur){
                case 0:
                    echo "<p class='vert'> Vous venez de valider la demande de référence N°{$id}.</p>";
                    echo "<p class='vert'> Merci d'avoir utilisé JEUNES 6.4 !</p>";
                    break;
                case 200:
                    echo "<p class='rouge'> Erreur : vous devez valider au moins un savoir-être.";
                    echo "<p class='rouge'> Veuillez réessayer. </p>";
                    break;
                default:
                    echo "<p class='rouge'> Une erreur est survenue. Veuillez réessayer. </p>";
                    break;
            }
		    ?>
        </div> 

    </div>
</body>
</html>

<?php

function listequalites($nb){
    switch($nb){
        case 1:
            return "Enthousiasme";
        case 2:
            return "Communication";
        case 3:
            return "Bienveillance";
        case 4:
            return "Rigueur";
        case 5:
            return "Réactivité";
        case 6:
            return "Adaptation";
        case 7:
            return "Persévérance";
        case 8:
            return "Curiosité";
        case 9:
            return "Organisation";
        case 10:
            return "Rapidité";
        case 11:
            return "Travail en équipe";
        case 12:
            return "Prise de recul";
        case 13:
            return "Honnêteté";
        default:
            return "erreur";
    }
}

function creationid(){
    $id=100;
    $buffer="123";
    $tab=[];

    $database=fopen("demandes.txt","r+");
    if(!$database){
        return 1;
    }

    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                if($id<=$tab[1]){
                    $id=$tab[1]+1;
                }
            }
        }
    }
    fclose($database);
    return $id;
}

function demandedereference($id,$nom,$prenom,$metier,$email1,$desc,$domaine,$date1,$date2,$qual1,$qual2,$qual3,$qual4,$email2){
    $database=fopen("demandes.txt","r+");
    if(!$database){
        return 1;
    }
    while(fgets($database)!=false){
        $i=1;
    }
    if($qual2==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1."\n")==false){
            return 1;
        }
    }
    else if($qual3==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2."\n")==false){
            return 1;
        }
    }
    else if($qual4==""){
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2.";".$qual3."\n")==false){
            return 1;
        }
    }
    else{
        if(fwrite($database,$email2.",".$id.",1,".$desc.",".$date1.",".$date2.",".$domaine.",".$nom.",".$prenom.",".$email1.",".$metier.",".$qual1.";".$qual2.";".$qual3.";".$qual4."\n")==false){
            return 1;
        }
    } 
    fclose($database);
    return 0;
}

function affichedemande($id){
    $buffer="123";
    $tab=[];

    $database=fopen("demandes.txt","r+");
    if(!$database){
        return 1;
    }

    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                if($id==$tab[1]){
                    $emailjeune=$tab[0];
                    $statut=$tab[2];
                    $desc=$tab[3];
                    $date1=$tab[4];
                    $date2=$tab[5];
                    $domaine=$tab[6];
                    $nom=$tab[7];
                    $prenom=$tab[8];
                    $emailref=$tab[9];
                    $metier=$tab[10];
                    $qualites=explode(";",$tab[11]);
                    break;
                }
            }
        }
    }
    fclose($database);
    
    echo "<div id='demande'>
              <p> Vous (".$emailjeune.") avez émis la demande n°".$id." :</p>
              <div id='tiers1'>
                  <p> Votre référent : </p>
                  <p> Nom : ".$nom."</p>
                  <p> Prénom : ".$prenom."</p>
                  <p> E-mail : ".$emailref."</p>
                  <p> Métier : ".$metier."</p>
              </div>
              <div id='tiers2'>
                  <p> Votre engagement : </p>
                  <p> Domaine : ".$domaine."</p>
                  <p> Du ".$date1." au ".$date2." </p>
                  <p> Description : ".$desc."</p>
              </div>
              <div id='tiers3'>
                  <p> Vos qualités démontrées : </p>";
    $nb=count($qualites);
    if($nb==1){
        echo "<p>-".$qualites[0]."</p>";
    }
    else if($nb==2){
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
    }
    else if($nb==3){
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
        echo "<p>-".$qualites[2]."</p>";
    }
    else{
        echo "<p>-".$qualites[0]."</p>";
        echo "<p>-".$qualites[1]."</p>";
        echo "<p>-".$qualites[2]."</p>";
        echo "<p>-".$qualites[3]."</p>";
    }
    echo "    </div>
          </div>";
    return 0;
}

session_start();
if(!(isset($_SESSION['derniereconnexion']))){
	$_SESSION['erreur']=2;
	header('Location: Connexion.php');
}

if(isset($_SESSION['derniereconnexion']) && time() - $_SESSION['derniereconnexion'] > 1200){
		$_SESSION['erreur']=3;
		header('Location: Connexion.php');
}

$erreur=-1;
$cas=0;

if(!isset($_POST['nom']) && !isset($_GET['nom'])){
    $erreur=5;
}

if($erreur==-1){
    if(isset($_POST['nom'])){
        $cas=1;
    }
    else{
        $cas=2;
    }
}

if($cas==1){
    $i=0;
    $j=0;
    $qualites=[];
    for($i=1;$i<14;$i++){
        if(isset($_POST['qualite'.strval($i)])){
            $qualites[$j]=listequalites($i);
            $j+=1;
        }
    }
    if($j==0){
        $erreur=9;
    }
    if($j==1){
        $qualites[1]="";
        $qualites[2]="";
        $qualites[3]="";
    }
    if($j==2){
        $qualites[2]="";
        $qualites[3]="";
    }
    if($j==3){
        $qualites[3]="";
    }
    if($j>4){
        $erreur=10;
    }
    if($erreur==-1){
        $id=creationid();
        $erreur=demandedereference($id,$_POST['nom'],$_POST['prenom'],$_POST['metier'],$_POST['email'],$_POST['desc'],
                                   $_POST['domaine'],$_POST['date1'],$_POST['date2'],$qualites[0],$qualites[1],
                                   $qualites[2],$qualites[3],$_SESSION['email']);
    }
}

if($cas==2){
    $erreur=999;
}

?>


<!DOCTYPE html>
<html>
<head>
    <title> Demande de référence - Jeunes 6.4</title>
    <link rel="stylesheet" href="Resume.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="nomargin">
    <div id="entete">
        <a href="../Visiteur/Presentation.html"> <img src="../Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> ESPACE JEUNE </h1>
    </div>
    <div id="invisible"> </div>
    <div id="annonceur"> 
        <?php
            switch($erreur){
                case 0:
                    echo "<p class='vert'>Votre demande de référence a bien été prise en compte.</p>";
                    break;
                case 1:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Nous avons eu un problème avec la base de données. </p>";
                    break;
                case 9:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Vous n'avez séléctionné aucune qualité sur le questionnaire. </p>";
                    break;
                case 10:
                    echo "<p class='rouge'>Votre demande de référence n'a pas été prise en compte.</p>";
                    echo "<p class='rouge'> Cause : Vous avez sélectionné trop de qualités sur le questionnaire. </p>";
                    break;
                default:
                    echo "";
                    break;
            }
        ?>
    </div>
    <div id="recapitulatif">
        <p id="titre"> Votre demande de référence : </p>
        <?php
            if($cas==1){
                affichedemande($id);
            }
            else if($cas==2){
                affichedemande($_GET['id']);
            }
            else{
                echo "<p>La demande de référence n'a pas pu être chargée.</p>";
            }
        ?>
    </div>
    <div id=divlien> <a id="lien" href="CompteJeune.php"> Retour à votre espace</a> </div>

</body>
</html>
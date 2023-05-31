<?php
function rechercheid($id){ //recherche l'id dans toutes les references et envoie la ref correspondante
    if(!(file_exists("../Jeune/demandes.txt"))){
		return 1;
	}
    $database=fopen("../Jeune/demandes.txt","r+");
    $buffer="123";
    $tab=[];
    while($buffer!=false){
        $buffer=fgets($database);
        if($buffer!=false){
            $tab=explode(",",$buffer);
            if(isset($tab[1])){
                if($id==$tab[1]){
                    fclose($database);
                    return $tab;
                }
            }
        }
    }
    echo $erreur;
    fclose($database);
    return 1;

}
?>
<!DOCTYPE html>
<!--HTML DE LA PAGE CONSULTANT DU MODULE VISITEUR-->
<html>
<head>
    <title> Accueil - Jeunes 6.4</title>
    <link rel="stylesheet" href="Consultant.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="nomargin">
    <!--Une div qui correspond à l'entête des pages du site.-->
    <div id="entete">
        <a href="Presentation.html"> <img src="Images/logo1.png" id="imageentete"> </a>
        <h1 id="titreentete1"> CONSULTANT </h1>
    </div>

    <!--La zone principale de la page.-->
    <div id="corps">

        <!--Le fond de la page est la version "consultant" du logo de JEUNES 6.4-->
        <img id="fond" src="Images/logo4.JPG">
        <div id="texte">
            <p>BLABLA</p>
        </div>
        <div id=references>
            <p>Voici la liste des references du jeune</p>
            <?php
                $erreur=0;
                $tab=[];
                $list_id="100,4";
                $list_id=explode(",",$list_id);
                echo "IDs : {$list_id[0]},{$list_id[1]} <br> <br>";
                if($list_id==false){
                    $erreur=300;
                    echo $erreur;
                }
                else{
                    $erreur=301;
                    echo $erreur;
                }
                echo "<br> <br>";
                //$list_id=explode(",",$_GET["list_id"]);
                for($i=0;$i<count($list_id);$i++){
                    $tab=rechercheid($list_id[$i]); //cette ligne pose pb
                    if($tab==1){
                        echo "L'id {$list_id[$i]} n'a pas de demande associée";
                    }
                    else{
                        for($j=0;$j <12;$j++){
                            echo $tab[$j]."<br>";
                        }
                    }
                    
                     
                    echo  "<div> 
                    <p id=jeune>Voici les informations du Jeune et sa demande de Référence\n
                    Nom:".$tab[11]."\nPrenom:".$tab[12]." \nDate de naissance:".$tab[13]."\nemail:".$tab[0]."\nDescription engagement:".$tab[3]."\nDate de début:".$tab[4]."\nDate de fin:".$tab[5]."\nDomaine d'engagement:".$tab[6]."\n</p>
                    <p id=referent>Voici les informations du Référent qui a validé la demande\n
                    Nom du référent:".$tab[7]."Prenom du référent:".$tab[8]."email".$tab[9]."Métier:".tab[10]."Savoirs-être".$tab[100]."\n</p>
                    </div> ";

                }
            ?>
        </div>
    </div>

</body>
</html>

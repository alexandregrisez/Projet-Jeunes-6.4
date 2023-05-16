<?php
session_start();
if(isset($_SESSION['derniereconnexion']) && (time() - $_SESSION['derniereconnexion'] > 30)){
		session_unset();
		session_destroy();
		header('Location: Connexion.php');
}

?>
<html>
<head>
    <title> Connexion - Jeunes 6.4</title>
    <link rel="stylesheet" href="CompteJeune.css">
    <!--Les attributs name et content permettent ici d'utiliser les unités dynamiques vw,vh,vmin... dans le CSS-->
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
	<p> test </p>
	<?php
		
		$var1=time();
		$var2=$_SESSION['derniereconnexion'];
		$var=(time()-$_SESSION['derniereconnexion']);
		
		echo "<p> Temps : $var1
				  Temps à la dernière connexion :	$var2
				  Temps depuis la dernière connexion : $var </p>";
	?>
</body>
</html>

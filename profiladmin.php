<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions)

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//Ma connexion
require('connexionBDD.php');
// $bdd = connexionUserPDO();													//Connexion jules

if(isset($_GET['idcompte']) AND $_GET['idcompte'] > 0)
{
	$bdd = connexionUserPDO();
	$getid = intval($_GET['idcompte']);			//securiser la variable (convertir l'idcompte en nombre)
	$requser = $bdd->prepare('SELECT * FROM compte WHERE idcompte=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();			//va chercher les infos dans requser et les mets dans userinfo
	

?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Connexion</title>
		<link rel="stylesheet" href="Style_Accueil.css">
		 <!-- <meta http-equiv="refresh" content="60"> -->			<!-- Auto-refresh -->
	</head>
	<body>
		
		<!-- Header -->
		<div class="header">
			<div id="fondGaucheHeader"></div>
		  
			<div id="fondDroiteHeader"></div>
			
			<div id="containerHeader">
				<div class="titre elemHeader">
					<a href="Accueil.php" class="lienDiscret"><h1> Dans ton Frigo ! </h1></a>
				</div>
				
				<div class="elemHeader centrage boite_recherche">
					<form method="POST" action="rechercher.php" >
						<input type="search" name="rech" class="saisieRecette" size="50" placeholder=" Rechercher une recette...">
					</form>
				</div>
				

				<div class="navbar">
					<div class="navbar">
				
						<a href="connexion.php" class="iconenav centrage lien_icone">
							<img src="Images/compte.png" class="image_icone">
							<p class="icone_texte">Compte</p>
						</a>

						<a href="fake_src" class="iconenav centrage lien_icone">
							<img src="Images/livre_recette.png" class="image_icone">
							<p class="icone_texte">Recettes</p>
						</a>
						
						<a href="bsoindaid.php" class="iconenav centrage lien_icone need_help">
							<img src="Images/point_interrogation.png" class="image_icone">
							<p class="icone_texte">Besoin d'aide ?</p>
						</a>
				
					</div>
				</div>
			</div>
		</div>


		<!-- la grille flexible (content) -->
		<div class="row">
			<div class="side">
				<div class="elemHeader centrage boite_recherche">
					<form method="POST" action="rechercheIngredient.php" >
						<input type="search" name="rechingr" class="saisieRecette" size="50" placeholder=" Rechercher un ingrédient...">
					</form>
				</div>
			</div>
		  
		  <div class="main">
			<div align="center">
			<?php
				echo '<h2>Profil de '.$userinfo['nomUtilisateur'].' </h2>
				<br><br>
				Nom d\'utilisateur : '.$userinfo['nomUtilisateur']. 
				'<br>
				Mail : '. $userinfo['mail']. 
				'<br>';
					if(isset($_SESSION['idcompte']) AND $userinfo['idcompte'] == $_SESSION['idcompte'])
					//le "isset($_SESSION['idcompte'])" permet d'obligé d'être connecté -> pas de possibilité de le voir si tu visite le profil sans être connecté
					{
						echo '<a href="editionprofil.php">Editer mon profil</a>
						<a href="deconnexion.php">Se déconnecter</a>';
				
					}
				echo '
				<br><br>
				<form method="POST" action="">
					<input type="submit" name="admin" value="USER">
				</form>';
			?>
			</div>
		  </div>
		</div>

		<!-- Footer -->
		<div class="footer">
		  <h2>Footer</h2>
		</div>
	</body>
</html>
<?php
$bdd = NULL;
}
?>
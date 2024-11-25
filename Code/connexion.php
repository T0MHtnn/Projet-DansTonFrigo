<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions)

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require('connexionBDD.php');
// $bdd = connexionUserPDO();

if(isset($_POST['formconnexion']))		//Si variable "formconnexion" existe alors .. = si le bouton est appuyé
{
	$mailconnect = htmlspecialchars($_POST['mailconnect']);	//Sécuriser la variable "mailconnect"
	//$mdpconnect = sha1($_POST['mdpconnect']);	//ATTENTION : Mettre le même encodage que celui utilisé sur l'autre page pour pouvoir reconnaître le mdp
	$mdpconnect = hash('sha256', $_POST['mdpconnect']);
	/*												REMETTRE LE HASHAGE DU MDP		hash('sha256', $variable)														*/
	if(!empty($mailconnect) AND !empty($mdpconnect))
	{
		$bdd = connexionUserPDO();
		$requser = $bdd->prepare("SELECT * FROM compte WHERE mail=? AND mdp=?");
		$requser->execute(array($mailconnect,$mdpconnect));
		$userexist = $requser->rowCount();
		if($userexist == 1)
		{
			$_SESSION['connecte'] = true;						//garder en mémoire qu'on est connecté
			$userinfo = $requser->fetch();						//recevoir infos
			$_SESSION['idcompte'] = $userinfo['idcompte'];
			$_SESSION['nomUtilisateur'] = $userinfo['nomUtilisateur'];
			$_SESSION['mail'] = $userinfo['mail'];
			$admin = $userinfo['estAdmin'];
			if($admin == true)
			{
				header("Location: profiladmin.php?idcompte=".$_SESSION['idcompte']);				//Te renvoie au profil de la personne directement
			}
			elseif($admin == false)
			{
				header("Location: profil.php?idcompte=".$_SESSION['idcompte']);				//Te renvoie au profil de la personne directement
			}
			
		}
		else
		{
			$erreur = "Mauvais mail ou mdp !";
		}
		$bdd = NULL;
	}
	else
	{
		$erreur = "Tous les champs doivent être complétés";
	}
}                                             
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


		<!-- la grille flexible (content) -->
		
			
		  
		  <div class="main">
			<div align="center">
				<h2>Connexion</h2>
				<br><br>
				<div class="form">
					<form method="POST" action="">
						<div class="input">
							<!-- <input type="text" name="pseudoconnect" placeholder="Pseudo"> -->		<!-- Se connecter à partir du pseudo -->
							<input type="email" name="mailconnect" placeholder="mail">
							<input type="password" name="mdpconnect" placeholder="Mot de passe">
							<input type="submit" name="formconnexion" value="Se connecter">
						</div>
					</form>
				</div>
				<?php
				echo '<br>
				<p> Pas encore de compte ? <a href="inscription.php">Clique ici pour te créer un compte</a></p>';
				
					if(isset($erreur))
					{
						echo '<font color="red">'.$erreur."</font>";
					}
				?>
			</div>
		  </div>

		<!-- Footer -->
		<div class="footer">
		  <h2>Footer</h2>
		</div>
	</body>
</html>
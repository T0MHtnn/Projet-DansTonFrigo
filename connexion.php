<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions)

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require_once('connexionBDD.php');
require_once('component.php');
$bdd = connexionUserPDO();

if(isset($_POST['formconnexion']))		//Si variable "formconnexion" existe alors .. = si le bouton est appuyé
{
	$mailconnect = htmlspecialchars($_POST['mailconnect']);	//Sécuriser la variable "mailconnect"//$mdpconnect = sha1($_POST['mdpconnect']);	//ATTENTION : Mettre le même encodage que celui utilisé sur l'autre page pour pouvoir reconnaître le mdp
	$mdpconnect = hash('sha256', $_POST['mdpconnect']);// $mot = "".$mdpconnect."<br>".hash('sha256', $mdpconnect)."<br>".hash('sha256', 'pp')."<br>".hash('sha256', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855')."<br>".$_POST['mdpconnect']."<br>".$mailconnect."<br>".$_POST['mailconnect'];
	/*												REMETTRE LE HASHAGE DU MDP		hash('sha256', $variable)														*/
	if(!empty($mailconnect) AND !empty($mdpconnect))
	{
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
				header("Location: Administration.php?idcompte=".$_SESSION['idcompte']);				//Te renvoie au profil de la personne directement
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
	}
	else
	{
		$erreur = "Tous les champs doivent être complétés";
	}
}
if(isset($_POST['forminscription']))	//si le bouton "Je m'inscris" est appuyé alors..
{
	$nomUtilisateur = htmlspecialchars($_POST['nomUtilisateur']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$mdp = hash('sha256', $_POST['mdp']);
	$mdp2 = hash('sha256', $_POST['mdp2']);
	/*												REMETTRE LE HASHAGE DES MDP		hash('sha256', $variable)															*/
	
	if(!empty($_POST['nomUtilisateur']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))		//"!empty" : check si c'est pas vide
	{
		$pseudolength = strlen($nomUtilisateur);
		if($pseudolength <= 255)
		{
			if($mail == $mail2)
			{
				if(filter_var($mail, FILTER_VALIDATE_EMAIL))	//Filtre déjà existant ; La saisie est bien un email ? -> comme mail = mail2 alors on verifie qu'1/2
				{
					//Tester si adresse mail déjà existante
					$reqmail = $bdd->prepare("SELECT * FROM compte WHERE mail=?");
					$reqmail->execute(array($mail));		//ou "mail2", ce sont les mêmes (car vérifiés juste avant)
					$mailexist = $reqmail->rowCount();		//Compte le nb de lignes existantes
					if($mailexist == 0)
					{
						//Tester si nomUtilisateur déjà existant
						$reqpseudo = $bdd->prepare("SELECT * FROM compte WHERE nomUtilisateur=?");
						$reqpseudo->execute(array($nomUtilisateur));		//ou "mail2", ce sont les mêmes (car vérifiés juste avant)
						$pseudoexist = $reqpseudo->rowCount();		//Compte le nb de lignes existantes
						if($pseudoexist == 0)
						{
							if($mdp == $mdp2)
							{
								$insertmbr = $bdd->prepare("INSERT INTO compte(nomUtilisateur, mail, mdp) VALUES(?, ?, ?)");			//"prepare" : Preparer à l'envoi la variable "insertmbr" / "membres" = nom table , "pseudo, mail, mdp" = attributs	
								$insertmbr->execute(array($nomUtilisateur, $mail, $mdp));												//"execute" : Executer l'envoi de la variable "insertmbr" via un tableau (array)
								$erreur = "Votre compte à bien été créé !";				// "\" devant les " pour annuler celles d'avant (donc pour en mettre d'autres)
								//header('Location: connexion.php');					//Renvoie l'utilisateur à la page "connexion.php"
								
							}
							else
							{
								$erreur = "Vos mdp ne correspondent pas !";
							}
						}
						else
						{
							$erreur = "Nom d'Utilisateur déja utilisée !";
						}
					}
					else
					{
						$erreur = "Adresse mail déja utilisée !";
					}
				}
				else
				{
					$erreur = "Votre adresse mail n'est pas valide !";
				}
			}
			else
			{
				$erreur = "Vos deux mails ne correspondent pas !";
			}
		}
		else
		{
			$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
		}
	}
	else
	{
		//echo "non";
		$erreur = "Tous les champs doivent être complétés !";
	}
}
?>
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Connexion</title>
		<link rel="stylesheet" href="Style_Accueil1.css">
		<link rel="stylesheet" href="StyleLoginTest.css">
		 <!-- <meta http-equiv="refresh" content="60"> -->			<!-- Auto-refresh -->
	</head>
	<body>			
		<!-- Header -->
		<div class="header">
			<?php headerPage(); ?>
		</div>


		<!-- la grille flexible (content) -->
		  
		  <div class="mainConnexion">
			<div align="center">
			<br><br>
			<!--
				<h2>Connexion</h2>
				<br><br>
					<form method="POST" action="">
						<!-- <input type="text" name="pseudoconnect" placeholder="Pseudo"> -->		<!-- Se connecter à partir du pseudo -->
			<!--			<input type="email" name="mailconnect" placeholder="mail">
						<input type="password" name="mdpconnect" placeholder="Mot de passe">
						<input type="submit" name="formconnexion" value="Se connecter">
					</form>
					
			-->
					<div class="container" id="container">

						<div class="form-container register-container">
							<form method="POST" class="formLogin">
								<h1>Inscription</h1>
								<input type="text" placeholder="Votre Nom D'utilisateur" name="nomUtilisateur" id="nomUtilisateur" value="<?php if(isset($nomUtilisateur)) { echo $nomUtilisateur; } ?>">
								<input type="email" placeholder="Votre mail" name="mail" id="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
								<input type="email" placeholder="Vérification du mail" name="mail2" id="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
								<input type="password" placeholder="Mot de passe" name="mdp" id="mdp">
								<input type="password" placeholder="Confirmez votre mdp" name="mdp2" id="mdp2">
								<input type="submit" name="forminscription" value="Je m'inscris">
								<!-- <button>S'inscrire</button> -->
							</form>
						</div>
						
						<div class="form-container login-container">
							<form method="POST" class="formLogin">
								<h1>Se connecter</h1>
								<input type="email" name="mailconnect" placeholder="Email">
								<input type="password" name="mdpconnect" placeholder="Mot de passe">
								<input type="submit" name="formconnexion" value="Se connecter">
								<!-- <button>Se connecter</button> -->
							</form>
						</div>
						
						<div class="overlay-container">
							<div class="overlay">
								<div class="overlay-panel overlay-left">
									  <h1 class="title"> Vous voulez <br> vous connecter ?</h1>
									  <p>Connectez vous ici</p>
									  <button class="ghost" id="login">Se connecter
										<i class="lni lni-arrow-left login"></i>
									  </button>
								</div>
							
								<div class="overlay-panel overlay-right">
									<h1 class="title">Commencer l'aventure <br>DansTonFrigo</h1>
									<p>Créez vous un compte !</p>
									<button class="ghost" id="register">S'inscrire
										<i class="lni lni-arrow-right register"></i>
									</button>
								</div>
							</div>
						</div>

					 </div>
					<script type="text/javascript">
						const registerButton = document.getElementById("register");
						const loginButton = document.getElementById("login");
						const container = document.getElementById("container");

						registerButton.addEventListener("click", () => {
						  container.classList.add("right-panel-active");
						});

						loginButton.addEventListener("click", () => {
						  container.classList.remove("right-panel-active");
						});
					
					</script>
					
					
				<?php
					if(isset($erreur))
					{
						echo '<br><br><font color="red">'.$erreur."</font>";
					}
				?>
				
				<!-- Footer -->
			</div>
			<div class="footerConnexion">
				  <?php footer(); ?>
			</div>
		  </div>

	</body>
</html>
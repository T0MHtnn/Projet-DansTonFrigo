<?php

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require('connexionBDD.php');
$bdd = connexionUserPDO();

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
								$erreur = "Votre compte à bien été créé ! <a href=\"connexion.php\">Me connecter</a>";			// "\" devant les " pour annuler celles d'avant (donc pour en mettre d'autres)
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
if(isset($_POST['formconnexion']))
{
	header('Location: connexion.php');
}

?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Inscription</title>
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
					<p>Vos ingrédients</p>
					<form method="POST" action="" >
						<input type="search" name="rechingr" class="saisieRecette" size="50" min="2" placeholder=" Rechercher un ingrédient...">
					</form>
					<?php
						if(isset($_SESSION['listeingredient'])){
							foreach($_SESSION['listeingredient'] as $cle=>$valeur){
									echo '<ul>
									<li><form method="POST" action="Accueil.php">'
									// .'<input type="text" name="nomIngre" value="'.$_POST['nomIngre'].'" hidden>'
									.$valeur.' <input type="submit" value="Supprimer" name="suppingr"></form></li>
									</ul>';
							}
							if(isset($dejaexist) AND $dejaexist == true){
								if(isset($messg)){
									echo $messg;
								}
							}
						}
					?>
				</div>
			</div>
		  
		<div class="main">
			<div align="center">
				<h2>Inscription</h2>
				<br><br>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for="nomUtilisateur">Nom d'utilisateur :</label>
							</td>
							<td>
								<input type="text" placeholder="Votre Nom D'utilisateur" name="nomUtilisateur" id="nomUtilisateur" value="<?php if(isset($nomUtilisateur)) { echo $nomUtilisateur; } ?>">
							</td align="right">
						</tr>
						<tr>
							<td align="right">
								<label for="mail">Mail :</label>
							</td>
							<td>
								<input type="email" placeholder="Votre mail" name="mail" id="mail" value="<?php if(isset($mail)) { echo $mail; } ?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail2">Confirmation du Mail :</label>
							</td>
							<td>
								<input type="email" placeholder="Confirmez votre mail" name="mail2" id="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp">MDP :</label>
							</td>
							<td>
								<input type="password" placeholder="Votre mdp" name="mdp" id="mdp">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp2">Confirmez votre mdp :</label>
							</td>
							<td>
								<input type="password" placeholder="Confirmez votre mdp" name="mdp2" id="mdp2">
							</td>
						</tr>
						<tr>
							<td></td>
							<td align="center">
								<br>
								<input type="submit" name="forminscription" value="Je m'inscris">
								<input type="submit" name="formconnexion" value="Je me connecte">
							</td>
						</tr>
					</table>
				</form>
				<?php
					if(isset($erreur))
					{
						echo '<font color="red">'.$erreur."</font>";
					}
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
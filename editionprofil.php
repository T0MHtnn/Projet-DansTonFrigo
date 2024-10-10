<!--Informations inchangées-->
<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions)

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require_once('connexionBDD.php');		//require_once(); -> si le fichier a déjà été ajouté, il ne sera pas ajouté une deuxième fois
// $bdd = connexionUserPDO();

if(isset($_SESSION['idcompte']))		//être connecté à ton compte pour l'éditer sinon ça te renvoie à la page de connexion
{
		$bdd = connexionUserPDO();
		$requser = $bdd->prepare("SELECT * FROM compte WHERE idcompte = ?");
		$requser->execute(array($_SESSION['idcompte']));
		$user = $requser->fetch();
		
		if(isset($_POST['newnomUtilisateur']) AND !empty($_POST['newnomUtilisateur']) AND $_POST['newnomUtilisateur'] != $user['nomUtilisateur'])
		{
			//Tester si newnomUtilisateur déjà existant
			$newnomUtilisateur = htmlspecialchars($_POST['newnomUtilisateur']);
			$reqpseudo = $bdd->prepare("SELECT * FROM compte WHERE nomUtilisateur=?");
			$reqpseudo->execute(array($newnomUtilisateur));		//ou "mail2", ce sont les mêmes (car vérifiés juste avant)
			$pseudoexist = $reqpseudo->rowCount();		//Compte le nb de lignes existantes
			
			if($pseudoexist == 0)
			{
				$newnomUtilisateur = htmlspecialchars($_POST['newnomUtilisateur']);			//securise la variable -> evite injection sql etc
				$insertpseudo = $bdd->prepare("UPDATE compte SET nomUtilisateur = ? WHERE idcompte = ?");
				$insertpseudo->execute(array($newnomUtilisateur, $_SESSION['idcompte']));
				header('Location: profil.php?idcompte='.$_SESSION['idcompte']);
			}
			else
			{
				$msg = "nomUtilisateur déja utilisé !";
			}
					
		}
		
		if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
		{
			//Tester si newmail déjà existant
			$newmail = htmlspecialchars($_POST['newmail']);
			$reqmail = $bdd->prepare("SELECT * FROM compte WHERE mail=?");
			$reqmail->execute(array($newmail));		//ou "mail2", ce sont les mêmes (car vérifiés juste avant)
			$mailexist = $reqmail->rowCount();		//Compte le nb de lignes existantes
			if($mailexist == 0)
			{
				$newmail = htmlspecialchars($_POST['newmail']);
				$insertmail = $bdd->prepare("UPDATE compte SET mail = ? WHERE idcompte = ?");
				$insertmail->execute(array($newmail, $_SESSION['idcompte']));
				header('Location: profil.php?idcompte='.$_SESSION['idcompte']);
			}
			else
			{
				$msg = "Mail déja utilisé !";
			}
		}
		/*
		elseif(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] == $user['mail'])
		{
			$msg2 = "Adresse mail inchangée !";
		}*/
		
		if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
		{
			$mdp1 = hash('sha256', $_POST['newmdp1']);
			$mdp2 = hash('sha256', $_POST['newmdp2']);
			/*												REMETTRE LE HASHAGE DES MDP		hash('sha256', $variable)															*/
			
			if($mdp1 == $mdp2)
			{
				$insertmdp = $bdd->prepare("UPDATE compte SET mdp = ? WHERE idcompte = ?");
				$insertmdp->execute(array($mdp1, $_SESSION['idcompte']));			//mdp1 = mdp2 donc peu impore lequel on renvoie
				
				header('Location: profil.php?idcompte='.$_SESSION['idcompte']);
			}
			else
			{
				$msg = "Vos deux mdp ne correspondent pas !";
			}
		}
		elseif( (isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND empty($_POST['newmdp2'])) OR (isset($_POST['newmdp1']) AND empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) )
		{
			if(!empty($_POST['newmdp1']))
			{
				$msg = "La saisie de la confirmation du nouveau mdp est vide";
			}
			else
			{
				$msg = "La saisie du nouveau mdp est vide";
			}
		}
		/*	//Redirige vers le profil même si rien n'est changé
		if(isset($_POST['newnomUtilisateur']) AND $_POST['newnomUtilisateur'] == $user['nomUtilisateur'])
		{
			header('Location: profil.php?idcompte='.$_SESSION['idcompte']);
		}*/
	
	if(isset($_POST['retourProfil']))		//Si variable "retourProfil" existe alors .. = si le bouton est appuyé
	{
		//Redirige vers le profil même si rien n'est changé
		if(isset($_POST['newnomUtilisateur']) AND $_POST['newnomUtilisateur'] == $user['nomUtilisateur'])
		{
			header('Location: profil.php?idcompte='.$_SESSION['idcompte']);
		}
	}
	if(isset($_POST['supp']))	//si boutton supp est appuyé
	{
		require_once('fonctionsSuppression.php');	//require_once(); -> si le fichier a déjà été ajouté, il ne sera pas ajouté une deuxième fois
		supprimerLiensCompteRecette(NULL,$_SESSION['idcompte']);
		
		$suppmbr = $bdd->prepare("DELETE FROM compte WHERE nomUtilisateur = ? AND mail = ?");			//"prepare" : Preparer à l'envoi la variable "insertmbr" / "membres" = nom table , "pseudo, mail, mdp" = attributs	
		$suppmbr->execute(array($_SESSION['nomUtilisateur'],$_SESSION['mail']));												//"execute" : Executer l'envoi de la variable "insertmbr" via un tableau (array)
		$msg4 = "Le compte '".$_SESSION['nomUtilisateur']."' a bien été supprimé";
		header('Location: deconnexion.php');
	
	
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Mon profil</title>
		<link rel="stylesheet" href="Style_Accueil.css">
		 <!-- <meta http-equiv="refresh" content="60"> -->
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
				<h2>Edition de mon profil</h2>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for="newnomUtilisateur">nomUtilisateur :</label>
							</td>
							<td>
								<input type="text" name="newnomUtilisateur" placeholder="nomUtilisateur" value="<?php echo $user['nomUtilisateur']; ?>">
							</td align="right">
						</tr>
						<tr>
							<td align="right">
								<label for="newmail">Mail :</label>
							</td>
							<td>
								<input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="newmdp1">Mot de passe :</label>
							</td>
							<td>
								<input type="password" name="newmdp1" placeholder="Mot de passe">
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="newmdp2">Confirmation de mot de passe :</label>
							</td>
							<td>
								<input type="password" name="newmdp2" placeholder="Confirmation du Mot de passe">
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<br>
								<input type="submit" name="retourProfil" value="Retour">
								
								<input type="submit" name="maj" value="Mettre à jour">
								
								<input type="submit" name="supp" value="Supprimer compte">
							</td>
						</tr>
					</table>
				</form>
				<?php
				if(isset($msg2)) {if(isset($msg)){echo '<font color="red">'.$msg2.'<br>'.$msg.'</font>'; $msg=$msg2=null;}
				echo '<font color="red">'.$msg2.'</font>'; $msg2=null;}
				elseif(isset($msg)) {echo '<font color="red">'.$msg.'</font>'; $msg=null;}
				elseif(isset($msg4)) {echo '<font color="red">'.$msg4.'</font>'; $msg4=null;}
				else{$msg3="Informations inchangées"; echo '<font color="red">'.$msg3.'</font>'; $msg3=null;}
				if(isset($reppe)) {echo $reppe;}
				if(isset($debug)) {echo $debug;}
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
else
{
	header("Location: connexion.php");
}
?>
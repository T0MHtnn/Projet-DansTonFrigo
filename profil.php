<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions)

// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require_once('connexionBDD.php');
require_once('component.php');
require_once('FonctionsTom.php');
$bdd = connexionUserPDO();


if(isset($_POST['suppingr'])){
	supprimeringredientliste($_POST['nomIngre']);
}


if(isset($_GET['idcompte']) AND $_GET['idcompte'] > 0)
{
	$getid = intval($_GET['idcompte']);			//securiser la variable (convertir l'idcompte en nombre)
	$requser = $bdd->prepare('SELECT * FROM compte WHERE idcompte=?');
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();			//va chercher les infos dans requser et les met dans userinfo
	
	if(isset($_SESSION['connecte']) AND !empty($_SESSION['connecte']))
	{
		$connecte = true;
	}
	else
	{
		$connecte = false;
	}
	if(isset($_POST['admin'])){
		$admin = $_POST['admin'];
		header('location:profiladmin.php');
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Mon profil</title>
		<link rel="stylesheet" href="Style_Accueil1.css">
		 <!-- <meta http-equiv="refresh" content="60"> -->			<!-- Auto-refresh -->
	</head>
	<body>
		
		<!-- Header -->
		<div class="header">
			<?php headerPage() ?>
		</div>
		
		<div class="menuGauche">
            <div class="side1">
                <h2 class="centrageTexte" >Vos ingrédients : </h2>

                <form method="POST" action="rechercheIngredient.php" >
                    <input type="search" name="rechingr" class="centrage saisieIngredient" size="20" placeholder=" Rechercher un ingrédient...">
                </form>
                            
            </div>

            <div class="side2">
				<?php 
                if(isset($_SESSION['listeingredient'])){
				foreach($_SESSION['listeingredient'] as $cle=>$valeur){
									echo '<ul>
									<li><form method="POST" action="profil.php">
									<input type="text" name="nomIngre" value="'.$valeur.'" hidden>'
									.$valeur.' <input type="submit" value="Supprimer" name="suppingr"></form></li>
									</ul>';
							}
							if(isset($_SESSION['dejaexist']) AND $_SESSION['dejaexist'] == true){
								if(isset($_SESSION['messg'])){
									echo $_SESSION['messg'];
								}
							}
						}
				?>
            </div>
            
			<div class="side3">
                <form method="POST" action="rechercher.php">
                    <button type=submit name="rechercheViaIngre" id="chercheRecetteIngredient" class="centrage" >
                       Rechercher une recette en fonction de mes ingrédients
                    </button>
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
				Mail : '.$userinfo['mail']. 
				'<br>';
					if(isset($_SESSION['idcompte']) AND $userinfo['idcompte'] == $_SESSION['idcompte'])
					//le "isset($_SESSION['idcompte'])" permet d'obligé d'être connecté -> pas de possibilité de le voir si tu visite le profil sans être connecté
					{
						echo '<a href="editionprofil.php">Editer mon profil</a>
						<a href="deconnexion.php">Se déconnecter</a>';
				
					}
				if ($userinfo['estAdmin']){
					echo '<br><a href="Administration.php">Accéder à l\'administration</a>';
				}
			?>
			</div>

			<!-- Footer -->
			<div class="footer">
				<?php footer() ?>
			</div>
		  </div>


	</body>
</html>
<?php
}
?>
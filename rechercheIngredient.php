<?php
// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require('connexionBDD.php');
// $bdd = connexionUserPDO();
session_start();
if(isset($_SESSION['connecte']) AND !empty($_SESSION['connecte']))
{
	$connecte = true;
}
else
{
	$connecte = false;
}
if(isset($_POST['rechingr']) AND !empty(trim($_POST['rechingr'])))			//trim() -> enlève les espaces de début / fin
{
	$bdd = connexionUserPDO();
	$rechingr = htmlspecialchars($_POST['rechingr']);
	$rep = $bdd->query('SELECT nomIngre FROM ingredients WHERE nomIngre LIKE "%'.$rechingr.'%" ORDER BY idingredient DESC');
	$bdd = NULL;
}
if(isset($_POST['ajtlistingr']))		//bouton d'ajout à la liste d'ingrédient
{
	if(isset($_SESSION['listeingredient'])){
		$_SESSION['listeingredient'][] = $_POST['nomIngre'];
		$listeingredient = $_SESSION['listeingredient'];
	}
	else{
		$_SESSION['listeingredient'] = [];
		$_SESSION['listeingredient'][] = $_POST['nomIngre'];
		$listeingredient = $_SESSION['listeingredient'];
	}
}
?>

<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Accueil Dans Ton Frigo !</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
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
						<input type="search" name="rech" class="saisieRecette" size="50" min="2" placeholder=" Rechercher une recette...">
					</form>
				</div>
				

				<div class="navbar">
						
						<a href="<?php if(empty($connecte)) {?> connexion.php <?php } if(!empty($connecte)) {?> connexionconnecte.php <?php } ?> " class="iconenav centrage lien_icone">
							<img src="Images/compte.png" class="image_icone">
							<p class="icone_texte">Compte</p>
						</a>

						<a href="fake_src" class="iconenav centrage lien_icone">
							<img src="Images/livre_recette.png" class="image_icone">
							<p class="icone_texte">Recettes</p>
						</a>
						
						<a href="fake_src" class="iconenav centrage lien_icone need_help">
							<img src="Images/point_interrogation.png" class="image_icone">
							<p class="icone_texte">Besoin d'aide ?</p>
						</a>
				
				</div>
			</div>
		</div>


		<!-- la grille flexible (content) -->
		<div class="row">
			<div class="side">
				<div class="elemHeader centrage boite_recherche">
					<p>Vos ingrédients</p>
					<form method="POST" action="rechercheIngredient.php" >
						<input type="search" name="rechingr" class="saisieRecette" size="50" min="2" placeholder=" Rechercher un ingrédient...">
					</form>
					
					<?php
						if(isset($listeingredient)) {
							foreach($listeingredient as $cle=>$valeur) {
								echo '<ul>';
								echo '<br><li>'.$valeur.'</li><br>';
								echo '</ul>';
							}
						}
					?>
					
				</div>
			</div>
		  
			<div class="main">
			<h2>Résultats de la recherche :</h2>
				<?php
				if(isset($rep)){
					if($rep->rowCount() > 1){
						echo '<br>'.$rep->rowCount().' résultats trouvés !';
					}
					else{
						echo '<br>'.$rep->rowCount().' résultat trouvé !';
					}
					if($rep->rowCount() > 0) {
						
							echo '<ul>';
							while($a = $rep->fetch()) {
								echo '<li>
								<form method="POST" action="" >
								<input type="text" name="nomIngre" value="'. $a['nomIngre'].'" hidden>
								<p>'. $a['nomIngre'].' <input type="submit" name="ajtlistingr" value="Ajouter à ma liste d\'ingrédients"></p></form></li>';
							}
							echo '</ul>';
						
					}
					else{
						echo '<p>Aucun résultat pour :'. $rechingr.'</p>';
					}
				}
				else{
					echo '<p>Aucun résultat pour :'. $rechingr.'</p>';
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
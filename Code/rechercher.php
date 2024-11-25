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
if(isset($_POST['rech'])){
	$rech = htmlspecialchars($_POST['rech']);
}

if(isset($_POST['rech']) AND !empty(trim($_POST['rech'])))			//trim() -> enlève les espaces de début / fin
{
	$bdd = connexionUserPDO();
	$rech = htmlspecialchars($_POST['rech']);
	$rep = $bdd->query('SELECT nomRecette FROM recettes WHERE nomRecette LIKE "%'.$rech.'%" ORDER BY idrecette DESC');
	$bdd = NULL;
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
						<input type="search" name="rech" class="saisieRecette" size="50" placeholder=" Rechercher une recette...">
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
						
						<a href="Besoin_daide.php" class="iconenav centrage lien_icone need_help">
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
						<input type="search" name="rechingr" class="saisieRecette" size="50" placeholder=" Rechercher un ingrédient...">
					</form>
				</div>
			</div>
		  
			<div class="main">
			<?php
				if(isset($rep)){
					echo'<h2>Résultats de la recherche :</h2>';
					if($rep->rowCount() > 0){
						echo'<ul>';
							while($a = $rep->fetch()) {
							echo '<li> 
							<div class="RecetteGauche">
								<h2>'.$nomRecette.'</h2>
								<div class="recette-img">
									<img src="" alt="Illustration de la recette">
								</div>
								<p>';
								if($a['nomRecette'] == "Pot au feu"){
									echo 'Pot au feu blablabla';
								}
								echo '</p>
							</div>
							<div class="RecetteDroite">
								<div class="recette-info">
									<div class="recette-difficulte">
										<span>Difficulté :</span>
										<span>'.$difficulte.'/5</span>
									</div>
									<br>
									<div class="recette-temps">
										<span>Temps :</span>
										<span>'.$tempsTotal.' minutes</span>
									</div>
								</div>

								<ul>';
									for($i=0;$i<count($tabingr) && $cpt!=3;$i++){
										echo '<li>'.$tabingr[$i]["nomIngre"].'</li>';
										$cpt++;
									}
									if($cpt>0){
										$cpt=0;
									}
								echo '</ul>
							</div>
							</li>';
							}
						echo '</ul>';
					}
					else {
					echo '<p>Aucun résultat pour : '.$rech.' </p>';
					}
				}
				else{
					echo '<p>Aucun résultat pour : '.$rech.'</p>';
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
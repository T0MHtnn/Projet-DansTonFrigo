<?php
require_once('connexionBDD.php');
require_once('FonctionsTOM.php');
require_once('fonctionsRecherches.php');
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
/*Barre recherche ingrédients*/
if(isset($_POST['rechingr'])){
	$rechingr = htmlspecialchars($_POST['rechingr']);
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
		$nomIngre = htmlspecialchars($_POST['nomIngre']);
		if(in_array($nomIngre,$_SESSION['listeingredient'])){
			$dejaexist = true;
		}
		else{
			$dejaexist = false;
		}
		if($dejaexist == false){
			$_SESSION['listeingredient'][] = $nomIngre;
			$listeingredient = $_SESSION['listeingredient'];
		}
		else{
			$messg = '<ul><li><font color="blue">'.$nomIngre.' est déja présent dans vos ingrédients</font></li></ul>';
		}
	}
	else{
		$_SESSION['listeingredient'] = [];
		$_SESSION['listeingredient'][] = $_POST['nomIngre'];
		$listeingredient = $_SESSION['listeingredient'];
	}
	

}
/*Bouton supprimer ingredients de la liste*/
/* Ne fonctionne pas */
if(isset($_POST['suppingr'])){
	supprimeringredientliste($_POST['nomIngre']);
	/*
	$nomIngre = htmlspecialchars();
	if(in_array($nomIngre,$_SESSION['listeingredient'])){
		unset($_SESSION['listeingredient'][array_search($nomIngre, $_SESSION['listeingredient'])]);
	}
	else{
		echo 'bug';
	}*/
}
/*Barre recherche recette*/
if(isset($_POST['rech'])){
	$rech = htmlspecialchars($_POST['rech']);
}

if(isset($_POST['rech']) AND !empty(trim($_POST['rech'])))			//trim() -> enlève les espaces de début / fin
{
	$bdd = connexionUserPDO();
	$rech = htmlspecialchars($_POST['rech']);
	$rep = $bdd->query('SELECT nomRecette FROM recettes WHERE nomRecette LIKE "%'.$rech.'%" ORDER BY idrecette DESC');	//Query = prepare + execute en 1 fonction
	
	$requete = $bdd->prepare("SELECT * FROM recettes WHERE nomRecette LIKE ?");
	$requete->execute(array('%'.$_POST['rech'].'%'));
	
	$infosutili = $requete->fetchAll(PDO::FETCH_ASSOC);			//Récup infos sous forme tableau associatif
	foreach($infosutili as $recette){
		$idrecette = $recette['idrecette'];
		$nomRecette = $recette['nomRecette'];
		$tempsPrepa = $recette['tempsPrepa'];
		$tempsCuisson = $recette['tempsCuisson'];
		$tempsRepos = $recette['tempsRepos'];
		$tempsTotal = $recette['tempsTotal'];
		$noteGlobale = $recette['noteGlobale'];
		$nbNotes = $recette['nbNotes'];
		$difficulte = $recette['difficulte'];
		$nbPersonnes = $recette['nbPersonnes'];
	}
	$tabingr = renvoieIngredientsRecette($nomRecette);
	if(!isset($cpt)){
		$cpt=0;
	}
	$bdd = NULL;
}
?>

<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<title>Dans Ton Frigo !</title>
		<link href="Style_Accueil.css" rel="stylesheet">
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
					<form method="POST" action="" >
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
						
						<a href="bsoindaid.php" class="iconenav centrage lien_icone need_help">
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
			<?php
			if(isset($rechingr)){
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
			}
			
		
			
			if(isset($rech)){
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
			}
			if(!isset($rechingr) AND !isset($rech)){
				mainAccueil();
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
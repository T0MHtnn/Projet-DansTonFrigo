<?php
// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require_once('connexionBDD.php');
require_once('component.php');
require_once('fonctionsRecherches.php');
require_once('FonctionsTOM.php');

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
	//$rep = $bdd->query('SELECT nomRecette FROM recettes WHERE nomRecette LIKE "%'.$rech.'%" ORDER BY idrecette DESC');	//Query = prepare + execute en 1 fonction
	
	$requete = $bdd->prepare("SELECT * FROM recettes WHERE nomRecette LIKE ?");
	$requete->execute(array('%'.$_POST['rech'].'%'));
	
	$tabRecettes = $requete->fetchAll(PDO::FETCH_ASSOC);			//Récup infos sous forme tableau associatif

	$bdd = NULL;
}

if(isset($_POST['rechercheViaIngre']) AND !empty($_SESSION['listeingredient']))			//trim() -> enlève les espaces de début / fin
{
	$bdd = connexionUserPDO();
	
	$sql = "SELECT * FROM recettes 
			INNER JOIN compose ON recettes.idrecette = compose.idrecette 
			INNER JOIN ingredients ON ingredients.idingredient = compose.idingredient 
			WHERE nomIngre LIKE ";
				
	$prems = true;
	foreach($_SESSION['listeingredient'] as $key => $nomIngre){
		if($prems){
			$sql.=" ? ";
			$prems=false;
		}
		else{
			$sql.="OR nomIngre LIKE ? ";
		}
	}
	
	$requete = $bdd->prepare($sql);
	$requete->execute($_SESSION['listeingredient']);
	
	$tabRecettes = $requete->fetchAll(PDO::FETCH_ASSOC);			//Récup infos sous forme tableau associatif

	$bdd = NULL;
}

/*Bouton supprimer ingredients de la liste*/

if(isset($_POST['suppingr'])){
	supprimeringredientliste($_POST['nomIngre']);
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
			<?php HeaderPage(); ?>
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
									<li><form method="POST" action="rechercher.php">
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
			<?php
			if(isset($rech) || isset($_POST['rechercheViaIngre'])){
					echo'<h2>Résultats de la recherche :</h2>';
					if(!empty($tabRecettes)){
						echo'<ul>';
						foreach($tabRecettes as $key => $recette) {
							$tabingr = renvoieIngredientsRecette($recette['nomRecette']);
							$cpt=0;
							$tabImg = renvoieImagesViaNomRecette($recette['nomRecette']);
							if(!empty($tabImg)){
								$image=$tabImg[0];
								$imagePresente=true;
							}
							else{
								$imagePresente=FALSE;
							}
	
							echo '<li> 
							<div class="RecetteGauche">
								<h2>'.$recette['nomRecette'].'</h2>
								<div class="recette-img">';
							if($imagePresente){
								echo '<img src="'.$image['imgRecetteChemin'].'" alt="'.$image['imgRecetteDesc'].'">';
							}
							else{
								echo '<img src="fake_src" alt="Pas d\'images pour cette recette">';
							}
														
							echo '</div><p>'. $recette['nomRecette'].'</p>';
							
							echo '
							</div>
							<div class="RecetteDroite">
								<div class="recette-info">
									<div class="recette-difficulte">
										<span>Difficulté :</span>
										<span>'.$recette['difficulte'].'/5</span>
									</div>
									<br>
									<div class="recette-temps">
										<span>Temps :</span>
										<span>'.$recette['tempsTotal'].' minutes</span>
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
							</li><br>';
						}
						echo '</ul>';
					}
					else {
					echo '<p>Aucun résultat</p>';
					}
			}
			
			?>
			<!-- Footer -->
			<div class="footer">
			  <?php footer(); ?>
			</div>
		</div>
				
	</body>
</html>
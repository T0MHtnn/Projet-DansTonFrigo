<?php
session_start();
if(isset($_SESSION['user']) AND !empty($_SESSION['user']))
{
	$connecte = true;
}

require_once('component.php');

require_once('affichageTabResult.php');
require_once('connexionBDD.php');
require_once('fonctionsInsertions.php');
require_once('fonctionsRecherches.php');
require_once('affichageForm.php');
require_once('fonctionsSuppression.php');
require_once('fonctionsModif.php');
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Modification des images des ingrédients</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>

	<body>
		
		<!-- Header -->
		<div class="header">
			<?php HeaderPage(); ?>
		</div>


		<!-- Side -->
		<div class="menuGauche">
		 	<?php SlideBarGauche("Side2"); ?>
		</div>
		  
		  <div class="main">
			
			<form id="formulaire" action="ModifImageIngre.php" method="post">
				<div class="block"><p><label>Cherchez une image : <input type="text" name="nomImage" class="input-res" size='50' maxlength='50'></label></p></div>

				<input type="submit" name='boutonRecherche' class="bouton" value="Rechercher">
				<input type="submit" name='boutonAjoutImage' class="bouton" value="Ajouter une image d'ingrédient">
			</form>
			<hr>
			
			<?php
				if ( isset( $_POST ) && (count( $_POST ) >= 1) && ( isset($_POST['boutonRecherche']))){ 
					//ce test regarde si on a fait la 1ere recherche de la page
					afficheImageIngreModif($_POST['nomImage']); 
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifier"])){
					if (isset($_POST['idimgIngre'])){
						
						$image=renvoieImageIngreViaId($_POST['idimgIngre']);			
						if ($image != NULL){
							//affichage du formulaire de l'image
							afficheFormImageIngre($image); 
						}
						else{
							echo '<h2>'."Pas d'image trouvée".'</h2>';
						}
					}
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifierImageIngredient"])){
					$oldImage = renvoieImageIngreViaId($_POST['idimgIngre']); //permet de récupérer l'image sans les changements

					$tabNewImage['imgIngreNom']=trim($_POST['imgIngreNom']); $tabNewImage['imgIngreDesc']=trim($_POST['imgIngreDesc']); 
					$tabNewImage['imgIngreChemin']=trim($_POST['imgIngreChemin']); $tabNewImage['idimgIngre'] = $_POST['idimgIngre'];
					
					modifImageIngre($tabNewImage, $oldImage); 
						
					$image = renvoieImageIngreViaId($_POST['idimgIngre']);
					afficheFormImageIngre($image);
					
				}

				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && (isset($_POST["boutonSupprimer"]))){ //suppression de l'image dans la base
						
					supprimerImageIngre($_POST["idimgIngre"]);
					echo "Suppression effectuée";
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonAjoutImage"]))){ //affichage du formulaire pour ajouter une image
					afficheFormAjoutImageIngre();
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonInsertionImage"]))){ //insertion d'une image dans la base
					
					//tableau propre pour l'insertion de l'image
					$tabNewImage['imgIngreNom']=trim($_POST['imgIngreNom']); $tabNewImage['imgIngreDesc']=trim($_POST['imgIngreDesc']); 
					$tabNewImage['imgIngreChemin']=trim($_POST['imgIngreChemin']);
					
					if(isset($_POST['nomIngre'])) { //vérification si l'admin à lié une recette ou pas (car c'est facultatif)
						$idingre = rechercheIdIngredient($_POST['nomIngre']); 
						if($idingre!=NULL){ //test si l'ingrédient choisi existe
							$tabNewImage['idingredient']=$idingre;						
						}
						else echo '<p>Impossible de trouver un ingrédient correspondant au nom saisie, l\'image n\'est donc liée à aucun ingrédient</p>';	
					}

					
					if(insertImageIngre($tabNewImage)){ 
						echo '<p>Insertion réussie ! </p>';
					}
					else{
						echo '<p>Insertion impossible ! </p>';
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



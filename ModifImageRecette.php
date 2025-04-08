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
		<title>Modification des images de recette</title>
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
			
			<form id="formulaire" action="ModifImageRecette.php" method="post">
				<div class="block"><p><label>Cherchez une image : <input type="text" name="nomImage" class="input-res" size='50' maxlength='50'></label></p></div>

				<input type="submit" name='boutonRecherche' class="bouton" value="Rechercher">
				<input type="submit" name='boutonAjoutImage' class="bouton" value="Ajouter une image de recette">
			</form>
			<hr>
			
			<?php
				if ( isset( $_POST ) && (count( $_POST ) >= 1) && ( isset($_POST['boutonRecherche']))){ 
					//ce test regarde si on a fait la 1ere recherche de la page
					afficheImageRecetteModif($_POST['nomImage']); 
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifier"])){
					if (isset($_POST['idimgRecettes'])){
						
						$image=renvoieImageRecetteViaId($_POST['idimgRecettes']);						
						if ($image != NULL){
							//affichage du formulaire de l'image
							afficheFormImageRecette($image);	
						}
						else{
							echo '<h2>'."Pas d'image trouvée".'</h2>';
						}
					}
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifierImageRecette"])){
					
					$oldImage = renvoieImageRecetteViaId($_POST['idimgRecettes']); //permet de récupérer l'image sans les changements
					
					$tabNewImage['imgRecetteNom']=trim($_POST['imgRecetteNom']); $tabNewImage['imgRecetteDesc']=trim($_POST['imgRecetteDesc']); 
					$tabNewImage['imgRecetteChemin']=trim($_POST['imgRecetteChemin']); $tabNewImage['idimgRecettes'] = $_POST['idimgRecettes'];
					
					modifImageRecette($tabNewImage, $oldImage);
						
					$image = renvoieImageRecetteViaId($_POST['idimgRecettes']);
					afficheFormImageRecette($image);					
				}

				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && (isset($_POST["boutonSupprimer"]))){
						
					supprimerImageRecette($_POST['idimgRecettes']);
					echo "Suppression effectuée";
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonAjoutImage"]))){
					afficheFormAjoutImageRecette(); 
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonInsertionImage"]))){
					
					//tableau propre pour l'insertion de l'image
					$tabNewImage['imgRecetteNom']=trim($_POST['imgRecetteNom']); $tabNewImage['imgRecetteDesc']=trim($_POST['imgRecetteDesc']); 
					$tabNewImage['imgRecetteChemin']=trim($_POST['imgRecetteChemin']);
					
					if(isset($_POST['nomRecette'])) { //vérification si l'admin à lié une recette ou pas
						$idrecette = rechercheIdRecette($_POST['nomRecette']);
						if($idrecette!=NULL){
							$tabNewImage['idrecette']=$idrecette;						
						}
						else echo '<p>Impossible de trouver une recette correspondante au nom saisie, l\'image n\est donc liée à aucune recette</p>';	
					}

					
					if(insertImageRecette($tabNewImage)){ 
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



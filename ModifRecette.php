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
		<title>Modification recette</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>

	<body>
		
		<!-- Header -->
		<div class="header">
			<?php headerPage(); ?>
		</div>
		
		<!-- Side -->
		<div class="menuGauche">
		 	<?php SlideBarGauche("Side2"); ?>
		</div>


		<!-- main -->
		  <div class="main">
			<br>
			<form id="formulaire" action="ModifRecette.php" method="post">
				<div class="block"><p>Cherchez une recette : <input type="text" name="nomRecette" size='50' maxlength='80' class='input-res'></p></div>
				<input type="submit" name="boutonRecherche" class="bouton" value="Valider">
				<input type="submit" name="boutonAjoutRecette" class="bouton" value="Ajouter une recette">
			</form>
			
			<hr>
				<?php
					//Amélioration, changer toutes les fonctions ou on utilise $nomRecette par idrecette, ca permettrait d'être plus efficace je pense et éviter de recherche l'id plein de fois
					if ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonRecherche']))){ 
						//ce test regarde si on a fait la 1ere recherche de la page
						afficheRecettesModif($_POST['nomRecette']);
					}

					
					if ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifier']))){ 
					//test si le formulaire envoyé est correspond au choix d'une recette parmi les recette renvoyés lors de la recherche
							
						if (isset($_POST['nomRecette'])){
							$recette = renvoieRecette($_POST['nomRecette']);
							
							if ($recette != NULL){								
								//affichage de tout les formulaires de recette
								afficheFormRecetteALL($recette);
							}
							else
								echo '<h2>'."Pas de recette trouvée".'</h2>';
						}
					}
				
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifRecette']))){
						
					//l'ancienne recette est sauvegardé dans $_POST['oldrecette']
						$ancienne_recette = $_POST['oldrecette'];

					// création d'un tableau propre qui va reprendre toutes les infos de la nouvelle recette renvoyé par $_POST, fonctionne comme $recette
					// le principe des éléments de la forme $recette c'est que ce sont des tableaux avec comme clé les noms des attributs de la table Recettes
						$_POST['newrecette']['nomRecette'] = trim($_POST['newrecette']['nomRecette']);
						$tabrecette=$_POST["newrecette"]; 
											
					// check de si la recette avec les nouvelles infos existe déja ou pas, si non lance les modifications
						if($tabrecette['nomRecette'] != $ancienne_recette['nomRecette']){
							if (rechercheIdRecette($tabrecette['nomRecette']) == NULL){ //test si le nouveau nom de recette n'existe pas déja
								modifRecette($ancienne_recette, $tabrecette);
								
								echo "Changements effectués";
								
								afficheFormRecetteALL($tabrecette);
							}
							else{
								echo "Une recette existe déja avec ce nom";
								afficheFormRecetteALL($ancienne_recette);
							}
						}
						else{
							echo "Changements effectués";
							modifRecette($ancienne_recette, $tabrecette);
							
							afficheFormRecetteALL($tabrecette);
						}
					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifPrerequisRecette']))){
												
						$recette = renvoieRecette($_POST['nomRecette']);
						$_POST['prerequis']['descEtape'] = trim($_POST['prerequis']['descEtape']);
						$tab[] = $_POST["prerequis"];
						modifAttributEtapes($tab); 
						
						echo 'Changements des prérequis effectué';
						afficheFormRecetteALL($recette);
					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifEtapesRecette']))){
																	
						$recette = renvoieRecette($_POST['nomRecette']);
						
						modifEtapesRecette($_POST["etapes"], $recette['idrecette']); 
						
						echo 'Changements des étapes effectué';
						afficheFormRecetteALL($recette);

					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifIngreRecette']))){
						$recette = renvoieRecette($_POST['nomRecette']);
						
						modifLiensIngredientRecette($_POST['ingredients'], $recette['idrecette']);
						
						echo 'Changements des ingrédients effectué';
						afficheFormRecetteALL($recette);

					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifUstensileRecette']))){
																	
						$recette = renvoieRecette($_POST['nomRecette']);
						
						modifLiensUstensileRecette($_POST['ustensiles'], $recette['idrecette']);
						
						echo 'Changements des ustensiles effectué';
						afficheFormRecetteALL($recette);

					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonSuppressionRecette']))){
						
						supprimerRecette($_POST['oldrecette']['nomRecette']);
						echo 'Recette supprimée !';
					}
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonSuppressionPrerequisRecette']))){
						supprimerEtapesRecette($_POST['prerequis']['idetape'], NULL);
						echo 'Suppression effectuée';
						
						echo '<form id="formulaire" action="ModifRecette.php" method="post">';
						echo '<input type="hidden" name="nomRecette" value="'.$_POST['nomRecette'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur la recette">';
						echo '</form>';
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutRecette']))){
						afficheFormAjoutRecette();
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonInsertionRecette']))){
						if(insertRecette($_POST['recette'])){
							echo '<p>Insertion réussie ! </p>';
							echo '<form id="formulaire" action="ModifRecette.php" method="post">';
							echo '<input type="hidden" name="nomRecette" value="'.$_POST['recette']['nomRecette'].'">';
							echo '<input type="submit" name="boutonModifier" class="bouton" value="Aller sur la page de '.$_POST['recette']['nomRecette'].'">';
							echo '</form>';
						}
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutEtapeRecette']))){
						afficheFormAjoutEtapeRecette($_POST['nomRecette']);
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonInsertionEtapeRecette']))){
						$etape["descEtape"]=trim($_POST["descEtape"]);
						$etape["numEtape"]=$_POST["numEtape"];
						$etape["idrecette"]=$_POST["idrecette"];
						
						insertEtapeRecette($etape["idrecette"], $etape);
						echo '<p>Insertion réussie ! </p>';
						echo '<form id="formulaire" action="ModifRecette.php" method="post">';
						echo '<input type="hidden" name="nomRecette" value="'.$_POST['nomRecette'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur la recette">';
						echo '</form>';
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutPrerequisRecette']))){
						afficheFormAjoutPrerequisRecette($_POST['nomRecette']);
					}
					
					
					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonSupprimerImageRecette']))){
						supprimerLienImageRecette(NULL, $_POST["idimgRecettes"]);
						echo 'Suppression effectuée';
						
						echo '<form id="formulaire" action="ModifRecette.php" method="post">';
						echo '<input type="hidden" name="nomRecette" value="'.$_POST['nomRecette'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur la recette">';
						echo '</form>';
					}
					
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutLienImageRecette']))){
						afficheFormAjoutLienImageRecette($_POST['nomRecette']);
					}
					
					elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonInsertionLienImageRecette']))){
						
						$idrecette = rechercheIdRecette($_POST['nomRecette']);
						
						if(insertLienImageRecette(trim($_POST["imgRecetteNom"]), $idrecette)){
							echo '<form id="formulaire" action="ModifRecette.php" method="post">';
							echo '<input type="hidden" name="nomRecette" value="'.$_POST['nomRecette'].'">';
							echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur la recette">';
							echo '</form>';
						}
						else{
							echo '<form id="formulaire" action="ModifRecette.php" method="post">';
							echo '<input type="hidden" name="nomRecette" value="'.$_POST['nomRecette'].'">';
							echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur la recette">';
							echo '</form>';	
						}
					}

					elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifCateg']))){
																	
						$recette = renvoieRecette($_POST['nomRecette']);
						
						modifLiensCategRecette($_POST['categories'], $recette['idrecette']); 
						
						echo 'Changements des catégories effectué';
						afficheFormRecetteALL($recette);

					}
					
				?>
			<div class="footer">
				<?php footer(); ?>
			</div>
		  </div>
	</body>
</html>



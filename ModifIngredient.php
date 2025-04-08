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
		<title>Modification des ingrédients</title>
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
			
			<form id="formulaire" action="ModifIngredient.php" method="post">
				<div class="block"><p>Cherchez un ingredient : <input type="text" name="nomIngre" class="input-res" size='50' maxlength='50'></p></div>
				<input type="submit" name="boutonRecherche" class="bouton" value="Valider">
				<input type="submit" name="boutonAjoutIngre" class="bouton" value="Ajouter un ingredient">
			</form>
			
			<hr>
			
			<?php
				if ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonRecherche']))){ 
					//ce test regarde si on a fait la 1ere recherche de la page
					afficheIngredientsModif($_POST['nomIngre']);
				}
					
				if ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifier']))){ 
				//test si le formulaire envoyé correspond au choix d'un ingrédient parmi les ingrédients renvoyés lors de la recherche
						
					if (isset($_POST['nomIngre'])){
						$ingredient = renvoieIngredient($_POST['nomIngre']); //j'ai séparé l'id du reste des attributs car je veux un tableau avec seulement les attributs pour pouvoir boucler dessus facilement
							
						if ($ingredient != NULL){								
							//affichage de tout les formulaires liées à ingrédient
							afficheFormIngredient($ingredient);
							afficheFormImagesOfIngredient($ingredient['nomIngre']);
							afficheFormCategIngredient($ingredient['nomIngre']);
								
						}
						else
							echo '<h2>'."Pas d'ingrédient trouvée".'</h2>';
					}
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifIngre']))){
						
					//l'ancien ingrédient est sauvegardé dans $_SESSION['ingredient']
						$ancien_ingredient = $_POST['oldingre'];

					// création d'un tableau propre qui va reprendre toutes les infos de la recette renvoyé par $_POST, fonctionne comme $recette
					// le principe des éléments de la forme $ingredient c'est que ce sont des tableaux avec comme clé les noms des attributs de la table Ingredients
						$_POST['newingre']['nomIngre'] = trim($_POST['newingre']['nomIngre']);
						$tabingredient=$_POST['newingre'];
												
					// check de si l'ingrédient avec les nouvelles infos existe déja ou pas, si non lance les modifications
						if($tabingredient['nomIngre'] != $ancien_ingredient['nomIngre']){
							if (renvoieIngredient($tabingredient['nomIngre']) == NULL){ 
								modifIngredient($ancien_ingredient, $tabingredient); 
								
								echo '<p class="texteGras">Modifications réussies !<p>';
								afficheFormIngredient($tabingredient);
								afficheFormImagesOfIngredient($tabingredient['nomIngre']);
								afficheFormCategIngredient($tabingredient['nomIngre']);

							}
							else{
								echo "<p class='texteGras'>Un ingrédient existe déja avec ce nom, impossible de réaliser les modifications<p>";
								afficheFormIngredient($ancien_ingredient);
								afficheFormImagesOfIngredient($ancien_ingredient['nomIngre']);
								afficheFormCategIngredient($ancien_ingredient['nomIngre']);
							}
						}
						else{
							modifIngredient($ancien_ingredient, $tabingredient);
							
							echo '<p class="texteGras">Modifications réussies !<p>';
							afficheFormIngredient($tabingredient);
							afficheFormImagesOfIngredient($tabingredient['nomIngre']);
							afficheFormCategIngredient($tabingredient['nomIngre']);
						}
				}

				elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonSuppressionIngre']))){
						
					supprimerIngredient($_POST['oldingre']['nomIngre']);
					echo 'Suppression réussie';
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutIngre']))){
					afficheFormAjoutIngredient();
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonInsertionIngre']))){
					if(insertIngredient($_POST['ingre'])){
						echo '<p>Insertion réussie ! </p>';
						echo '<form id="formulaire" action="ModifIngredient.php" method="post">';
						echo '<input type="hidden" name="nomIngre" value="'.$_POST['ingre']['nomIngre'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Aller sur la page de '.$_POST['ingre']['nomIngre'].'">';
						echo '</form>';
					}
				}
				
									
				elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonSupprimerImageIngre']))){
					supprimerLienImageIngre(NULL, $_POST["idimgIngre"]);
					echo 'Suppression effectuée';
						
					echo '<form id="formulaire" action="ModifIngredient.php" method="post">';
					echo '<input type="hidden" name="nomIngre" value="'.$_POST['nomIngre'].'">';
					echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur l\'ingrédient">';
					echo '</form>';
				}
					
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonAjoutLienImageIngre']))){
					afficheFormAjoutLienImageIngre($_POST['nomIngre']); 
				}
					
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && ( isset($_POST['boutonInsertionLienImageIngre']))){
						
					$idingre = rechercheIdIngredient($_POST['nomIngre']);
						
					if(insertLienImageIngre(trim($_POST["imgIngreNom"]), $idingre)){
						echo '<form id="formulaire" action="ModifIngredient.php" method="post">';
						echo '<input type="hidden" name="nomIngre" value="'.$_POST['nomIngre'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur l\'ingrédient">';
						echo '</form>';
					}
					else{
						echo '<form id="formulaire" action="ModifIngredient.php" method="post">';
						echo '<input type="hidden" name="nomIngre" value="'.$_POST['nomIngre'].'">';
						echo '<input type="submit" name="boutonModifier" class="bouton" value="Retourner sur l\'ingrédient">';
						echo '</form>';	
					}
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) > 1) && ( isset($_POST['boutonModifCateg']))){ 												
					$ingredient = renvoieIngredient($_POST['nomIngre']);
					
					modifLiensCategIngredient($_POST['categories'], $ingredient['idingredient']);
						
					echo 'Changements des catégories effectué';
						afficheFormIngredient($ingredient);
						afficheFormImagesOfIngredient($ingredient['nomIngre']);
						afficheFormCategIngredient($ingredient['nomIngre']);
				}
									
			?>
			
			<!-- Footer -->
			<div class="footer">
			  <?php footer(); ?>
			</div>
		  </div>
				
	</body>
</html>



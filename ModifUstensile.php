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
			
			<form id="formulaire" action="ModifUstensile.php" method="post">
				<div class="block"><p><label>Cherchez un ustensile : <input type="text" name="nomUstensile" class="input-res" size='50' maxlength='50'></label></p></div>

				<input type="submit" name='boutonRecherche' class="bouton" value="Rechercher">

				<input type="submit" name='boutonAjoutUstensile' class="bouton" value="Ajouter un ustensile">
			</form>
			<hr>
			
			<?php
				if ( isset( $_POST ) && (count( $_POST ) >= 1) && ( isset($_POST['boutonRecherche']))){ 
					//ce test regarde si on a fait la 1ere recherche de la page
					afficheUstensilesModifSupp($_POST['nomUstensile']);
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifier"])){
					// check de si l'ustensile avec les nouvelles infos existe déja ou pas, si non lance les modifications
					$_POST['nomUstensileApres'] = trim($_POST['nomUstensileApres']);
					if($_POST["nomUstensileAvant"] != $_POST["nomUstensileApres"]){
						if (rechercheIdUstensile($_POST["nomUstensileApres"]) == NULL){ 
							modifUstensile($_POST["nomUstensileAvant"], $_POST["nomUstensileApres"]);  
							echo "Nom d'ustensile modifié";
						}
						else{
							echo "Un ustensile existe déja avec ce nom";
						}
					}
					else{
						echo "Nom inchangé pour l'ustensile : ".$_POST["nomUstensileAvant"];
					}
				}

				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && (isset($_POST["boutonSupprimer"]))){
						
					supprimerUstensile($_POST["nomUstensileAvant"]);
					echo "Suppression effectuée";
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonAjoutUstensile"]))){
					afficheFormAjoutUstensile();
				}
				
				elseif ( isset( $_POST ) &&( count( $_POST ) > 0) && (isset($_POST["boutonInsertionUstensile"]))){
					if(insertUstensile($_POST["nomUstensile"])){
						echo '<p>Insertion réussie ! </p>';
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



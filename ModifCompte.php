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
			
			<form id="formulaire" action="ModifCompte.php" method="post">
				<p><label>Cherchez un compte via son nom utilisateur : <input type="text" name="nomUtilisateur"></label></p>

				<p><input type="submit" name='boutonRecherche' class="bouton" value="Rechercher"></p>
				
				<fieldset>
					<legend>Appliquer un filtre sur les comptes : </legend>
					
					<div>
					  <input type="radio" id="boutonNoFilter" name="filter" value="NoFilter" checked>
					  <label for="boutonNoFilter">Pas de filtres</label>
					</div>
					
					<div>
					  <input type="radio" id="boutonClient" name="filter" value="Client">
					  <label for="boutonClient">Client</label>
					</div>

					<div>
					  <input type="radio" id="boutonAdmin" name="filter" value="Admin">
					  <label for="boutonAdmin">Admin</label>
					</div>
					
				</fieldset>
				<hr>
			</form>
			
			<?php
				if ( isset( $_POST ) && (count( $_POST ) >= 1) && ( isset($_POST['boutonRecherche']))){ 
					//ce test regarde si on a fait la 1ere recherche de la page
					afficheComptes($_POST['nomUtilisateur'], $_POST['filter']);
				}
				
				elseif ( isset( $_POST ) && (count( $_POST ) >= 1) && isset($_POST["boutonModifAdmin"])){
					// check de si l'ustensile avec les nouvelles infos existe déja ou pas, si non lance les modifications
					modifDroitsCompte($_POST['idcompte']);
					echo 'Changements effectués';
				}
										
			?>
			
			<!-- Footer -->
			<div class="footer">
			  <?php footer(); ?>
			</div>
			
		  </div>
				
	</body>
</html>



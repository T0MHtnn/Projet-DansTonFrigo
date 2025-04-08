<?php

session_start();
if(isset($_SESSION['user']) AND !empty($_SESSION['user']))
{
	$connecte = true;
}

require('component.php');
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Administration</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>

	<body>
		
		<!-- Header -->
		<div class="header">
			<?php headerPage(); ?>
		</div>


		<!-- la grille flexible (content) -->
		<div class="menuGauche">
		 	<?php SlideBarGauche("Side2"); ?>
		</div>
		  
		  
		  
		<div class="main">

			<h1> Administration </h1>
			<p> Ceci est la page d'administration, pour naviguer parmi les différentes pages de gestion veuillez utiliser le tableau d'administration. </p>
			<p> Quelques consignes : </p>
			<ul>
				<li> Veuillez faire attention à ce que les éléments que vous ajoutez n'existent pas déja, même sous des noms légèrement différents </li>
				<li> De même pour les changements de nom, faites attention à ce qu'ils n'existent pas déja </li>
				<li> Toute suppression est définitive et un retour en arrière signifie réimplémenter l'élément, alors réflechissez 2 fois avant de cliquer ;) </li>
			</ul>
		
			<!-- Footer -->
			<div class="footer">
			<?php footer(); ?>
			</div>

		</div>

				
	</body>
</html>



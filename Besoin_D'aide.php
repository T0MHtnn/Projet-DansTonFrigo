<?php
require ('component.php');
session_start();
?>

<!DOCTYPE html
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Besoin d'aide ? : Dans Ton Frigo !</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		
	</head>

	<body>
		<!-- Header -->
		<div class="header">
			<?php HeaderPage(); ?>
		</div>
		
		
		<div class="menuGauche">
		<?php SlideBarGauche("Side3"); ?>
			<!--
			<a href="Accueil.php" style="text-decoration:none; color:white; font-family:Handlee"><font size="+3">
				<p class="icone_texte" >retour à l'accueil</p></font>
				</a>
				<hr>
				<br>
			<a href="#RC" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Recherche compliquée</div></font></a><br>
			<a href="#F" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Favoris</div></font></a><br>
			<a href="#R" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Recettes</div></font></a><br>
			<a href="#E" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Emploi du temps</div></font></a><br>
			<a href="#CO" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Un compte est-il obligatoire ?</div></font></a><br>
			<a href="#BPA" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Besoin de plus d'aide ? Contactez-Nous</div></font></a><br>
			<a href="#DM" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Devenir Modérateur</div></font></a><br>
			<a href="#C" style="text-decoration:none; color:white; font-family:Handlee"><font size="+1"><div class="centrageTexte" style="height:65px;">Crédits</div></font></a><br>
			</hr><br> -->
		</div>


		<div class="main">
			<h1> FAQ </h1>
			
			<div id="RC"><h2> Recherche compliquée ?</h2></div>
			
			<p> La recherche de recettes est très simple à comprendre, il vous suffit d'écrire dans la barre de 
			recherche le nom de la recette que vous souhaitez et le site vous affichera une liste de recettes 
			comportant le même nom. </p><br>
			
			<div id="F"><h2> Favoris </h2></div>
			
			<p> "Favoris" vous permet de choisir des recettes pour les garder de coté afin de pouvoir les réutiliser
			sans avoir à rechercher ces même recettes afin de pouvoir les réutiliser pour de futures journées parce 
			que vous adorez ces recettes. </p> <br>
			
			
			<div id="R"><h2> Recettes </h2></div>
			
			<p> "Recettes" offre une sélection de recettes afin de vous permettre de trouver tout ce que vous souhaitez 
			manger. Pour trouver une recette spécifique il vous suffit de chercher la recette que vous voulez dans la 
			barre de recherche. </p> <br>
			
			<div id="E"><h2> Emploi du temps </h2></div>
			
			<p> L'emploi du temps vous permet de selectionner des recettes que vous definissez pour chaque jour de 
			la semaine. Cela vous permet donc de préparer une semaine entière sans avoir à vous demander ce que vous 
			allez manger ce soir. </p> <br>
			
			<div id="CO"><h2> Un compte est-il obligatoire ? </h2></div>
			
			<p> La recherche de recettes sur le site ne requiert pas de compte. Cependant, si vous souhaitez utiliser les 
			fonctionnalités "Favoris" ainsi qu' "emploi du temps" alors un compte est obligatoire car ces fonctionnalités 
			restes avec le compte associé. </p> <br>
			
	
			<div id="BPA"><h1> Besoin de plus d'aide ? Contactez-Nous ! </h1></div>
			
			<p> Si vous avez du mal avec le site ou que vous rencontrez des problèmes avec le site et que vous avez besoin 
			de plus d'aide contactez-nous à: random@gmail.com.</p>
			
			<div id="DM"><h1> Devenir Modérateur </h1></div>
			
			<p> Afin de devenir modérateur il vous faut envoyer un mail avec le titre "Je souhaite devenir modérateur." en 
			précisant vos possibles précédentes modérations ainsi que la raison pour laquelle vous souhaitez devenir modérateur.</p>
			
			<div id="C"><h1> Crédits </h1></div>
			
			<p> La création de ce site a été possible grâce à:<br>
				
				<a class="fin" href="mailto:jules.forest@etu.univ-tours.fr"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> Jules Forest<br>
				<a class="fin" href="mailto:rachel.lecomte@etu.univ-tours.fr"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> Rachel Lecomte<br>
				<a class="fin" href="mailto:tom.hatonton@etu.univ-tours.fr"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> Tom Haton<br>
				<a class="fin" href="mailto:ilkan.aktar@etu.univ-tours.fr"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> Ilkan Aktar<br>
				<a class="fin" href="mailto:lucas.champion@etu.univ-tours.fr"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> Lucas Champion
				
			</p>
		
			<div class="footer">
		  		<?php footer(); ?>
			</div>
		</div>
	</body>
</html> 
<?php

//----------------------------------------------------Fonctions d'affichage d'éléments -------------------------------------------------

//                ----------------------- Recette ---------------------------

//--------------------------- afficheFormRecetteALL ------------------------

function afficheFormRecetteALL($recette){
	afficheFormRecette($recette);								
	afficheFormImagesOfRecette($recette['nomRecette']);
	echo '<br>';
	afficheFormEtapesPrepa($recette["nomRecette"]);
	echo '<div class="tabLaterale">';
		echo '<div class="panneauLateral">';
			afficheFormIngreRecette($recette['nomRecette']);
		echo '</div>';
		echo '<div class="panneauLateral">';
			afficheFormUstensilesRecette($recette['nomRecette']);
		echo '</div>';
		echo '<div class="panneauLateral">';
			afficheFormCategRecette($recette['nomRecette']);
		echo '</div>';
	echo '</div>';
}

//--------------------------- afficheFormRecette ------------------------

function afficheFormRecette($recette){
	
	//formulaire de la recette 
	//sera pris en compte comme la "nouvelle recette"					
	echo '<form id="formulaireModifRecette" action="ModifRecette.php" method="post">';
	echo '<h3 class="souligner">Recette :</h3>';
	echo '<p> Pour modifier, faites directement les modifications dans les espaces prévus puis cliquez sur modifier </p>';
	echo '<div class="block"><label for="nomRecette">Nom de la recette : <input type="text" name="newrecette[nomRecette]" id="nomRecette" class="input-res" value="'.$recette['nomRecette'].'" size="40" maxlength="80" required></label></div><br>';
	echo '<div class="block"><label for="tempsPrepa">Temps de préparation : <input type="number" name="newrecette[tempsPrepa]" id="tempsPrepa" class="input-res" value="'.$recette['tempsPrepa'].'" min="0" required></label></div><br>';
	echo '<div class="block"><label for="tempsCuisson">Temps de cuisson : <input type="number" name="newrecette[tempsCuisson]" id="tempsCuisson" class="input-res" value="'.$recette['tempsCuisson'].'" min="0" required></label></div><br>';
	echo '<div class="block"><label for="tempsRepos">Temps de repos : <input type="number" name="newrecette[tempsRepos]" id="tempsRepos" class="input-res" value="'.$recette['tempsRepos'].'" min="0" required></label></div><br>';
	echo '<input type="number" name="newrecette[tempsTotal]" value="'.$recette['tempsTotal'].'" hidden>'; //calculé automatiquement donc pas changeable manuellement
	echo '<div class="block"><label for="difficulte">Difficulté : <input type="number" name="newrecette[difficulte]" id="difficulte" class="input-res" value="'.$recette['difficulte'].'" min="0" max="5" required></label></div><br>';
	echo '<div class="block"><label for="nbPersonnes">Nombre de personnes : <input type="number" name="newrecette[nbPersonnes]" id="nbPersonnes" class="input-res" value="'.$recette['nbPersonnes'].'" min="0" required></label></div><br>';							
	
	//les 2 lignes suivantes permettent de garder toutes les infos de la recette lors de l'envoi
	echo '<input type="number" name="newrecette[noteGlobale]" value="'.$recette['noteGlobale'].'" hidden>';
	echo '<input type="number" name="newrecette[nbNotes]" value="'.$recette['nbNotes'].'" hidden>';
	
	//conservation de la recette sans changements
	echo '<input type="text" name="oldrecette[nomRecette]" value="'.$recette['nomRecette'].'" hidden>';
	echo '<input type="number" name="oldrecette[tempsPrepa]" value="'.$recette['tempsPrepa'].'" hidden>';
	echo '<input type="number" name="oldrecette[tempsCuisson]" value="'.$recette['tempsCuisson'].'" hidden>';
	echo '<input type="number" name="oldrecette[tempsRepos]" value="'.$recette['tempsRepos'].'" hidden>';
	echo '<input type="number" name="oldrecette[tempsTotal]" value="'.$recette['tempsTotal'].'" hidden>';
	echo '<input type="number" name="oldrecette[difficulte]" value="'.$recette['difficulte'].'" hidden>';
	echo '<input type="number" name="oldrecette[nbPersonnes]" value="'.$recette['nbPersonnes'].'" hidden>';
	echo '<input type="number" name="oldrecette[noteGlobale]" value="'.$recette['noteGlobale'].'" hidden>';
	echo '<input type="number" name="oldrecette[nbNotes]" value="'.$recette['nbNotes'].'" hidden>';
	
	echo '<input type="submit" name="boutonModifRecette" class="bouton" value="Modifier">'; //bouton modification recette
	echo '<input type="submit" name="boutonSuppressionRecette" class="bouton" value="Supprimer la recette">'; //bouton suppresion recette
	echo '</form>';
}


//--------------------------- afficheFormIngreRecette ------------------------

function afficheFormIngreRecette($nomRecette){ //utilise le fichier fonctionsRecherches.php
	echo '<form id="formulaireModifLienIngre" action="ModifRecette.php" method="post">';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	
	$tabIngre = renvoieIngredientsRecette($nomRecette); //permet de récupérer un tableau de tout les ingrédients liées à la recette en parametre
							
	if ($tabIngre != NULL){
		echo "<h3 class='souligner'> Ingredients </h3>";
		$compteur = 0;
		foreach ($tabIngre as $key => $value){
			echo '<input type="text" name="ingredients[]" maxlength="50" value="'.$value["nomIngre"].'"><br>';
			$compteur++;
		}
		for ($i = 0; $i < 16-$compteur; $i++) { 
			echo '<input type="text" name="ingredients[]" maxlength="50" value="" ><br>';
		}
		echo '<p><input type="submit" name="boutonModifIngreRecette" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
	else{
		echo "<h3 class='souligner'> Ingredients </h3>".'<br>';
		echo "Pas encore d'ingrédients pour cette recette".'<br>';
		for ($i = 0; $i < 16; $i++) { 
			echo '<input type="text" name="ingredients[]" value="" maxlength="50"><br>';
		}
		echo '<p><input type="submit" name="boutonModifIngreRecette" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
}


//--------------------------- afficheFormUstensilesRecette ------------------------

function afficheFormUstensilesRecette($nomRecette){ //utilise le fichier fonctionsRecherches.php
	echo '<form id="formulaireModifLienUstensiles" action="ModifRecette.php" method="post">';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';

	$tabUstensiles = renvoieUstensilesRecette($nomRecette); //permet de récupérer un tableau de tout les ingrédients liées à la recette en parametre
							
	if ($tabUstensiles != NULL){
		echo "<h3 class='souligner'> Ustensiles </h3>";
		$compteur = 0;
		foreach ($tabUstensiles as $key => $value){
			echo '<input type="text" name="ustensiles[]" value="'.$value["nomUstensile"].'" maxlength="50"><br>';
			$compteur++;
		}
		for ($i = 0; $i < 16-$compteur; $i++) { 
			echo '<input type="text" name="ustensiles[]" value="" maxlength="50"><br>';
		}
		echo '<p><input type="submit" name="boutonModifUstensileRecette" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
	else{
		echo "<h3 class='souligner'> Ustensiles </h3>".'<br>';
		echo "Pas encore d'ustensiles pour cette recette".'<br>';
		for ($i = 0; $i < 16; $i++) { 
			echo '<input type="text" name="ustensiles[]" value="" maxlength="50"><br>';
		}
		echo '<p><input type="submit" name="boutonModifUstensileRecette" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
}


//--------------------------- afficheFormEtapesPrepa ------------------------

function afficheFormEtapesPrepa($nomRecette){

	$tabEtapes = renvoieEtapesRecette($nomRecette); //permet de récupérer un tableau de tout les ingrédients liées à la recette en parametre
							
	if ($tabEtapes != NULL){
		echo '<form id="formulaireModifPrerequis" action="ModifRecette.php" method="post">';
		echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
		if ($tabEtapes[0]["numEtape"]==0){
			echo '<h3 class="souligner">Prérequis : </h3><br>';
			echo '<div class="block"><textarea name="prerequis[descEtape]" id="etapes" rows="2" cols="100" maxlength="200" class="input-res" >'.$tabEtapes[0]["descEtape"].'</textarea></div>';
			echo '<input type="number"  name="prerequis[idetape]" value="'.$tabEtapes[0]["idetape"].'" hidden>';
			echo '<input type="number"  name="prerequis[numEtape]" value="'.$tabEtapes[0]["numEtape"].'" hidden>'; //conservation de tout les attributs du prerequis
			echo '<input type="number"  name="prerequis[idrecette]" value="'.$tabEtapes[0]["idrecette"].'" hidden>';
			echo '<input type="submit" name="boutonModifPrerequisRecette" class="bouton" value="Modifier prérequis">';
			echo '<input type="submit" name="boutonSuppressionPrerequisRecette" class="bouton" value="Supprimer prérequis">';
			echo '</form><br>';
			$i = 1;
		}
		else{
			echo '<h3 class="souligner">Prérequis : </h3>';
			echo '<p>Pas encore de prérequis</p>';
			echo '<input type="submit" name="boutonAjoutPrerequisRecette" class="bouton" value="Ajouter un prérequis">';
			echo '</form><br>';
			$i=0;
		}
		
		
		echo "<h3 class='souligner'> Etapes de preparation </h3>";
		echo '<form id="formulaireModifLienUstensiles" action="ModifRecette.php" method="post">';
		echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
		$j = 0;
		for ($i ; $i<count($tabEtapes); $i++){
			echo '<p> Etape '.$tabEtapes[$i]["numEtape"].'<div class="block"><textarea name="etapes['.$j.'][descEtape]" id="etapes" class="input-res" maxlength="200" >'.$tabEtapes[$i]["descEtape"].'</textarea></div><br>';
			echo '<input type="number"  name="etapes['.$j.'][idetape]" value="'.$tabEtapes[$i]["idetape"].'" hidden>';
			echo '<input type="number"  name="etapes['.$j.'][numEtape]" value="'.$tabEtapes[$i]["numEtape"].'" hidden>'; //conservation de tout les attributs d'une étape
			echo '<input type="number"  name="etapes['.$j.'][idrecette]" value="'.$tabEtapes[$i]["idrecette"].'" hidden>';
			$j++;
		}
		echo '<input type="submit" name="boutonModifEtapesRecette" class="bouton" value="Modifier">';
		echo '<input type="submit" name="boutonAjoutEtapeRecette" class="bouton" value="Ajouter une étape">';
		echo '</form><br>';
	}
	else{
		echo '<form id="formulaireModifLienUstensiles" action="ModifRecette.php" method="post">';
			echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
			echo '<h3 class="souligner">Prérequis : </h3>';
			echo '<p>Pas encore de prérequis</p>';
			echo '<input type="submit" name="boutonAjoutPrerequisRecette" class="bouton" value="Ajouter un prérequis">';
		echo '</form><br>';
		
		echo '<form id="formulaireModifLienUstensiles" action="ModifRecette.php" method="post">';
			echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
			echo "Pas encore d'étapes de préparation pour cette recette".'<br>';
			echo '<input type="submit" name="boutonAjoutEtapeRecette" class="bouton" value="Ajouter une étape">';
		echo '</form><br>';		
	}
}


//--------------------------- afficheFormImagesOfRecette ------------------------

function afficheFormImagesOfRecette($nomRecette){
	$tabImages = renvoieImagesViaNomRecette($nomRecette);
	
	if ($tabImages != NULL){
		echo "<h3 class='souligner'> Images </h3>";
		foreach ($tabImages as $key => $image){	
			echo '<form id="formulaireModifImageRecette" action="ModifRecette.php" method="post">';
			echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
			echo '<input type="text" name="idimgRecettes" value="'.$image["idimgRecettes"].'" hidden>';
			echo "<p>Nom de l'image : ".$image["imgRecetteNom"].' ';
			echo '<input type="submit" name="boutonSupprimerImageRecette" value="Supprimer"></p>';
			echo '<img src="'.$image["imgRecetteChemin"].'" alt="'.$image["imgRecetteDesc"].'" class="imageRefRI">';
			echo '</form>';
		}
		echo '<form id="formulaireModifImageRecette" action="ModifRecette.php" method="post">';
		echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
		echo '<p><input type="submit" name="boutonAjoutLienImageRecette" class="bouton" value="Ajouter une image"></p>';
		echo '</form>';

	}
	else{
		echo "<h3 class='souligner'> Images </h3>".'<br>';
		echo '<form id="formulaireModifImageRecette" action="ModifRecette.php" method="post">';
		echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
		echo "Pas encore d'images pour cette recette".'<br>';
		echo '<p><input type="submit" name="boutonAjoutLienImageRecette" value="Ajouter une image"></p>';
		echo '</form>';
	}	

}



//                   ------------------------------ Ingredient -------------------------------------

//--------------------------- afficheFormIngredient ------------------------

function afficheFormIngredient($ingredient){
	
	//formulaire de l'ingredient en parametre 
	//sera pris en compte comme le "nouvel ingrédient"
	echo '<form id="formulaireModifIngredient" action="ModifIngredient.php" method="post">';
	echo '<h3 class="souligner">Ingredient :</h3>';
	echo '<p> Pour modifier, faites directement les modifications dans les espaces prévus puis cliquez sur modifier </p>';
	echo '<div class="block"><label for="nomIngre">Nom de l\'ingredient : <input type="text" name="newingre[nomIngre]" id="nomIngre" class="input-res" value="'.$ingredient['nomIngre'].'" maxlength="50" required></label></div><br>';
	echo '<div class="block"><label for="uniteMesure">Unité de mesure : <input type="text" name="newingre[uniteMesure]" id="uniteMesure" class="input-res" value="'.$ingredient['uniteMesure'].'" maxlength="25" required></label></div><br>';
	
	//conservation de l'ingrédient sans changements
	echo '<input type="text" name="oldingre[nomIngre]" value="'.$ingredient['nomIngre'].'" hidden>';
	echo '<input type="text" name="oldingre[uniteMesure]" value="'.$ingredient['uniteMesure'].'" hidden><br>';
	
	echo '<input type="submit" name="boutonModifIngre" class="bouton" value="Modifier">';

	echo '<input type="submit" name="boutonSuppressionIngre" class="bouton" value="Supprimer l\'ingredient">';
	echo '</form>';
}

//--------------------------- afficheFormImagesOfIngredient ------------------------

function afficheFormImagesOfIngredient($nomIngre){
	$tabImages = renvoieImagesViaNomIngredient($nomIngre);
	
	if ($tabImages != NULL){
		echo "<h3 class='souligner'> Images </h3>";
		foreach ($tabImages as $key => $image){	
			echo '<form id="formulaireModifImageIngre" action="ModifIngredient.php" method="post">';
			echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>';
			echo '<input type="text" name="idimgIngre" value="'.$image["idimgIngre"].'" hidden>';
			echo "<p>Nom de l'image : ".$image["imgIngreNom"].' ';
			echo '<input type="submit" name="boutonSupprimerImageIngre" value="Supprimer"></p>';
			echo '<img src="'.$image["imgIngreChemin"].'" alt="'.$image["imgIngreDesc"].'" class="imageRefRI">';
			echo '</form>';
		}
		echo '<form id="formulaireModifImageIngre" action="ModifIngredient.php" method="post">';
		echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>';
		echo '<p><input type="submit" name="boutonAjoutLienImageIngre" class="bouton" value="Ajouter une image"></p>';
		echo '</form>';

	}
	else{
		echo "<h3 class='souligner'> Images </h3>".'<br>';
		echo '<form id="formulaireModifImageIngre" action="ModifIngredient.php" method="post">';
		echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>';
		echo "Pas encore d'images pour cet ingrédient".'<br>';
		echo '<p><input type="submit" name="boutonAjoutLienImageIngre" class="bouton" value="Ajouter une image"></p>';
		echo '</form>';
	}	
}


//                ----------------------- Images ---------------------------

//--------------------------- afficheFormImageRecette ------------------------

function afficheFormImageRecette($image){		
	echo '<form id="formulaireModifImageRecette" action="ModifImageRecette.php" method="post">';
	echo '<h3 class="souligner"> Image de recette </h3>';
	echo '<p> Pour modifier, faites directement les modifications dans les espaces prévus puis cliquez sur modifier </p>';
	echo '<input type="text" name="idimgRecettes" value="'.$image["idimgRecettes"].'" hidden>';
	echo "<div class='block'><label for='imgRecetteNom'>Nom de l'image : <input type='text' name='imgRecetteNom' id='imgRecetteNom' class='input-res' value='".$image['imgRecetteNom']."' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></div><br>";
	echo '<div class="block"><label for="imgRecetteDesc">Description de l\'image : <input type="text" name="imgRecetteDesc" id="imgRecetteDesc" class="input-res" value="'.$image['imgRecetteDesc'].'" maxlength="200" required></label></div><br>';
	echo '<div class="block"><label for="imgRecetteChemin"> Chemin de l\'image : <input type="text" name="imgRecetteChemin" id="imgRecetteChemin" class="input-res" value="'.$image["imgRecetteChemin"].'" maxlength="100"  required></label></div>';
	echo '<p><input type="submit" name="boutonModifierImageRecette" class="bouton" value="Modifier"></p>';

	echo '<img src="'.$image["imgRecetteChemin"].'" alt="'.$image["imgRecetteDesc"].'" class="imageRefRI"><br><br>';
	
	if(isset($image["idrecette"])){
		$recette = renvoieRecetteViaId($image["idrecette"]);	
		echo '<p> Cette image est liée à '.$recette['nomRecette'].'</p>';
	}
	else
		echo '<p> Cette image n\'est liée à aucune recette</p>';

	echo '<input type="submit" name="boutonSupprimer" class="bouton" value="Supprimer"></p>';
	echo '</form>';
}


//--------------------------- afficheFormImageIngre ------------------------

function afficheFormImageIngre($image){
	echo '<form id="formulaireModifImageRecette" action="ModifImageIngre.php" method="post">';
	echo '<h3 class="souligner"> Image d\'ingrédient </h3>';
	echo '<p> Pour modifier, faites directement les modifications dans les espaces prévus puis cliquez sur modifier </p>';
	echo '<input type="text" name="idimgIngre" value="'.$image["idimgIngre"].'" hidden>';
	echo "<div class='block'><label for='imgIngreNom'>Nom de l'image : <input type='text' name='imgIngreNom' id='imgIngreNom' class='input-res' value='".$image['imgIngreNom']."' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></div><br>";
	echo '<div class="block"><label for="imgIngreDesc">Description de l\'image : <input type="text" name="imgIngreDesc" id="imgIngreDesc" class="input-res" value="'.$image['imgIngreDesc'].'" maxlength="200" required></label></div><br>';
	echo '<div class="block"><label for=""imgIngreChemin"> Chemin de l\'image : <input type="text" name="imgIngreChemin" id="imgIngreChemin" class="input-res" value="'.$image["imgIngreChemin"].'" maxlength="100"  required></label></div>';
	echo '<p><input type="submit" name="boutonModifierImageIngredient" class="bouton" value="Modifier"></p>';

	echo '<img src="'.$image["imgIngreChemin"].'" alt="'.$image["imgIngreDesc"].'" class="imageRefRI"><br><br>';
	
	if(isset($image["idingredient"])){
		$ingredient = renvoieIngredientViaId($image["idingredient"]);
		echo '<p> Cette image est liée à '.$ingredient['nomIngre'].'</p>';
	}
	else
		echo '<p> Cette image n\'est liée à aucun ingrédient</p>';
	
	echo '<p><input type="submit" name="boutonSupprimer" class="bouton" value="Supprimer"></p>';
	echo '</form>';	
}


//                ----------------------- Catégories ---------------------------

//--------------------------- afficheFormCategRecette ------------------------

function afficheFormCategRecette($nomRecette){ 
	echo '<form id="formulaireModifCategRecette" action="ModifRecette.php" method="post">';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>'; 
	
	$categories = renvoieCategRecette($nomRecette);
	
	if ($categories != NULL){
		echo "<h3 class='souligner'> Catégories </h3>";
		$compteur = 0;
		foreach ($categories as $key => $value){
			echo '<input type="text" name="categories[]" value="'.$value["libCategorieRecette"].'" maxlength="30" ><br>';
			$compteur++;
		}
		for ($i = 0; $i < 12-$compteur; $i++) { 
			echo '<input type="text" name="categories[]" value="" maxlength="30"><br>';
		}
		echo '<p><input type="submit" name="boutonModifCateg" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
	else{
		echo "<h3 class='souligner'> Catégories </h3>".'<br>';
		echo "Pas encore de catégories pour cette recette".'<br>';
		for ($i = 0; $i < 12; $i++) { 
			echo '<input type="text" name="categories[]" value="" maxlength="30"><br>';
		}
		echo '<p><input type="submit" name="boutonModifCateg" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
}


//--------------------------- afficheFormCategIngredient ------------------------

function afficheFormCategIngredient($nomIngre){ 
	echo '<form id="formulaireModifCategIngre" action="ModifIngredient.php" method="post">';
	echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>'; //va surement sauter car on va juste utiliser l'id	
	
	$categories = renvoieCategIngre($nomIngre);
	
	if ($categories != NULL){
		echo "<h3 class='souligner'> Catégories </h3>";
		$compteur = 0;
		foreach ($categories as $key => $value){
			echo '<input type="text" name="categories[]" value="'.$value["libCategorieIngredient"].'" maxlength="30"><br>';
			$compteur++;
		}
		for ($i = 0; $i < 12-$compteur; $i++) { 
			echo '<input type="text" name="categories[]" value="" maxlength="30"><br>';
		}
		echo '<p><input type="submit" name="boutonModifCateg" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
	else{
		echo "<h3 class='souligner'> Catégories </h3>".'<br>';
		echo "Pas encore de catégories pour cet ingrédient".'<br>';
		for ($i = 0; $i < 16; $i++) { 
			echo '<input type="text" name="categories[]" value="" maxlength="30"><br>';
		}
		echo '<p><input type="submit" name="boutonModifCateg" class="bouton" value="Modifier"></p>';
		echo '</form>';
	}
}




//----------------------------------------------------Fonctions d'affichage d'ajout d'éléments -------------------------------------------------

//--------------------------- afficheFormAjoutRecette ------------------------

function afficheFormAjoutRecette() {
	echo '<form id="formulaire_insertion_recette" action="ModifRecette.php" method="post">';
	echo '<h2 class="souligner"> Création d\'une recette</h2>';
	echo '<p> Avant toute insertion de recette, veuillez vérifier qu\'elle n\'existe pas déja dans le site même sous un nom différent du vôtre</p>';
	echo '<div class="block"><p><label for="nomRecette">Nom de la recette : <input type="text" name="recette[nomRecette]" id="nomRecette" class="input-res" size=40" maxlength="80" required></label></p></div>';
	echo '<div class="block"><p><label for="tempsPrepa">Temps de preparation : <input type="number" name="recette[tempsPrepa]" id="tempsPrepa" class="input-res" min="0" required></label></p></div>';
	echo '<div class="block"><p><label for="tempsCuisson">Temps de cuisson : <input type="number" name="recette[tempsCuisson]" id="tempsCuisson" class="input-res" min="0" required></label></p></div>';
	echo '<div class="block"><p><label for="tempsRepos">Temps de repos : <input type="number" name="recette[tempsRepos]" id="tempsRepos" class="input-res" min="0" required></label></p></div>';
	echo '<input type="number" name="recette[tempsTotal]" value="1" hidden>'; //permit de le mettre à 1 car il est remodifié après lors de l'insertion
	echo '<div class="block"><p><label for="noteGlobale">Note globale : <input type="number" name="recette[noteGlobale]" id="noteGlobale" class="input-res" value="0" min="0" max="5" required></label></p></div>';
	echo '<div class="block"><p><label for="nbNotes">Nombre de notes : <input type="number" name="recette[nbNotes]" id="nbNotes" class="input-res" value="0" min="0" required></label></p></div>';
	echo '<div class="block"><p><label for="difficulte">Difficulté : <input type="number" name="recette[difficulte]" id="difficulte" class="input-res" value="0" min="0" max="5" required></label></p></div>';
	echo '<div class="block"><p><label for="nbPersonnes">Nombre de personnes : <input type="number" name="recette[nbPersonnes]" id="nbPersonnes" class="input-res" min="0" required></label></p></div>';
	
	echo '<p><input type="submit" name="boutonInsertionRecette" class="bouton" value="Valider"></p>';
				
	echo '</form>';
}


//--------------------------- afficheFormAjoutIngredient ------------------------

function afficheFormAjoutIngredient() {
	echo '<form id="formulaire_insertion_recette" action="ModifIngredient.php" method="post">';
	echo "<h2 class='souligner'> Création d'un ingrédient</h2>";
	echo "<p> Avant toute insertion d'ingrédient, veuillez vérifier qu'il n'existe pas déja dans le site même sous un nom différent du vôtre</p>";
	echo "<div class='block'><p><label for='nomIngre'>Nom de l'ingrédient : <input type='text' name='ingre[nomIngre]' class='input-res' maxlength='50' required></label></p></div>";
	echo "<div class='block'><p><label for='uniteMesure'>Unité de mesure : <input type='text' name='ingre[uniteMesure]' class='input-res' maxlength='25' required></label></p></div>";
				
	echo '<p><input type="submit" name="boutonInsertionIngre" class="bouton" value="Valider"></p>';
				
	echo '</form>';
}


//--------------------------- afficheFormAjoutUstensile ------------------------

function afficheFormAjoutUstensile() {
	echo '<form id="formulaire_insertion_ustensile" action="ModifUstensile.php" method="post">';
	echo "<h2 class='souligner'> Création d'un ustensile</h2>";
	echo "<p> Avant toute insertion d'ustensile, veuillez vérifier qu'il n'existe pas déja dans le site même sous un nom différent du vôtre</p>";
	echo "<div class='block'><p><label for='nomUstensile'>Nom de l'ustensile : <input type='text' name='nomUstensile' id='nomUstensile' class='input-res' maxlength='50' required></label></p></div>";
				
	echo '<p><input type="submit" name="boutonInsertionUstensile" class="bouton" value="Ajouter"></p>';
				
	echo '</form>';
}


//--------------------------- afficheFormAjoutCategorieRecette ------------------------

function afficheFormAjoutCategorieRecette(){
	echo '<form id="formulaire_insertion_categRecette" action="ModifCategRecette.php" method="post">';
	echo "<h2 class='souligner'> Création d'une catégorie de recette</h2>";
	echo "<p> Avant toute insertion d'une catégorie de recette, veuillez vérifier qu'elle n'existe pas déja dans le site même sous un nom différent du vôtre</p>";
	echo "<div class='block'><p><label for='nomCateg'>Nom de la catégorie : <input type='text' name='nomCateg' id='nomCateg' class='input-res' maxlength='30' required></label></p></div>";
				
	echo '<p><input type="submit" name="boutonInsertionCateg" class="bouton" value="Ajouter"></p>';
				
	echo '</form>';
}


//--------------------------- afficheFormAjoutCategorieIngredient ------------------------

function afficheFormAjoutCategorieIngredient(){
	echo '<form id="formulaire_insertion_categIngredient" action="ModifCategIngre.php" method="post">';
	echo "<h2 class='souligner'> Création d'une catégorie d'ingrédient</h2>";
	echo "<p> Avant toute insertion d'une catégorie d'ingrédient, veuillez vérifier qu'elle n'existe pas déja dans le site même sous un nom différent du vôtre</p>";
	echo "<div class='block'><p><label for='nomCateg'>Nom de la catégorie : <input type='text' name='nomCateg' id='nomCateg' class='input-res' maxlength='30' required></label></p></div>";
				
	echo '<p><input type="submit" name="boutonInsertionCateg" class="bouton" value="Ajouter"></p>';
				
	echo '</form>';
}


//--------------------------- afficheFormAjoutEtapeRecette ------------------------

function afficheFormAjoutEtapeRecette($nomRecette){
	echo '<form id="formulaire_insertion_etapeRecette" action="ModifRecette.php" method="post">';
	echo "<h2 class='souligner'> Création d'une étape pour ".$nomRecette."</h2>";
	echo "<p> Avant toute insertion d'une étape, veuillez vérifier qu'elle n'existe pas déja dans le site même sous un nom différent du vôtre</p>";
	echo "<div class='block'><p><label for='descEtape'>Description de l'étape : <input type='text' name='descEtape' id='descEtape' class='input-res' rows='2' cols='100' maxlength='200' required></label></p></div>";
	
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	
	$idrecette = rechercheIdRecette($nomRecette);
	echo '<input type="text" name="idrecette" value="'.$idrecette.'" hidden>';
	
	$position = rechercheNextnumEtape($idrecette);
	echo '<input type="text" name="numEtape" value="'.$position.'" hidden>';
				
	echo '<p><input type="submit" name="boutonInsertionEtapeRecette" class="bouton" value="Ajouter"></p>';
				
	echo '</form>';
	
	echo '<form id="formulaire_insertion_etapeRecette" action="ModifRecette.php" method="post">'; // 2 formulaires différents car les required empechent de cliquer sinon
	echo '<p><input type="submit" name="boutonModifier" class="bouton" value="Retourner à la recette"></p>';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	echo '</form>';
}


//--------------------------- afficheFormAjoutPrerequisRecette ------------------------

function afficheFormAjoutPrerequisRecette($nomRecette){
	echo '<form id="formulaire_insertion_prerequisRecette" action="ModifRecette.php" method="post">';
	echo "<h2 class='souligner'> Création d'un prérequis pour ".$nomRecette."</h2>";
	echo "<div class='block'><p><label for='descEtape'>Description du prérequis : <input type='text' name='descEtape' id='descEtape' class='input-res' rows='2' cols='100' maxlength='200' required></label></p><div>";
	
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	
	$idrecette = rechercheIdRecette($nomRecette);
	echo '<input type="text" name="idrecette" value="'.$idrecette.'" hidden>';

	echo '<input type="text" name="numEtape" value="0" hidden>';
				
	echo '<p><input type="submit" name="boutonInsertionEtapeRecette" class="bouton" value="Ajouter"></p>';
				
	echo '</form>';
	
	echo '<form id="formulaire_insertion_prerequisRecette" action="ModifRecette.php" method="post">'; // 2 formulaires différents car les required empechent de cliquer sinon
	echo '<p><input type="submit" name="boutonModifier" class="bouton" value="Retourner à la recette"></p>';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	echo '</form>';
}


//--------------------------- afficheFormAjoutLienImageRecette ------------------------

function afficheFormAjoutLienImageRecette($nomRecette){
	echo '<form id="formulaire_insertion_LienImageRecette" action="ModifRecette.php" method="post">';
	echo "<h2 class='souligner'> Liaison d'une image pour ".$nomRecette."</h2>";
	echo "<div class='block'><p><label for='imgRecetteNom'>Nom de l'image à lier (préciser l'extension): <input type='text' name='imgRecetteNom' id='imgRecetteNom' class='input-res' size='50' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></p></div>";
	
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
					
	echo '<p><input type="submit" name="boutonInsertionLienImageRecette" class="bouton" value="Lier l\'image"></p>';
				
	echo '</form>';
	
	echo '<form id="formulaire_insertion_LienImageRecette" action="ModifRecette.php" method="post">'; // 2 formulaires différents car les required empechent de cliquer sinon
	echo '<p><input type="submit" name="boutonModifier" class="bouton" value="Retourner à la recette"></p>';
	echo '<input type="text" name="nomRecette" value="'.$nomRecette.'" hidden>';
	echo '</form>';
}


//--------------------------- afficheFormAjoutImageRecette ------------------------

function afficheFormAjoutImageRecette(){
	
	echo '<form id="formulaire_insertion_ImageRecette" action="ModifImageRecette.php" method="post">';
	echo "<h2 class='souligner'> Insertion d'une image </h2>";
	
	echo "<div class='block'><label for='imgRecetteNom'>Nom de l'image : <input type='text' name='imgRecetteNom' id='imgRecetteNom' class='input-res' value='' size='50' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></div><br>"; //ce pattern est pour vérifier l'extension
	echo "<div class='block'><label for='imgRecetteDesc'>Description de l'image : <input type='text' name='imgRecetteDesc' id='imgRecetteDesc' class='input-res' value='' size='100' maxlength='200' required></label></div><br>";
	echo "<div class='block'><label for='imgRecetteChemin'>Chemin de l'image : <input type='text' name='imgRecetteChemin' id='imgRecetteChemin' class='input-res' value='Images\' size='100' maxlength='100'  required></label></div><br>";
	echo "<div class='block'><label for='nomRecette'> Nom de la recette à lier à l'image (facultatif) : <input type='text' name='nomRecette' id='nomRecette' class='input-res' size='50' maxlength='50' value=''></label></div><br>";

	echo '<p><input type="submit" name="boutonInsertionImage" class="bouton" value="Ajouter l\'image"></p>';
	echo '</form>';
}


//--------------------------- afficheFormAjoutLienImageIngre ------------------------

function afficheFormAjoutLienImageIngre($nomIngre){	
	echo '<form id="formulaire_insertion_LienImageIngre" action="ModifIngredient.php" method="post">';
	echo "<h2 class='souligner'> Liaison d'une image pour ".$nomIngre."</h2>";
	echo "<div class='block'><p><label for='imgIngreNom'>Nom de l'image à lier (préciser l'extension): <input type='text' name='imgIngreNom' id='imgIngreNom' class='input-res' size='50' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></p></div>";
	
	echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>';
					
	echo '<p><input type="submit" name="boutonInsertionLienImageIngre" class="bouton" value="Lier l\'image"></p>';
	echo '</form>';
	
	echo '<form id="formulaire_insertion_LienImageIngre" action="ModifIngredient.php" method="post">'; // 2 formulaires différents car les required empechent de cliquer sinon
	echo '<p><input type="submit" name="boutonModifier" class="bouton" value="Retourner à l\'ingrédient"></p>';
	echo '<input type="text" name="nomIngre" value="'.$nomIngre.'" hidden>';
	echo '</form>';
					
}


//--------------------------- afficheFormAjoutRecette ------------------------

function afficheFormAjoutImageIngre(){
	echo '<form id="formulaire_insertion_ImageIngre" action="ModifImageIngre.php" method="post">';
	echo "<h2 class='souligner'> Insertion d'une image </h2>";
	
	echo "<div class='block'><label for='imgIngreNom'>Nom de l'image : <input type='text' name='imgIngreNom' id='imgIngreNom' class='input-res' value='' size='50' maxlength='50' pattern='(.*\.)(jpe?g|png|gif|bmp|tiff|psd|raw|cr2|nef|orf|sr2)$' required></label></div><br>";
	echo "<div class='block'><label for='imgIngreDesc'>Description de l'image : <input type='text' name='imgIngreDesc' id='imgIngreDesc' class='input-res' value='' size='100' maxlength='200' required></label></div><br>";
	echo "<div class='block'><label for='imgIngreChemin'>Chemin de l'image : <input type='text' name='imgIngreChemin' id='imgIngreChemin' class='input-res' value='Images\' size='100' maxlength='100' required></label></div><br>";
	echo "<div class='block'><label for='nomIngre'> Nom de l'ingrédient à lier à l'image (facultatif) : <input type='text' name='nomIngre' id='nomIngre' class='input-res' size='50' maxlength='50' value=''></label></div><br>";

	echo '<p><input type="submit" name="boutonInsertionImage" class="bouton" value="Ajouter l\'image"></p>';
	echo '</form>';	
}

?>
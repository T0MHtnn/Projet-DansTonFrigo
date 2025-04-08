<?php

require_once('fonctionsRecherches.php');


//				--------------------------------------- RECETTE ---------------------------------------

//--------------------------------- insertRecette -----------------------------------

function insertRecette ($tabRecette){ //tabRecette est un tableau reprenant les éléments d'une recette 
//cette fonction insère une recette dans la base de données
	$tabRecette['nomRecette'] = trim($tabRecette['nomRecette']);
	if (rechercheIdRecette($tabRecette['nomRecette'])==NULL){ //test si le nom de recette existe déja ou pas
		$link = connexionUserPDO();
		
		$tempsTotal = $tabRecette["tempsPrepa"] + $tabRecette["tempsCuisson"] + $tabRecette["tempsRepos"];
		
		$result = $link->prepare('INSERT INTO Recettes (nomRecette, tempsPrepa, tempsCuisson, tempsRepos, tempsTotal, noteGlobale, nbNotes, difficulte, nbPersonnes) 
				VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )');
								
		$result->execute(array($tabRecette["nomRecette"], $tabRecette["tempsPrepa"], $tabRecette["tempsCuisson"],
							   $tabRecette["tempsRepos"], $tempsTotal, $tabRecette["noteGlobale"], 
							   $tabRecette["nbNotes"], $tabRecette["difficulte"], $tabRecette["nbPersonnes"]));
		$link = NULL ;
		
		return TRUE; //permet de savoir si l'insertion
	}
	else
		return FALSE;
	
}


//--------------------------------- insertLienRecetteIngre -----------------------------------

function insertLienRecetteIngre($idrecette, $tabIdIngredients){ //tabIdIngredients est un tableau des idingredients à lier	
//cette fonction insère un lien entre recette et ingrédient dans la base de données

	/* 
	on travaille sur tabIDIngredients afin de tester tout les liens si ils n'existent pas déja
	Si le lien existe on ne fera rien et on continuera les tests, si il n'existe pas on créera le lien
	*/
		
	foreach ($tabIdIngredients as $key => $idingre){
		
		if (existenceLienIngreRecette($idingre, $idrecette)==FALSE){ //test si le lien existe déja
									
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO compose (idingredient, idrecette) VALUES ( ? , ? )');
					 
			$result->execute(array($idingre, $idrecette));
			$link = NULL ;
		}
	}
}


//--------------------------------- insertLienRecetteUstensile -----------------------------------

function insertLienRecetteUstensile($idrecette, $tabIdUstensiles){
//cette fonction insère un lien entre Recettes et Ustensiles dans la base de données

	/* 
	on travaille sur tabIdUstensiles afin de tester tout les liens si ils n'existent pas déja
	Si le lien existe on ne fera rien et on continuera les tests, si il n'existe pas on créera le lien
	*/
		
	foreach ($tabIdUstensiles as $key => $idustensile){
		
		if (existenceLienUstensileRecette($idustensile, $idrecette)==FALSE){
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO a_besoin_de (idustensile, idrecette) VALUES ( ? , ? )');
					 
			$result->execute(array($idustensile, $idrecette));
			$link = NULL ;
		}
	}
}


//--------------------------------- insertEtapesRecettes -----------------------------------

//insère toutes les étapes du tableau de $tabEtapes 
function insertEtapesRecette($idrecette, $tabEtapes){
	foreach ($tabEtapes as $key => $etape){
		
		if (existenceEtapeRecette($etape["idetape"], $idrecette)==FALSE){ 
			
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO EtapesPreparations (descEtape, numEtape, idrecette) VALUES ( ? , ? , ? )');
					 
			$result->execute(array($etape["descEtape"], $etape["numEtape"], $idrecette));
			$link = NULL ;
		}
	}
}


//--------------------------------- insertEtapeRecette -----------------------------------

//insère l'étape $etape 
function insertEtapeRecette($idrecette, $etape){
			
	$link = connexionUserPDO();
		
	$result = $link->prepare('INSERT INTO EtapesPreparations (descEtape, numEtape, idrecette) VALUES ( ? , ? , ? )');
					 
	$result->execute(array($etape["descEtape"], $etape["numEtape"], $idrecette));
	$link = NULL ;
}


//--------------------------------- insertLienCategorieRecette -----------------------------------

function insertLienCategorieRecette($idrecette, $tabIdCateg){
//cette fonction insère un lien entre Recettes et CatégoriesRecettes dans la base de données	
	/* 
	on travaille sur tabIdCateg afin de tester tout les liens si ils n'existent pas déja
	Si le lien existe on ne fera rien et on continuera les tests, si il n'existe pas on créera le lien
	*/
		
	foreach ($tabIdCateg as $key => $idcateg){
		
		if (existenceLienCategorieRecette($idcateg, $idrecette)==FALSE){ 
			
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO categorise_recette (idcategorieRecette, idrecette) VALUES ( ? , ? )');
					 
			$result->execute(array($idcateg, $idrecette));
		}
	}
	$link = NULL ;
}


//--------------------------------- insertLienImageRecette -----------------------------------

function insertLienImageRecette($nomImage, $idrecette){
//cette fonction insère un lien entre Recettes et ImagesRecettes dans la base de données	

	$idimage = rechercheIdImageRecette($nomImage);
	
	if($idimage != NULL){ //check si l'id renvoie bien à une image
		if (recherchePictureAlreadyUsedRecette($idimage)== FALSE){ //check si l'image est déja utilisé par une autre recette ou non
			
			$link = connexionUserPDO();
			
			$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = ? WHERE idimgRecettes = ? ');
						 
			$result->execute(array($idrecette, $idimage));
			echo '<p class="texteGras">Liaison réussie</p>';
			$link = NULL ;
			return TRUE;
		}
		else {
			echo '<p class="texteGras">Image déja utilisée par une autre recette ! </p>';
		}
	}
	else {
		echo '<p class="texteGras">Image introuvable ! </p>';
		return FALSE;
	}
	
}



//				--------------------------------------- INGREDIENT ---------------------------------------

//--------------------------------- insertIngredient -----------------------------------

function insertIngredient($tabIngredient){
//cette fonction insère un ingrédient dans la base de données	
	$tabIngredient['nomIngre'] = trim($tabIngredient['nomIngre']);
	if (rechercheIdIngredient($tabIngredient['nomIngre'])==NULL){
		
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO Ingredients (nomIngre, uniteMesure) VALUES ( ? , ? )');
					 
			$result->execute(array($tabIngredient["nomIngre"], $tabIngredient["uniteMesure"]));
		$link = NULL ;
		return TRUE;
	}
	else
		return FALSE;	
	
}


//--------------------------------- insertLienImageIngre -----------------------------------

function insertLienImageIngre($nomImage, $idingre){ 
//cette fonction insère un lien entre Ingrédients et ImagesIngre dans la base de données	

	$idimage = rechercheIdImageIngre($nomImage);
	if($idimage != NULL){ //check si l'id renvoie bien à une image
		if (recherchePictureAlreadyUsedIngre($idimage)== FALSE){ //check si l'image est déja utilisée par un autre ingrédient ou non
			
			$link = connexionUserPDO();
			
			$result = $link->prepare('UPDATE ImagesIngre SET idingredient = ? WHERE idimgIngre = ? ');
						 
			$result->execute(array($idingre, $idimage));
			
			echo '<p class="texteGras">Liaison réussie</p>';
			$link = NULL ;
			return TRUE;
		}
		else {
			echo '<p class="texteGras">Image déja utilisée par un autre ingrédient ! </p>';
		}
	}
	else {
		echo '<p class="texteGras">Image introuvable ! </p>';
		return FALSE;
	}
}


//--------------------------------- insertLienCategorieIngredient -----------------------------------

function insertLienCategorieIngredient($idingre, $tabIdCateg){ 
//cette fonction insère un lien entre Ingrédients et CategoriesIngredients dans la base de données	

	/* 
	on travaille sur tabIdCateg afin de tester tout les liens si ils n'existent pas déja
	Si le lien existe on ne fera rien et on continuera les tests, si il n'existe pas on créera le lien
	*/
		
	foreach ($tabIdCateg as $key => $idcateg){
		
		if (existenceLienCategorieIngredient($idcateg, $idingre)==FALSE){ 			
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO categorise_ingredient (idcategorieIngredient, idingredient) VALUES ( ? , ? )');
					 
			$result->execute(array($idcateg, $idingre));
		}
	}
	$link = NULL ;
}




//				--------------------------------------- USTENSILE ---------------------------------------

//--------------------------------- insertUstensile -----------------------------------

function insertUstensile($nomUstensile){
//cette fonction insère un ustensile dans la base de données
	$nomUstensile = trim($nomUstensile);
	if (rechercheIdUstensile($nomUstensile)== NULL){
		
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO Ustensiles (nomUstensile) VALUES ( ? )');
					 
			$result->execute(array($nomUstensile));
		$link = NULL ;
		return TRUE;
	}
	else
		return FALSE;	
	
}



//				--------------------------------------- CATEGORIE RECETTE ---------------------------------------

//--------------------------------- insertCategorieRecette -----------------------------------

function insertCategorieRecette($nomCateg){
//cette fonction insère une catégorie de recette dans la base de données
	$nomCateg = trim($nomCateg);
	if (rechercheIdCategRecette($nomCateg)== NULL){
		
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO CategoriesRecettes (libcategorieRecette) VALUES ( ? )');
					 
			$result->execute(array($nomCateg));
		$link = NULL ;
		return TRUE;
	}
	else
		return FALSE;	
}



//				--------------------------------------- CATEGORIE INGREDIENT ---------------------------------------

//--------------------------------- insertCategorieIngredient -----------------------------------

function insertCategorieIngredient($nomCateg){
//cette fonction insère une catégorie d'ingrédient dans la base de données
	$nomCateg = trim($nomCateg);
	if (rechercheIdCategIngre($nomCateg)== NULL){
		
			$link = connexionUserPDO();
		
			$result = $link->prepare('INSERT INTO CategoriesIngredients (libcategorieIngredient) VALUES ( ? )');
					 
			$result->execute(array($nomCateg));
		$link = NULL ;
		return TRUE;
	}
	else
		return FALSE;	
}


//				--------------------------------------- IMAGE RECETTE ---------------------------------------

//--------------------------------- insertImageRecette -----------------------------------

function insertImageRecette($image){ 
//cette fonction insère une image de recette dans la base de données

	if (checkInsertionImageRecette($image)){ // check si l'image peut etre inséré (nom et chemin unique)
		if(isset($image['idrecette']) && $image['idrecette']>0 && renvoieRecetteViaId($image['idrecette'])){ //check si l'id renvoyé correspond à une recette
			$link = connexionUserPDO();
			$result = $link->prepare('INSERT INTO ImagesRecettes (imgRecetteNom, imgRecetteDesc, imgRecetteChemin, idrecette) VALUES ( ? , ? , ? , ? )');	 
			$result->execute(array($image['imgRecetteNom'], $image['imgRecetteDesc'], $image['imgRecetteChemin'], $image['idrecette']));
			$link = NULL ;
			return TRUE;
		}
		else{
			$link = connexionUserPDO();
			$result = $link->prepare('INSERT INTO ImagesRecettes (imgRecetteNom, imgRecetteDesc, imgRecetteChemin, idrecette) VALUES ( ? , ? , ? , ? )');	 
			$result->execute(array($image['imgRecetteNom'], $image['imgRecetteDesc'], $image['imgRecetteChemin'], NULL));
			$link = NULL ;
			return TRUE;
		}

	}
	else
		return FALSE;
}



//				--------------------------------------- IMAGE INGREDIENT ---------------------------------------

//--------------------------------- insertImageIngre -----------------------------------

function insertImageIngre($image){ 
//cette fonction insère une image d'ingrédient dans la base de données

	if (checkInsertionImageIngre($image)){ //check si l'image peut-être insérée (nom et chemin uniques)
		if(isset($image['idingredient']) && $image['idingredient']>0 && renvoieIngredientViaId($image['idingredient'])!=NULL){ //check si l'id renvoyé correspond à un ingrédient
			$link = connexionUserPDO();
			$result = $link->prepare('INSERT INTO ImagesIngre (imgIngreNom, imgIngreDesc, imgIngreChemin, idingredient) VALUES ( ? , ? , ? , ? )');	 
			$result->execute(array($image['imgIngreNom'], $image['imgIngreDesc'], $image['imgIngreChemin'], $image['idingredient']));
			$link = NULL ;
			return TRUE;
		}
		else{
			$link = connexionUserPDO();
			$result = $link->prepare('INSERT INTO ImagesIngre (imgIngreNom, imgIngreDesc, imgIngreChemin, idingredient) VALUES ( ? , ? , ? , ? )');	 
			$result->execute(array($image['imgIngreNom'], $image['imgIngreDesc'], $image['imgIngreChemin'], NULL));
			$link = NULL ;
			return TRUE;
		}

	}
	else
		return FALSE;	
}

?>
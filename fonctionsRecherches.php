<?php


//                -----------------------Fonctions de renvois d'éléments ---------------------------

//--------------------------- renvoieRecette ------------------------
function renvoieRecette($nomRecette){
//renvoi la recette correspondant au nom en paramètre 
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idrecette, nomRecette, tempsPrepa, tempsCuisson, tempsRepos, tempsTotal, noteGlobale, nbNotes, difficulte, nbPersonnes 
				 FROM recettes WHERE nomRecette LIKE ?');
				 
	$result->execute(array($nomRecette));
	
	$link = NULL ;
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;

	}
	else {
		echo "<p class='texteGras'>Pas de recette correspondante</p><br>";
		return NULL;
	}
}


//--------------------------- renvoieRecetteViaId ------------------------
function renvoieRecetteViaId($idrecette){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idrecette, nomRecette, tempsPrepa, tempsCuisson, tempsRepos, tempsTotal, noteGlobale, nbNotes, difficulte, nbPersonnes 
				 FROM recettes WHERE idrecette LIKE ?');
				 
	$result->execute(array($idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;

	}
	else {
		echo "<p class='texteGras'>Pas de recette correspondante</p><br>";
		return NULL;
	}
}


//--------------------------- renvoieUstensile ------------------------
function renvoieUstensile($nomUstensile){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT nomUstensile 
				 FROM ustensiles WHERE nomUstensile = ?');
				 
	$result->execute(array($nomUstensile));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;

	}
	else {
		echo "<p class='texteGras'>Pas d'ustensile correspondant</p><br>";
		return NULL;
	}
}


//--------------------------- renvoieIngredientsRecette ------------------------
function renvoieIngredientsRecette($nomRecette){ 
//permet de récupérer un tableau de tout les ingrédients liées à la recette en parametre
	
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT Ingredients.idingredient, nomIngre 
							FROM Ingredients
							INNER JOIN compose ON compose.idingredient = ingredients.idingredient 
							INNER JOIN Recettes ON recettes.idrecette= compose.idrecette
							WHERE nomRecette LIKE ? ");
							
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	$tabIngre = [];
				
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabIngre[] = $row;
		}
		return $tabIngre;
	}
	else {	
		return NULL;
	}	
}


//--------------------------- renvoieUstensilesRecette ------------------------
function renvoieUstensilesRecette($nomRecette){ 
//permet de récupérer un tableau de tout les ustensiles liés à la recette en parametre
	
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT Ustensiles.idustensile, nomUstensile 
				 FROM Ustensiles
				 INNER JOIN a_besoin_de ON a_besoin_de.idustensile = Ustensiles.idustensile
				 INNER JOIN Recettes ON recettes.idrecette= a_besoin_de.idrecette
				 WHERE nomRecette LIKE ?");
							
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	$tabUstensiles = [];
				
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabUstensiles[] = $row;
		}
		return $tabUstensiles;
	}
	else {	
		return NULL;
	}	
	
	
}


//--------------------------- renvoieIngredient ------------------------
function renvoieIngredient($nomIngredient){
//renvoi l'ingrédient correspondant au nom en paramètre 
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idingredient, nomIngre, uniteMesure
				 FROM ingredients WHERE nomIngre LIKE ? ");
				 
	$result->execute(array($nomIngredient));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	else {
		echo "<p class='texteGras'>Pas d'ingrédient correspondant</p><br>";		
		return NULL;
	}
}


//--------------------------- renvoieIngredientViaId ------------------------
function renvoieIngredientViaId($idingre){
//renvoi l'ingrédient correspondant a l'id en paramètre 
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT nomIngre, uniteMesure
				 FROM ingredients WHERE idingredient = ? ");
				 
	$result->execute(array($idingre));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	else {
		return NULL;
	}	
}


//--------------------------- renvoieEtapesRecette ------------------------
function renvoieEtapesRecette($nomRecette){
//renvoi les étapes de préparation d'une recette
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idetape, descEtape, numEtape, EtapesPreparations.idrecette
				 FROM EtapesPreparations
				 INNER JOIN Recettes ON recettes.idrecette= EtapesPreparations.idrecette
				 WHERE nomRecette LIKE ?
				 ORDER BY numEtape");
							
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	$tabEtapes = [];
				
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabEtapes[] = $row;
		}
		return $tabEtapes;
	}
	else {	
		return NULL;
	}
}


//--------------------------- renvoieImagesViaNomRecette ------------------------
function renvoieImagesViaNomRecette($nomRecette){
//renvoi les images liées à une recette via son nom
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgRecettes, imgRecetteNom, imgRecetteDesc, imgRecetteChemin
				 FROM ImagesRecettes
				 JOIN Recettes ON ImagesRecettes.idrecette = Recettes.idrecette
				 WHERE nomRecette = ?');
				 
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabImages[] = $row;
		}
		return $tabImages;
	}
	else {
		return NULL;
	}	
}


//--------------------------- renvoieImagesViaNomIngredient ------------------------
function renvoieImagesViaNomIngredient($nomIngre){
//renvoi les images liées à un ingrédient via son nom
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgIngre, imgIngreNom, imgIngreDesc, imgIngreChemin
				 FROM ImagesIngre
				 JOIN Ingredients ON ImagesIngre.idingredient = Ingredients.idingredient
				 WHERE nomIngre = ?');
				 
	$result->execute(array($nomIngre));
	$link = NULL ;
	
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabImages[] = $row;
		}
		return $tabImages;
	}
	else {
		return NULL;
	}	
}


//--------------------------- renvoieImagesRecetteViaId ------------------------
function renvoieImageRecetteViaId($idimage){
//renvoi les images liées à un recette via son id
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgRecettes, imgRecetteNom, imgRecetteDesc, imgRecetteChemin, idrecette
				 FROM ImagesRecettes
				 WHERE idimgRecettes = ?');
				 
	$result->execute(array($idimage));
	$link = NULL ;
	
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	else {
		echo "<p class='texteGras'>Pas d'image correspondante</p><br>";
		return NULL;
	}
}


//--------------------------- renvoieImageIngreViaId ------------------------
function renvoieImageIngreViaId($idimage){
//renvoi les images liées à un ingrédient via son id
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgIngre, imgIngreNom, imgIngreDesc, imgIngreChemin, idingredient
				 FROM ImagesIngre
				 WHERE idimgIngre = ?');
				 
	$result->execute(array($idimage));
	$link = NULL ;
	
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	else {
		echo "<p class='texteGras'>Pas d'image correspondante</p><br>";
		return NULL;
	}	
}


//--------------------------- renvoieCategRecette ------------------------
function renvoieCategRecette($nomRecette){
//renvoi les catégories liées à une recette
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT CategoriesRecettes.idcategorieRecette, libCategorieRecette
							FROM CategoriesRecettes
							INNER JOIN categorise_recette ON categorise_recette.idcategorieRecette = CategoriesRecettes.idcategorieRecette
							INNER JOIN Recettes ON categorise_recette.idrecette = Recettes.idrecette
							WHERE nomRecette = ? ");
							
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	$tabCateg = [];
				
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabCateg[] = $row;
		}
		return $tabCateg;
	}
	else {	
		return NULL;
	}	
}


//--------------------------- renvoieCategIngre ------------------------
function renvoieCategIngre($nomIngre){
//renvoi les catégories liées à un ingrédient
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT CategoriesIngredients.idcategorieIngredient, libCategorieIngredient
							FROM CategoriesIngredients
							INNER JOIN categorise_ingredient ON categorise_ingredient.idcategorieIngredient = CategoriesIngredients.idcategorieIngredient
							INNER JOIN Ingredients ON categorise_ingredient.idingredient = Ingredients.idingredient
							WHERE nomIngre = ? ");
							
	$result->execute(array($nomIngre));
	$link = NULL ;
	
	$tabCateg = [];
				
	if($result->rowCount()>0){	//test si le résultat de la requete SQL renvoie quelque chose
		while ($row = $result->fetch(PDO::FETCH_ASSOC)){
			 $tabCateg[] = $row;
		}
		return $tabCateg;
	}
	else {	
		return NULL;
	}	
}



//                -----------------------Fonctions de recherche d'ID ---------------------------

//--------------------------- rechercheIdRecette ------------------------
function rechercheIdRecette($nomRecette){
// renvoi l'id de la recette au nom passé en paramètre si il est trouvé, sinon renvoi NULL
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idrecette 
							FROM Recettes
							WHERE nomRecette LIKE ?");
							
	$result->execute(array($nomRecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idrecette'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdIngredient ------------------------
function rechercheIdIngredient($nomIngre){
// renvoi l'id de l'ingrédient au nom passé en paramètre si il est trouvé, sinon renvoi NULL
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idingredient
							FROM Ingredients
							WHERE nomIngre LIKE ?");
							
	$result->execute(array($nomIngre));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idingredient'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdIngredientTab ------------------------
function rechercheIdIngredientTab($ingredients){
// renvoi les id des ingrédients du tableau $ingredients, si un id est introuvé renvoi NULL
	$tabIDIngreFinal = [];    

	foreach ($ingredients as $key => $nomIngre){
		if($nomIngre != ""){
			$id = rechercheIdIngredient($nomIngre);
			
			if($id!=NULL){
				$tabIDIngreFinal[]=$id;
			}
			else {
				echo "<p>Impossible de récupérer l'ingrédient : ".$nomIngre.'</p><br>';
				echo "<p>Veuillez reessayez l'insertion en enlevant l'ingrédient : ".$nomIngre.'</p><br>';
				return NULL;
			}
		}
		
	}
	return $tabIDIngreFinal;
}


//--------------------------- rechercheIdUstensile ------------------------
function rechercheIdUstensile($nomUstensile){
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idustensile
							FROM Ustensiles
							WHERE nomUstensile LIKE ?");
							
	$result->execute(array($nomUstensile));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idustensile'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdCategRecette ------------------------
function rechercheIdCategRecette($nomCateg){
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idcategorieRecette
							FROM CategoriesRecettes
							WHERE libCategorieRecette LIKE ?");
							
	$result->execute(array($nomCateg));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idcategorieRecette'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdCategIngre ------------------------
function rechercheIdCategIngre($nomCateg){
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idcategorieIngredient
							FROM CategoriesIngredients
							WHERE libCategorieIngredient LIKE ?");
							
	$result->execute(array($nomCateg));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idcategorieIngredient'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdImageRecette ------------------------
function rechercheIdImageRecette($nomImage){
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idimgRecettes
							FROM ImagesRecettes
							WHERE imgRecetteNom LIKE ?");
							
	$result->execute(array($nomImage));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idimgRecettes'];
	}
	else {		
		return NULL;
	}
}


//--------------------------- rechercheIdImageIngre ------------------------
function rechercheIdImageIngre($nomImage){
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idimgIngre
							FROM ImagesIngre
							WHERE imgIngreNom LIKE ?");
							
	$result->execute(array($nomImage));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return $row['idimgIngre'];
	}
	else {		
		return NULL;
	}
}



//                -----------------------Fonctions de recherche d'existence ---------------------------

//--------------------------- existenceLienIngreRecette ------------------------
function existenceLienIngreRecette ($idingre, $idrecette){ 
//renvoie true si un lien existe entre idingre et idrecette, false sinon
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idingredient, idrecette FROM compose WHERE idingredient= ? AND idrecette= ?');
				 
	$result->execute(array($idingre, $idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		return TRUE;
	}
	else {
		return FALSE;
	}
}


//--------------------------- existenceLienUstensileRecette ------------------------
function existenceLienUstensileRecette ($idustensile, $idrecette){ 
//renvoie true si un lien existe entre idustensile et idrecette, false sinon
	
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idustensile, idrecette FROM a_besoin_de WHERE idustensile= ? AND idrecette= ?');
				 
	$result->execute(array($idustensile, $idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		return TRUE;
	}
	else {
		return FALSE;
	}
}


//--------------------------- existenceLienCategorieRecette ------------------------
function existenceLienCategorieRecette($idcateg, $idrecette){
//renvoie true si un lien existe entre idcateg et idrecette, false sinon

	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idcategorieRecette, idrecette FROM categorise_recette WHERE idcategorieRecette= ? AND idrecette= ?');
				 
	$result->execute(array($idcateg, $idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		return TRUE;
	}
	else {
		return FALSE;
	}	
}


//--------------------------- existenceLienCategorieIngredient ------------------------
function existenceLienCategorieIngredient($idcateg, $idingre){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idcategorieIngredient, idingredient FROM categorise_ingredient WHERE idcategorieIngredient= ? AND idingredient= ?');
				 
	$result->execute(array($idcateg, $idingre));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		return TRUE;
	}
	else {
		return FALSE;
	}	
}


//--------------------------- existenceEtapeRecette ------------------------
function existenceEtapeRecette($idetape, $idrecette){
//renvoie true si un lien existe entre idetape et idrecette, false sinon
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idetape FROM EtapesPreparations WHERE idetape= ? AND idrecette= ?');
				 
	$result->execute(array($idetape, $idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie quelque chose
		return TRUE;
	}
	else {
		return FALSE;
	}
}



//                -----------------------Fonctions auxilliaires de recherche ---------------------------

//--------------------------- rechercheNextNumEtape ------------------------
function rechercheNextnumEtape($idrecette){ 
//renvoie le prochain numéro d'étape disponible pour une recette donnée
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT MAX(numEtape) AS nextPosition
							FROM EtapesPreparations
							WHERE idrecette LIKE ?");
							
	$result->execute(array($idrecette));
	$link = NULL ;
	
	if($result->rowCount()==1) {	//test si le résultat de la requete SQL renvoie une seule chose
		$row = $result->fetch(PDO::FETCH_ASSOC);
		return ($row['nextPosition']+1);
	}
	else {		
		return 1; // si rien n'est renvoyé cela veut dire que la recette n'a pas d'étapes donc la premiere position est 1
	}
}


//--------------------------- recherchePictureAlreadyUsedRecette ------------------------
function recherchePictureAlreadyUsedRecette($idimage){ 
//recherche si l'image en parametres est déja utilisé par une recette
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idrecette 
							FROM ImagesRecettes
							WHERE idimgRecettes LIKE ?");
							
	$result->execute(array($idimage));
	$link = NULL ;
	
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ($row['idrecette']!=NULL){
		return TRUE;
	}
	
	else {		
		return FALSE;
	}
}


//--------------------------- recherchePictureAlreadyUsedIngre ------------------------
function recherchePictureAlreadyUsedIngre($idimage){ 
//recherche si l'image en parametres est déja utilisé par une recette
	$link = connexionUserPDO();
	
	$result = $link->prepare("SELECT idingredient
							FROM ImagesIngre
							WHERE idimgIngre LIKE ?");
							
	$result->execute(array($idimage));
	$link = NULL ;
	
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if ($row['idingredient']!=NULL){
		return TRUE;
	}
	
	else {		
		return FALSE;
	}
}


//-------------------------- checkInsertionImageRecette ------------------------

function checkInsertionImageRecette($image){ 
// $image est un tableau des attributs de l'image de recette qui va être inséré
//vérifie si l'image à un nom et un chemin unique

	$checkNom = checkDispoNomImageRecette($image);
	$checkChemin = checkDispoCheminImageRecette($image);
	
	if($checkNom && $checkChemin==FALSE){
		echo '<p>Chemin d\'image déja pris</p>';
		return FALSE;
	}
	elseif($checkNom==FALSE && $checkChemin){
		echo '<p>Nom de l\'image déja pris</p>';
		return FALSE;
	}
	elseif($checkNom==FALSE && $checkChemin==FALSE){
		echo '<p>Nom et chemin de l\'image déja pris</p>';
		return FALSE;
	}
	else{
		return TRUE;
	}
}


// --checkDispoNomImageRecette

function checkDispoNomImageRecette($image){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgRecettes FROM ImagesRecettes WHERE imgRecetteNom= ? ');
				 
	$result->execute(array($image['imgRecetteNom']));
	$link = NULL ;
	
	if ($result->rowCount()>=1){
		return FALSE;
	}
	else return TRUE;
}


// --checkDispoCheminImageRecette

function checkDispoCheminImageRecette($image){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgRecettes FROM ImagesRecettes WHERE imgRecetteChemin= ? ');
				 
	$result->execute(array($image['imgRecetteChemin']));
	$link = NULL ;
	
	if ($result->rowCount()>=1){
		return FALSE;
	}
	else return TRUE;
}


//-------------------------- checkInsertionImageIngre ------------------------

function checkInsertionImageIngre($image){
// $image est un tableau des attributs de l'image d'ingrédient qui va être inséré
//vérifie si l'image à un nom et un chemin unique

	$checkNom = checkDispoNomImageIngre($image);
	$checkChemin = checkDispoCheminImageIngre($image);
	
	if($checkNom && $checkChemin==FALSE){
		echo '<p>Chemin d\'image déja pris</p>';
		return FALSE;
	}
	elseif($checkNom==FALSE && $checkChemin){
		echo '<p>Nom de l\'image déja pris</p>';
		return FALSE;
	}
	elseif($checkNom==FALSE && $checkChemin==FALSE){
		echo '<p>Nom et chemin de l\'image déja pris</p>';
		return FALSE;
	}
	else{
		return TRUE;
	}
}


// --checkDispoNomImageIngre

function checkDispoNomImageIngre($image){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgIngre FROM ImagesIngre WHERE imgIngreNom= ? ');
				 
	$result->execute(array($image['imgIngreNom']));
	$link = NULL ;
	
	if ($result->rowCount()>=1){
		return FALSE;
	}
	else return TRUE;
}


// --checkDispoCheminImageIngre

function checkDispoCheminImageIngre($image){
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT idimgIngre FROM ImagesIngre WHERE imgIngreChemin= ? ');
				 
	$result->execute(array($image['imgIngreChemin']));
	$link = NULL ;
	
	if ($result->rowCount()>=1){
		return FALSE;
	}
	else return TRUE;
}

?>
<?php

require_once('fonctionsRecherches.php');
require_once('fonctionsSuppression.php');
require_once('fonctionsInsertions.php');

//                ----------------------- Recette ---------------------------

//--------------------------- modifRecette ------------------------
function modifRecette($oldrecette, $newrecette){
//modifie les attributs d'une recette par rapport aux nouvelles valeurs renvoyées
	$id_old_recette = rechercheIdRecette($oldrecette['nomRecette']); //forcément différent de NULL car testé avant
	foreach($newrecette as $key => $value){ // on joue sur le fait que les clés ont les mêmes noms que les attributs de la table Recettes
		
		if ($value != $oldrecette[$key]){
			modifAttributRecette($key, $value, $id_old_recette); //ajouter une verif des types afin d'eviter les pb en sql
		}
	}
}


//--------------------------- modifAttributRecette ------------------------

function modifAttributRecette($colonne, $newvalue, $idrecette){
//fonction relié à modifRecette, elle permet de faire les modifications sur la table Recette de manière séparée donc plus lisible, 
//$colonne correspond à l'attribut à modifier, $newvalue à la nouvelle valeur
						
	$link = connexionUserPDO();
	$sql='UPDATE Recettes SET '.$colonne.' = ? WHERE idrecette = ?';
	$result = $link->prepare($sql);
				 
	$result->execute(array($newvalue, $idrecette));	
	$link = NULL ;			
}


//--------------------------- modifLiensIngredientRecette ------------------------

function modifLiensIngredientRecette($ingredients, $idrecette){
//modifie les lien entre des ingrédients et une recette
	/*
		dans l'ordre : 
		1.on supprime tout les liens de 'compose' qui ne se trouvent pas parmi les inputs renvoyés (utilité : si l'admin supprime la valeur d'un input pour supprimer le lien)
		2.on ajoute tout les liens avec les ingrédients des inputs en vérifiant de ne pas rajouter ceux qui existent déja (si il existe déja, l'ajout sera ignoré)
	*/
						
	//1.suppression des liens supprimés par l'admin
	
	$tabIDIngreNew = [];
		
	foreach($ingredients as $key => $value){ // $value représente le nom de l'ingrédient
	//on crée un tableau sans vide des ingrédients renvoyées par $_POST 
	//et on vérifie par la même occasion que les ingrédients existent bel et bien
		$value = trim($value);
		if($value != ""){ //permet d'ignorer les inputs vides
										
			$id = rechercheIdIngredient($value);
										
			if($id!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ingrédient existe, sinon il n'existe pas
				$tabIDIngreNew[]=$id;
			}
			else {
				echo "Impossible de récupérer l'ingrédient : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
			}
		}
	}
				
	if (!empty($tabIDIngreNew)){ //signifie qu'il reste des ingrédients liées à la recette
		supprimerLiensIngreRecetteABSURD ($tabIDIngreNew, $idrecette);
		
		//2. on ajoute tout les liens qui n'existent pas encore			
		insertLienRecetteIngre($idrecette, $tabIDIngreNew);	
	}
	else{ //touts les ingrédients sont supprimés
		supprimerLiensIngreRecette($idrecette, NULL);
	}
						
	
}


//--------------------------- modifLiensUstensilesRecette ------------------------

function modifLiensUstensileRecette($ustensiles, $idrecette){
	
	/*
		dans l'ordre : 
		1.on supprime tout les liens de 'compose' qui ne se trouvent pas parmi les inputs renvoyés (utilité : si l'admin supprime la valeur d'un input pour supprimer le lien)
		2.on ajoute tout les liens avec les ingrédients des inputs en vérifiant de ne pas rajouter ceux qui existent déja (si il existe déja, l'ajout sera ignoré)
	*/
						
	//1.suppression des liens supprimés par l'admin
	$tabIdUstensileNew = [];
		
	foreach($ustensiles as $key => $value){ 
	//on crée un tableau sans vide des ustensiles renvoyées par $_POST 
	//et on vérifie par la même occasion que les ustensiles existent bel et bien
		$value = trim($value);
		if($value != ""){ //permet d'ignorer les inputs vides
										
			$id = rechercheIdUstensile($value);
										
			if($id!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ingrédient existe, sinon il n'existe pas
				$tabIdUstensileNew[]=$id;
			}
			else {
				echo "Impossible de récupérer l'ustensile : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
			}
		}
	}
	if (!empty($tabIdUstensileNew)){
		supprimerLiensUstensileRecetteABSURD ($tabIdUstensileNew, $idrecette);
		
		//2. on ajoute tout les liens qui n'existent pas encore
		insertLienRecetteUstensile($idrecette, $tabIdUstensileNew);
	}
	else{
		supprimerLiensUstensileRecette($idrecette, NULL);
	}
	
}


//--------------------------- modifLiensCategRecette ------------------------

function modifLiensCategRecette($categories, $idrecette){
	/*
		dans l'ordre : 
		1.on supprime tout les liens de 'catégorise_recette' qui ne se trouvent pas parmi les inputs renvoyés (utilité : si l'admin supprime la valeur d'un input pour supprimer le lien)
		2.on ajoute tout les liens avec les categories saisies dans les inputs en vérifiant de ne pas rajouter ceux qui existent déja (si il existe déja, l'ajout sera ignoré)
	*/
						
	//1.suppression des liens supprimés par l'admin
	$tabIdCategNew = [];
		
	foreach($categories as $key => $value){ 
	//on crée un tableau sans vide des catégories renvoyées par $_POST 
	//et on vérifie par la même occasion que les catégories existent bel et bien
		$value = trim($value);
		if($value != ""){ //permet d'ignorer les inputs vides
										
			$id = rechercheIdCategRecette($value);
										
			if($id!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ingrédient existe, sinon il n'existe pas
				$tabIdCategNew[]=$id;
			}
			else {
				echo "Impossible de récupérer la catégorie : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
			}
		}
	}
	if (!empty($tabIdCategNew)){
		supprimerLiensCategRecetteABSURD ($tabIdCategNew, $idrecette);
		
		//2. on ajoute tout les liens qui n'existent pas encore
		insertLienCategorieRecette($idrecette, $tabIdCategNew); //!!!!!!!!!!!!!!!
	}
	else{
		supprimerLiensCategRecette($idrecette, NULL);
	}	
}



//                ----------------------- Ingredient ---------------------------

//--------------------------- modifIngredient ------------------------

function modifIngredient($oldingre, $newingre){
// modifie les attributs d'un ingrédient avec de nouveaux renvoyées ($newingre)
	$id_old_ingre = rechercheIdIngredient($oldingre['nomIngre']);
	foreach($newingre as $key => $value){ // on joue sur le fait que les clés ont les mêmes noms que les attributs de la table Ingredients
		
		if ($value != $oldingre[$key]){
			modifAttributIngredient($key, $value, $id_old_ingre); //ajouter une verif des types afin d'eviter les pb en sql
		}
	}
	echo "Changements effectués";
}


//--------------------------- modifAttributIngredient ------------------------

function modifAttributIngredient($colonne, $newvalue, $idingredient){
//fonction relié à modifIngredient, elle permet de faire les modifications sur la table Ingredients de manière séparée donc plus lisible, 
								
	$link = connexionUserPDO();
	
	$sql='UPDATE Ingredients SET '.$colonne.' = ? WHERE idingredient = ?';
	$result = $link->prepare($sql);
				 
	$result->execute(array($newvalue, $idingredient));		
	$link = NULL ;		
}


//--------------------------- modifLiensCategIngredient ------------------------

function modifLiensCategIngredient($categories, $idingredient){
	/*
		dans l'ordre : 
		1.on supprime tout les liens de 'catégorise_ingredient' qui ne se trouvent pas parmi les inputs renvoyés (utilité : si l'admin supprime la valeur d'un input pour supprimer le lien)
		2.on ajoute tout les liens avec les categories saisies dans les inputs en vérifiant de ne pas rajouter ceux qui existent déja (si il existe déja, l'ajout sera ignoré)
	*/
						
	//1.suppression des liens supprimés par l'admin
	$tabIdCategNew = [];
		
	foreach($categories as $key => $value){ 
	//on crée un tableau sans vide des catégories renvoyées par $_POST 
	//et on vérifie par la même occasion que les catégories existent bel et bien
		$value = trim($value);
		if($value != ""){ //permet d'ignorer les inputs vides
										
			$id = rechercheIdCategIngre($value);
										
			if($id!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ingrédient existe, sinon il n'existe pas
				$tabIdCategNew[]=$id;
			}
			else {
				echo "Impossible de récupérer la catégorie : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
			}
		}
	}
	if (!empty($tabIdCategNew)){
		supprimerLiensCategIngredientABSURD ($tabIdCategNew, $idingredient);
		
		//2. on ajoute tout les liens qui n'existent pas encore
		insertLienCategorieIngredient($idingredient, $tabIdCategNew);
	}
	else{
		supprimerLiensCategIngredient($idingredient, NULL);
	}	
}



//                ----------------------- Ustensiles ---------------------------

//--------------------------- modifUstensile ------------------------

function modifUstensile($oldname, $newname){ //comme les ustensiles n'ont comme attribut pouvant être modifié leur nom, on mettra en paramêtre leur nom seulement
	$idustensile= rechercheIdUstensile($oldname);
	
	if($idustensile!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ustensile existe, sinon il n'existe pas
		$link = connexionUserPDO();
	
		$result = $link->prepare('UPDATE Ustensiles SET nomUstensile = ? WHERE idustensile = ?');
				 
		$result->execute(array($newname, $idustensile));
		$link = NULL ;
	}
	else {
		echo "Impossible de récupérer l'ustensile : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
	}
	
}



//                ----------------------- Etapes recettes ---------------------------

//--------------------------- modifEtapesRecette ------------------------

function modifEtapesRecette($etapes, $idrecette){ //$etapes est un tableau d'etapes

//on check d'abord l'ordre des etapes : si dans l'ordre de 1 en 1 alors pas de suppression donc on passe direct aux modif et ajouts
//sinon, la fonction qui check si l'ordre est bon renvoi le numéro ou l'ordre est rompu, et on change les numEtapes
//des recettes qui arrivent après en commencant par ce numéro retourné, puis on supprime et modifie

	//1.suppression des étapes supprimées par l'admin
	$tabEtapesNew = [];
		
	foreach($etapes as $key => $etape){ 
		//on crée un tableau sans vide des étapes renvoyées par $_POST 
		$etape['descEtape'] = trim($etape['descEtape']);
		if($etape["descEtape"] != ""){ //permet d'ignorer les inputs vides
			$tabEtapesNew[] = $etape;
		}
	}
		
	if (!empty($tabEtapesNew)){ //check si toutes les étapes sont supprimées ou non
		$checkOrdre = checkOrderEtapes($tabEtapesNew); //check si les étapes sont renvoyées dans l'ordre
		if($checkOrdre!=(-1)){ // pas le bon ordre
			//on remet dans le bon ordre les étapes
			for ($checkOrdre; $checkOrdre < count($tabEtapesNew); $checkOrdre++){
				$tabEtapesNew[$checkOrdre]["numEtape"] = $checkOrdre+1;
			}
			supprimerEtapesRecetteABSURD ($tabEtapesNew, $idrecette); 
			modifAttributEtapes($tabEtapesNew);
		}
		else{ //l'ordre est bon, on passe directement aux suppressions puis modifications
			supprimerEtapesRecetteABSURD ($tabEtapesNew, $idrecette);
			modifAttributEtapes($tabEtapesNew); 	
		}
	}
	
	//cas où toutes les étapes sont supprimées
	else{
		supprimerEtapesRecette(NULL, $idrecette); 
	}
	
}


//--------------------------- modifAttributEtapes ------------------------

function modifAttributEtapes($tabEtapes){ //ne change que la description des étapes du tableau en paramètre
								
	$link = connexionUserPDO();
	
	foreach($tabEtapes as $key => $etape){
		$result = $link->prepare('UPDATE EtapesPreparations SET descEtape = ?, numEtape = ? WHERE idetape = ?');
					 
		$result->execute(array($etape["descEtape"], $etape["numEtape"], $etape["idetape"]));
	}	
	$link = NULL ;
}


//--------------------------- checkOrderEtapes ------------------------

function checkOrderEtapes($etapes){ //permet de savoir si les étapes sont rangées dans l'ordre : on commence par 1 et on va de 1 en 1
	for ($i = 0; $i<count($etapes); $i++){
		if ($etapes[$i]["numEtape"]!= $i+1){
			return $i; //si l'ordre n'est pas bon, la fonction renvoie la position de tableau ou il y a un problème ($i)
		}
	}
	return (-1);
}



//                ----------------------- Catégories ---------------------------

//--------------------------- modifCatégorieRecette ------------------------

function modifCatégorieRecette($oldname, $newname){ //comme les ustensiles n'ont comme attribut pouvant être modifié leur nom, on mettra en paramêtre leur nom seulement
	$idcateg= rechercheIdCategRecette($oldname);
	
	if($idcateg!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que l'ustensile existe, sinon il n'existe pas
		$link = connexionUserPDO();
	
		$result = $link->prepare($sql='UPDATE CategoriesRecettes SET libCategorieRecette = ? WHERE idcategorieRecette = ?');
				 
		$result->execute(array($newname, $idcateg));
		$link = NULL ;
	}
	else {
		echo "Impossible de récupérer la catégorie : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
	}
	
}


//--------------------------- modifCatégorieIngredient ------------------------

function modifCatégorieIngredient($oldname, $newname){ //comme les catégories n'ont comme attribut pouvant être modifié leur nom, on mettra en paramêtre leur nom seulement
	$idcateg= rechercheIdCategIngre($oldname);
	
	if($idcateg!=NULL){ //si un id différent de NULL est renvoyé cela veut dire que la categorie existe, sinon elle n'existe pas
		$link = connexionUserPDO();
	
		$result = $link->prepare($sql='UPDATE CategoriesIngredients SET libCategorieIngredient = ? WHERE idcategorieIngredient = ?');
				 
		$result->execute(array($newname, $idcateg));
		$link = NULL ;
	}
	else {
		echo "Impossible de récupérer la catégorie : ".$value.'<br>'; //a rajouter si possible : faire pop un message d'erreur a l'admin
	}
	
}



//                ----------------------- Images ---------------------------

//--------------------------- modifImageRecette ------------------------

function modifImageRecette($newimage, $oldimage){
	
	$sql = 'UPDATE ImagesRecettes SET';
	$tab = [];
	
	//on forme la requete sql à partir des éléments renvoyés
	// on regarde si chaque attribut est différent d'avant ou non afin d'avoir un meilleur suivi des modifications
	if($newimage['imgRecetteNom']!=$oldimage['imgRecetteNom']){
		$link = connexionUserPDO();	
		$result = $link->prepare('SELECT idimgRecettes FROM ImagesRecettes WHERE imgRecetteNom LIKE ?');
		$result->execute(array($newimage['imgRecetteNom']));
		
		if($result->rowCount()>0){
			echo 'Nom déja utilisé donc pas de modification <br>';
		}
		else{
			$sql.= ' imgRecetteNom = ?';
			$tab[]=$newimage['imgRecetteNom'];
		}
	}
	
	if($newimage['imgRecetteChemin']!=$oldimage['imgRecetteChemin']){
		$link = connexionUserPDO();	
		$result = $link->prepare('SELECT idimgRecettes FROM ImagesRecettes WHERE imgRecetteChemin LIKE ?');
		$result->execute(array($newimage['imgRecetteChemin']));
		$link = NULL ;
		
		if($result->rowCount()>0){
			echo 'Chemin déja utilisé donc pas de modification <br>';
		}
		else{
			if(!empty($tab)){ //test pour savoir si il faur ajouter une virgule ou pas dans la requete sql
				$sql.= ' ,imgRecetteChemin = ?';
				$tab[]=$newimage['imgRecetteChemin'];				
			}
			else{
				$sql.= ' imgRecetteChemin = ?';
				$tab[]=$newimage['imgRecetteChemin'];				
			}

		}		
	}
	if($newimage['imgRecetteDesc']!=$oldimage['imgRecetteDesc']){
		if(!empty($tab)){
			$sql.= ' ,imgRecetteDesc = ?';
			$tab[] = $newimage['imgRecetteDesc'];			
		}
		else{
			$sql.= ' imgRecetteDesc = ?';
			$tab[] = $newimage['imgRecetteDesc'];		
		}
	}
	
	if(!empty($tab)){
		$link = connexionUserPDO();	
		$sql.= ' WHERE idimgRecettes = ?';
		$tab[] = $newimage['idimgRecettes'];
		$result = $link->prepare($sql);
		$result->execute($tab);
		echo 'Modifications faites <br>';
	}
	else{
		echo 'Rien n\'a été modifié <br>';
	}
	
}


//--------------------------- modifImageIngre ------------------------

function modifImageIngre($newimage, $oldimage){
		
	$sql = 'UPDATE ImagesIngre SET';
	$tab = [];
	
	if($newimage['imgIngreNom']!=$oldimage['imgIngreNom']){
		$link = connexionUserPDO();	
		$result = $link->prepare('SELECT idimgIngre FROM ImagesIngre WHERE imgIngreNom LIKE ?');
		$result->execute(array($newimage['imgIngreNom']));
		$link = NULL ;
		
		if($result->rowCount()>0){
			echo 'Nom déja utilisé donc pas de modification <br>';
		}
		else{
			$sql.= ' imgIngreNom = ?';
			$tab[]=$newimage['imgIngreNom'];
		}
	}
	
	if($newimage['imgIngreChemin']!=$oldimage['imgIngreChemin']){
		$link = connexionUserPDO();	
		$result = $link->prepare('SELECT idimgIngre FROM ImagesIngre WHERE imgIngreChemin LIKE ?');
		$result->execute(array($newimage['imgIngreChemin']));
		$link = NULL ;
		
		if($result->rowCount()>0){
			echo 'Chemin déja utilisé donc pas de modification<br>';
		}
		else{
			if(!empty($tab)){
				$sql.= ' ,imgIngreChemin = ?';
				$tab[]=$newimage['imgIngreChemin'];
			}
			else{
				$sql.= ' imgIngreChemin = ?';
				$tab[]=$newimage['imgIngreChemin'];
			}
		}		
	}
	if($newimage['imgIngreDesc']!=$oldimage['imgIngreDesc']){
		if(!empty($tab)){
			$sql.= ' ,imgIngreDesc = ?';
			$tab[] = $newimage['imgIngreDesc'];
		}
		else{
			$sql.= ' imgIngreDesc = ?';
			$tab[] = $newimage['imgIngreDesc'];
		}
	}
	
	if(!empty($tab)){
		$link = connexionUserPDO();	
		$sql.= ' WHERE idimgIngre = ?';
		$tab[] = $newimage['idimgIngre'];
		$result = $link->prepare($sql);
		$result->execute($tab);
		$link = NULL ;
		echo 'Modifications faites<br>';
	}
	else{
		echo 'Rien n\'a été modifié<br>';
	}
}



//                ----------------------- Compte ---------------------------

//--------------------------- modifDroitsCompte ------------------------

function modifDroitsCompte($idcompte){
// change les droits d'administration d'un compte : si compte client alors passe administrateur et inversement
	$link = connexionUserPDO();	
	$result = $link->prepare("UPDATE Compte SET estAdmin = NOT estAdmin WHERE idcompte = ?");
	$result->execute(array($idcompte));	
	$link = NULL ;
}


?>


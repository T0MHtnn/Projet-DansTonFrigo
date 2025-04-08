<?php

require_once('fonctionsRecherches.php');

//                ----------------------- Recette ---------------------------

//--------------------------- SupprimerRecette ------------------------

function supprimerRecette($nomRecette){ //supprime la recette mise en parametres ainsi que ses liens avec les différentes tables
	$idrecette = rechercheIdRecette($nomRecette);
	
	//suppression de tout les liens liés à recette
	supprimerLiensIngreRecette($idrecette, NULL);
	supprimerLiensUstensileRecette($idrecette, NULL);
	supprimerLiensCompteRecette($idrecette, NULL);
	supprimerLiensJourneeRecette($idrecette, NULL); 
	supprimerLiensCategRecette ($idrecette, NULL);
	supprimerEtapesPrerequisRecette (NULL, $idrecette);
	supprimerLienImageRecette($idrecette, NULL);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Recettes WHERE idRecette = ?');
				 
	$result->execute(array($idrecette));
	$link = NULL ; 
}


//--------------------------- SupprimerEtapesRecetteAbsurd ------------------------

function supprimerEtapesRecetteABSURD ($tabEtapes, $idrecette){ 
//supprime les étapes qui ne se trouvent pas dans $tabEtapes (d'où le ABSURD)
	$link = connexionUserPDO();	
	
	$sql = 'DELETE FROM EtapesPreparations
			WHERE idrecette = ?';
	
	$tabExec = [];
	$tabExec[] = $idrecette;
	foreach ($tabEtapes as $key => $etape){
		$tabExec[]=$etape["idetape"];
		$sql.=' AND idetape != ?';
	}
	
	$sql.= ' AND numEtape != 0';
		
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	$link = NULL ; 
}


//--------------------------- SupprimerEtapesRecette ------------------------

function supprimerEtapesRecette ($idetape, $idrecette){
//cette fonction a 3 utilités : supprimer toutes les étapes en fonction d'un id de recette ou d'un idetape ou en prenant compte les 2
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idetape!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ?');
		$result->execute(array($idetape));
		$link = NULL ; 
	}
	elseif($idetape==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idrecette = ? AND numEtape != 0');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idetape != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ? AND idrecette= ? AND numEtape != 0');
		$result->execute(array($idetape, $idrecette));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerEtapesRecette";
		$link = NULL ; 
	}
	
}


//--------------------------- SupprimerEtapesPrerequisRecette ------------------------

function supprimerEtapesPrerequisRecette ($idetape, $idrecette){
//cette fonction a 3 utilités : supprimer toutes les étapes en fonction d'un id de recette ou d'un idetape ou en prenant compte les 2
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idetape!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ?');
		$result->execute(array($idetape));
		$link = NULL ; 
	}
	elseif($idetape==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idrecette = ? ');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idetape != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ? AND idrecette= ? ');
		$result->execute(array($idetape, $idrecette));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerEtapesRecette";
		$link = NULL ; 
	}
	
}


//--------------------------- SupprimerLiensJourneeRecette ------------------------

function supprimerLiensJourneeRecette ($idrecette, $idjour){
//cette fonction a 3 utilités : supprimer toutes les étapes en fonction d'un id de recette ou d'un idjour ou en prenant compte les 2
		
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idjour != NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idjour = ?');
		$result->execute(array($idjour));
		$link = NULL ; 
	}
	elseif($idjour==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idRecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idjour != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idRecette = ? AND idjour = ?');
		$result->execute(array($idrecette, $idjour));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensJourneeRecette";
		$link = NULL ; 
	}
}



//                ----------------------- Ingredient ---------------------------

//--------------------------- SupprimerIngredient ------------------------

function supprimerIngredient($nomIngre){
//supprimer l'ingrédient dont le nom est en paramètres
	$idingre = rechercheIdIngredient($nomIngre);
	
	supprimerLiensIngreRecette(NULL, $idingre);
	supprimerLiensCategIngredient($idingre, NULL);
	supprimerLienImageIngre($idingre, NULL);
	
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Ingredients WHERE idingredient = ?');
				 
	$result->execute(array($idingre));
	$link = NULL ; 
}


//--------------------------- SupprimerLiensIngreRecette ------------------------

function supprimerLiensIngreRecette ($idrecette, $idingre){
//cette fonction a 3 utilités : supprimer toutes les étapes en fonction d'un id de recette ou d'un idingredient ou en prenant compte les 2
	
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idingre != NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idingredient = ?');
		$result->execute(array($idingre));
		$link = NULL ; 
	}
	elseif($idingre==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idRecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idingre != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idRecette = ? AND idingredient= ?');
		$result->execute(array($idrecette, $idingre));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensIngreRecette";
		$link = NULL ; 
	}
}


//--------------------------- SupprimerLiensIngreRecetteABSURD ------------------------

function supprimerLiensIngreRecetteABSURD ($tabIdIngre, $idrecette){ 
/* Attention, le fait que la fonction soit appelé comme ABSURD à une raison : 
	Le tableau $tabIDIngre est composé des éléments à ne pas enlever
	Cette fonction est là pour simplifier la suppression lors de la modification des ingrédients d'une recette 
	(même si on y perd en logique, on y gagne en temps de calcul et simplicité)
*/
	$link = connexionUserPDO();
	
	$sql = 'DELETE FROM compose
			WHERE idRecette = ?';
	
	$tabExec = [];
	$tabExec[] = $idrecette;
	foreach ($tabIdIngre as $key => $idingre){
		$tabExec[]=$idingre;
		$sql.=" AND idingredient != ?";
	}
	
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	$link = NULL ; 
}



//                ----------------------- Ustensile ---------------------------

//--------------------------- SupprimerUstensile ------------------------

function supprimerUstensile($nomUstensile){
	$idustensile = rechercheIdUstensile($nomUstensile);
	supprimerLiensUstensileRecette(NULL, $idustensile);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Ustensiles WHERE idustensile = ?');
				 
	$result->execute(array($idustensile));	
	$link = NULL ; 
}


//--------------------------- SupprimerLiensUstensileRecette ------------------------

function supprimerLiensUstensileRecette ($idrecette, $idustensile){

	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idustensile!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idustensile = ?');
		$result->execute(array($idustensile));
		$link = NULL ; 
	}
	elseif($idustensile==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idRecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idustensile != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idRecette = ? AND idustensile= ?');
		$result->execute(array($idrecette, $idustensile));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensUstensileRecette";
		$link = NULL ; 
	}
	
}


//--------------------------- SupprimerLiensUstensilesRecetteABSURD ------------------------

function supprimerLiensUstensileRecetteABSURD ($tabIdUstensiles, $idrecette){ 
/* Attention, le fait que la fonction soit appelé comme ABSURD à une raison : 
	Le tableau $tabIdUstensiles est composé des éléments à ne pas enlever
	Cette fonction est là pour simplifier la suppression lors de la modification des ustensiles d'une recette 
	(même si on y perd en logique, on y gagne en temps de calcul et simplicité)
*/	
	$link = connexionUserPDO();	
	
	$sql = 'DELETE FROM a_besoin_de
			WHERE idRecette = ?';
	
	$tabExec = [];
	$tabExec[] = $idrecette;
	foreach ($tabIdUstensiles as $key => $idustensile){
		$tabExec[]=$idustensile;
		$sql.=' AND idustensile != ?';
	}
	
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	$link = NULL ; 
}



//                ----------------------- Catégories ---------------------------

//--------------------------- SupprimerCategorieRecette ------------------------

function supprimerCategorieRecette($nomCateg){
	$idcategorie = rechercheIdCategRecette($nomCateg); 
	supprimerLiensCategRecette(NULL, $idcategorie);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM CategoriesRecettes WHERE idcategorieRecette = ?');
				 
	$result->execute(array($idcategorie));	
	$link = NULL ; 
}


//--------------------------- SupprimerCategorieIngredient ------------------------

function supprimerCategorieIngredient($nomCateg){
	$idcategorie = rechercheIdCategIngre($nomCateg); 
	supprimerLiensCategIngredient(NULL, $idcategorie);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM CategoriesIngredients WHERE idcategorieIngredient = ?');
				 
	$result->execute(array($idcategorie));	
	$link = NULL ; 
}


//--------------------------- SupprimerLiensCategRecette ------------------------

function supprimerLiensCategRecette ($idrecette, $idcateg){

	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idcateg!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idcategorieRecette = ?');
		$result->execute(array($idcateg));
		$link = NULL ; 
	}
	elseif($idcateg==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idRecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idcateg != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idRecette = ? AND idcategorieRecette= ?');
		$result->execute(array($idrecette, $idcateg));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCategRecette";
		$link = NULL ; 
	}
	
}


//--------------------------- SupprimerLiensCategRecetteABSURD ------------------------

function supprimerLiensCategRecetteABSURD ($tabIdCateg, $idrecette){ 
/* Attention, le fait que la fonction soit appelé comme ABSURD à une raison : 
	Le tableau $tabIDCateg est composé des éléments à ne pas enlever
	Cette fonction est là pour simplifier la suppression lors de la modification des catégories d'une recette 
	(même si on y perd en logique, on y gagne en temps de calcul et simplicité)
*/	
	$link = connexionUserPDO();	
	
	$sql = 'DELETE FROM categorise_recette
			WHERE idRecette = ?';
	
	$tabExec = [];
	$tabExec[] = $idrecette;
	foreach ($tabIdCateg as $key => $idcateg){
		$tabExec[]=$idcateg;
		$sql.=' AND idcategorieRecette != ?';
	}
	
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	$link = NULL ; 
}


//--------------------------- SupprimerLiensCategIngredient ------------------------

function supprimerLiensCategIngredient ($idingredient, $idcateg){

	$link = connexionUserPDO();
	
	if($idingredient==NULL && $idcateg!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idcategorieIngredient = ?');
		$result->execute(array($idcateg));
		$link = NULL ; 
	}
	elseif($idcateg==NULL && $idingredient!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idingredient = ?');
		$result->execute(array($idingredient));
		$link = NULL ; 
	}
	elseif($idcateg != NULL && $idingredient!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idingredient = ? AND idcategorieIngredient= ?');
		$result->execute(array($idingredient, $idcateg));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCategRecette";
		$link = NULL ; 
	}
	
}


//--------------------------- SupprimerLiensCategIngredientABSURD ------------------------

function supprimerLiensCategIngredientABSURD ($tabIdCateg, $idingredient){ 
/* Attention, le fait que la fonction soit appelé comme ABSURD à une raison : 
	Le tableau $tabIDCateg est composé des éléments à ne pas enlever
	Cette fonction est là pour simplifier la suppression lors de la modification des catégories d'une recette 
	(même si on y perd en logique, on y gagne en temps de calcul et simplicité)
*/	
	$link = connexionUserPDO();	
	
	$sql = 'DELETE FROM categorise_ingredient
			WHERE idingredient = ?';
	
	$tabExec = [];
	$tabExec[] = $idingredient;
	foreach ($tabIdCateg as $key => $idcateg){
		$tabExec[]=$idcateg;
		$sql.=' AND idcategorieIngredient != ?';
	}
	
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	$link = NULL ; 
}



//                ----------------------- Images ---------------------------

//--------------------------- SupprimerImageIngre ------------------------

function supprimerImageIngre($idimage){
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM ImagesIngre WHERE idimgIngre = ?');
				 
	$result->execute(array($idimage));	
	$link = NULL ; 
}


//--------------------------- SupprimerImageRecette -----------------------

function supprimerImageRecette($idimage){
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM ImagesRecettes WHERE idimgRecettes = ?');
				 
	$result->execute(array($idimage));	
	$link = NULL ; 
}


//--------------------------- SupprimerLienImageRecette ------------------------

function supprimerLienImageRecette($idrecette, $idimage){ //cette fonction ne supprime pas l'image !! elle se charge juste de faire passer l'idrecette à NULL
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idimage!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idimgRecettes = ?');
		$result->execute(array($idimage));
		$link = NULL ; 
	}
	elseif($idimage==NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idrecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idimage != NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idimgRecettes = ? AND idrecette = ?');
		$result->execute(array($idimage, $idrecette));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensImageRecette";
		$link = NULL ; 
	}	
}


//--------------------------- SupprimerLienImageIngre ------------------------

function supprimerLienImageIngre($idingre, $idimage){ 
//cette fonction ne supprime pas l'image !! elle se charge juste de faire passer l'idrecette à NULL
	$link = connexionUserPDO();
	
	if($idingre==NULL && $idimage!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idimgIngre = ?');
		$result->execute(array($idimage));
		$link = NULL ; 
	}
	elseif($idimage==NULL && $idingre!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idingredient = ?');
		$result->execute(array($idingre));
		$link = NULL ; 
	}
	elseif($idimage != NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idimgIngre = ? AND idingredient = ?');
		$result->execute(array($idimage, $idingre));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensImageIngre";
		$link = NULL ; 
	}	
}



//                ----------------------- Compte ---------------------------

//--------------------------- SupprimerLiensCompteRecette ------------------------

function supprimerLiensCompteRecette ($idrecette, $idcompte){
		
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idcompte != NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idcompte = ?');
		$result->execute(array($idcompte));
		$link = NULL ; 
	}
	elseif($idcompte==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idRecette = ?');
		$result->execute(array($idrecette));
		$link = NULL ; 
	}
	elseif($idcompte != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idRecette = ? AND idcompte = ?');
		$result->execute(array($idrecette, $idcompte));
		$link = NULL ; 
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCompteRecette";
		$link = NULL ;
	}
}

?>
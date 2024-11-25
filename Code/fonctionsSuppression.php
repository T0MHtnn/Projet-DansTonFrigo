<?php

function supprimerRecette($idrecette){ //supprime la recette mise en parametres ainsi que ses liens avec les différentes tables
	
	supprimerLiensIngreRecette($idrecette, NULL);
	supprimerLiensUstensileRecette($idrecette, NULL);
	supprimerLiensCompteRecette($idrecette, NULL);
	supprimerLiensJourneeRecette($idrecette, NULL);
	supprimerLiensCategRecette ($idrecette, NULL);
	supprimerEtapesRecette (NULL, $idrecette);
	supprimerLienImageRecette($idrecette, NULL);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Recettes WHERE idRecette = ?');
				 
	$result->execute(array($idrecette));
}

function supprimerIngredient($idingre){
	supprimerLiensIngreRecette(NULL, $idingre);
	supprimerLiensCategIngredient($idingre, NULL);
	supprimerLienImageIngre($idingre, NULL);
	
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Ingredients WHERE idingredient = ?');
				 
	$result->execute(array($idingre));
}

function supprimerUstensile($idustensile){
	supprimerLiensUstensileRecette(NULL, $idustensile);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM Ustensiles WHERE idustensile = ?');
				 
	$result->execute(array($idustensile));	
}

function supprimerCategorieRecette($idcateg){
	supprimerLiensCategRecette(NULL, $idcateg);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM CategoriesRecettes WHERE idcategorieRecette = ?');
				 
	$result->execute(array($idcateg));	
}

function supprimerCategorieIngredient($idcateg){
	supprimerLiensCategIngredient(NULL, $idcateg);
							
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM CategoriesIngredients WHERE idcategorieIngredient = ?');
				 
	$result->execute(array($idcateg));	
}

function supprimerLiensIngreRecette ($idrecette, $idingre){
		
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idingre != NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idingredient = ?');
		$result->execute(array($idingre));
	}
	elseif($idingre==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idRecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idingre != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM compose WHERE idRecette = ? AND idingredient= ?');
		$result->execute(array($idrecette, $idingre));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensIngreRecette";
	}
}

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
	
}

function supprimerLiensUstensileRecette ($idrecette, $idustensile){

	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idustensile!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idustensile = ?');
		$result->execute(array($idustensile));
	}
	elseif($idustensile==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idRecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idustensile != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM a_besoin_de WHERE idRecette = ? AND idustensile= ?');
		$result->execute(array($idrecette, $idustensile));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensUstensileRecette";
	}
	
}

function supprimerLiensUstensileRecetteABSURD ($tabIdUstensiles, $idrecette){ 
/* Attention, le fait que la fonction soit appelé comme ABSURD à une raison : 
	Le tableau $tabIDUstensiles est composé des éléments à ne pas enlever
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
	
}


function supprimerLiensCategRecette ($idrecette, $idcateg){

	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idcateg!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idcategorieRecette = ?');
		$result->execute(array($idcateg));
	}
	elseif($idcateg==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idRecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idcateg != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM categorise_recette WHERE idRecette = ? AND idcategorieRecette= ?');
		$result->execute(array($idrecette, $idcateg));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCategRecette";
	}
	
}

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
	
}


function supprimerLiensCategIngredient ($idingredient, $idcateg){

	$link = connexionUserPDO();
	
	if($idingredient==NULL && $idcateg!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idcategorieIngredient = ?');
		$result->execute(array($idcateg));
	}
	elseif($idcateg==NULL && $idingredient!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idingredient = ?');
		$result->execute(array($idingredient));
	}
	elseif($idcateg != NULL && $idingredient!=NULL){
		$result = $link->prepare('DELETE FROM categorise_ingredient WHERE idingredient = ? AND idcategorieIngredient= ?');
		$result->execute(array($idingredient, $idcateg));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCategRecette";
	}
	
}

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
	
}

function supprimerLienImageRecette($idrecette, $idimage){ //cette fonction ne supprime pas l'image !! elle se charge juste de faire passer l'idrecette à NULL
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idimage!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idimgRecettes = ?');
		$result->execute(array($idimage));
	}
	elseif($idimage==NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idrecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idimage != NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesRecettes SET idrecette = NULL WHERE idimgRecettes = ? AND idrecette = ?');
		$result->execute(array($idimage, $idrecette));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensImageRecette";
	}	
}

function supprimerImageRecette($idimage){
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM ImagesRecettes WHERE idimgRecettes = ?');
				 
	$result->execute(array($idimage));	
}

function supprimerLienImageIngre($idingre, $idimage){ //cette fonction ne supprime pas l'image !! elle se charge juste de faire passer l'idrecette à NULL
	$link = connexionUserPDO();
	
	if($idingre==NULL && $idimage!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idimgIngre = ?');
		$result->execute(array($idimage));
	}
	elseif($idimage==NULL && $idingre!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idingredient = ?');
		$result->execute(array($idingre));
	}
	elseif($idimage != NULL && $idrecette!=NULL){
		$result = $link->prepare('UPDATE ImagesIngre SET idingredient = NULL WHERE idimgIngre = ? AND idingredient = ?');
		$result->execute(array($idimage, $idingre));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensImageIngre";
	}	
}

function supprimerImageIngre($idimage){
	$link = connexionUserPDO();
	
	$result = $link->prepare('DELETE FROM ImagesIngre WHERE idimgIngre = ?');
				 
	$result->execute(array($idimage));	
}

function supprimerEtapesRecette ($idetape, $idrecette){

	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idetape!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ?');
		$result->execute(array($idetape));
	}
	elseif($idetape==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idrecette = ? AND numEtape != 0');
		$result->execute(array($idrecette));
	}
	elseif($idetape != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM EtapesPreparations WHERE idetape = ? AND idrecette= ? AND numEtape != 0');
		$result->execute(array($idetape, $idrecette));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerEtapesRecette";
	}
	
}

function supprimerLiensCompteRecette ($idrecette, $idcompte){
	
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idcompte != NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idcompte = ?');
		$result->execute(array($idcompte));
	}
	elseif($idcompte==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idRecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idcompte != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_favori WHERE idRecette = ? AND idcompte = ?');
		$result->execute(array($idrecette, $idcompte));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensCompteRecette";
	}
}

function supprimerLiensJourneeRecette ($idrecette, $idjour){
		
	$link = connexionUserPDO();
	
	if($idrecette==NULL && $idjour != NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idjour = ?');
		$result->execute(array($idjour));
	}
	elseif($idjour==NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idRecette = ?');
		$result->execute(array($idrecette));
	}
	elseif($idjour != NULL && $idrecette!=NULL){
		$result = $link->prepare('DELETE FROM est_prevu_pour WHERE idRecette = ? AND idjour = ?');
		$result->execute(array($idrecette, $idjour));
	}
	else{
		echo "erreur de paramètres pour l'appel de supprimerLiensJourneeRecette";
	}
}

function supprimerEtapesRecetteABSURD ($tabEtapes, $idrecette){ 

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
	
	echo 'requete sql suppression absurde : '.$sql;
	
	$result = $link->prepare($sql);
				 
	$result->execute($tabExec);
	
}


?>
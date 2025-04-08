<?php

//--------------------- AfficheRecetteModif ---------------------------

function afficheRecettesModif($nomRecette) { //prend un résultat d'une requete sql "SELECT" renvoyant une recette

//cette fonction affiche toutes les recettes qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère toutes les recettes correspondantes à la chaine entrée dans la recherche
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT nomRecette FROM Recettes WHERE nomRecette LIKE ? ');
	$result->execute(array("%".$nomRecette."%"));	
	
	//affiche une liste repertoriant toutes les recettes renvoyées avec un bouton pour les modifier
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td> Nom de la recette <td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifRecette.php" method="post">
					<input type="text" name="nomRecette" value="'.$row['nomRecette'].'" hidden>
					<p>' . $row['nomRecette'] . '
					<input type="submit" name="boutonModifier" value="Modifier">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";
	
	$link = NULL;
}


//--------------------- AfficheIngredientModif ---------------------------

function afficheIngredientsModif($nomIngre) { //prend un résultat d'une requete sql "SELECT" renvoyant un ingrédient

//cette fonction affiche touts les ingrédients qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère touts les ingrédients correspondants à la chaine entrée dans la recherche
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT nomIngre FROM Ingredients WHERE nomIngre LIKE ? ');
	$result->execute(array("%".$nomIngre."%"));		
	
	//on affiche une liste repertoriant touts les ingrédients renvoyées avec un bouton pour les modifier
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){ //évite d'avoir une recherche trop grosse et qui donnerait une page très longue
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td> Nom de l\'ingrédient </td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){	
			echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifIngredient.php" method="post">
					<input type="text" name="nomIngre" value="'.$row['nomIngre'].'" hidden>
					<p>' . $row['nomIngre'] . '
					<input type="submit" name="boutonModifier" value="Modifier">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';	
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";

	$link = NULL;
}


//--------------------- AfficheUstensileModifSupp ---------------------------

function afficheUstensilesModifSupp($nomUstensile){

//cette fonction affiche touts les ustensiles qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère touts les ustensiles correspondants à la chaine entrée dans la recherche	
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT nomUstensile FROM Ustensiles WHERE nomUstensile LIKE ? ');
	
	$result->execute(array("%".$nomUstensile."%"));		
	
	//on affiche une liste repertoriant touts les ustensiles renvoyés avec un bouton pour les modifier et les supprimer
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo "<p>Modifier le nom d'un ustensile et cliquer sur modifier changera son nom<p>";
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td> Nom de l\'ustensile </td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifUstensile.php" method="post">
					<input type="text" name="nomUstensileAvant" value="'.$row['nomUstensile'].'" hidden>
					<p>
					<input type="text" name="nomUstensileApres" value="'.$row['nomUstensile'].'">
					<input type="submit" name="boutonModifier" value="Modifier le nom">
					<input type="submit" name="boutonSupprimer" value="Supprimer">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";	
	$link=NULL;
}


//--------------------- AfficheCategRecetteModifSupp ---------------------------

function afficheCategRecetteModifSupp($nomCategorie){
	
//cette fonction affiche toutes les catégories de recettes qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère toutes les catégories correspondants à la chaine entrée dans la recherche
	
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT libCategorieRecette FROM CategoriesRecettes WHERE libCategorieRecette LIKE ? ');
	
	$result->execute(array("%".$nomCategorie."%"));		
		
	//on affiche une liste repertoriant toutes les catégories de recettes renvoyées avec un bouton pour les modifier et les supprimer
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo "<p>Modifier le nom d'une catégorie et cliquer sur modifier changera son nom</p>";
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td> Nom de la catégorie de recette </td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifCategRecette.php" method="post">
					<input type="text" name="nomCategAvant" value="'.$row['libCategorieRecette'].'" hidden>
					<p>
					<input type="text" name="nomCategApres" value="'.$row['libCategorieRecette'].'">
					<input type="submit" name="boutonModifier" value="Modifier le nom">
					<input type="submit" name="boutonSupprimer" value="Supprimer">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';	
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";
	$link=NULL;
}


//--------------------- AfficheCategIngredientModifSupp ---------------------------

function afficheCategIngredientModifSupp($nomCategorie){

//cette fonction affiche toutes les catégories d'ingrédients qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère toutes les catégories correspondants à la chaine entrée dans la recherche
	
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT libCategorieIngredient FROM CategoriesIngredients WHERE libCategorieIngredient LIKE ? ');
	
	$result->execute(array("%".$nomCategorie."%"));		
	
	//on affiche une liste repertoriant toutes les catégories d'ingrédients renvoyées avec un bouton pour les modifier et les supprimer	
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo "<p>Modifier le nom d'une catégorie et cliquer sur modifier changera son nom</p>";
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td> Nom de la catégorie d\'ingrédient </td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifCategIngre.php" method="post">
					<input type="text" name="nomCategAvant" value="'.$row['libCategorieIngredient'].'" hidden>
					<p>
					<input type="text" name="nomCategApres" value="'.$row['libCategorieIngredient'].'">
					<input type="submit" name="boutonModifier" value="Modifier le nom">
					<input type="submit" name="boutonSupprimer" value="Supprimer">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';	
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";
	$link=NULL;
}


//--------------------- AfficheImageRecetteModif ---------------------------

function afficheImageRecetteModif($nomImage){
	
//cette fonction affiche toutes les images de recettes qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère toutes les images correspondantes à la chaine entrée dans la recherche
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT imgRecetteNom, idimgRecettes FROM ImagesRecettes WHERE imgRecetteNom LIKE ? ');
	$result->execute(array("%".$nomImage."%"));		
	
	//on affiche une liste repertoriant toutes les images de recettes renvoyées avec un bouton pour les modifier
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td>Nom de l\'image</td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td><form id="formulaireResultRecherche" action="ModifImageRecette.php" method="post">
					<input type="text" name="nomImage" value="'.$row["imgRecetteNom"].'" hidden>
					<input type="text" name="idimgRecettes" value="'.$row["idimgRecettes"].'" hidden>
					<p>' . $row["imgRecetteNom"] . '
					<input type="submit" name="boutonModifier" value="Modifier">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';	
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";	
	$link=NULL;
}


//--------------------- AfficheImageIngreModif ---------------------------

function afficheImageIngreModif($nomImage){

//cette fonction affiche toutes les images d'ingrédients qui pourraient correspondre à la chaîne de caractères en paramètres

	//récupère toutes les images correspondantes à la chaine entrée dans la recherche
	$link = connexionUserPDO();
	
	$result = $link->prepare('SELECT imgIngreNom, idimgIngre FROM ImagesIngre WHERE imgIngreNom LIKE ? ');
	$result->execute(array("%".$nomImage."%"));		
	
	//on affiche une liste repertoriant toutes les images d'ingrédients renvoyées avec un bouton pour les modifier	
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td>Nom de l\'image</td>';
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr class="ligne1">';
				echo '<td><form id="formulaireResultRecherche" action="ModifImageIngre.php" method="post">
					<input type="text" name="nomImage" value="'.$row["imgIngreNom"].'" hidden>
					<input type="text" name="idimgIngre" value="'.$row["idimgIngre"].'" hidden>
					<p>' . $row["imgIngreNom"] . '
					<input type="submit" name="boutonModifier" value="Modifier">
					</p> 
					</form></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";	
	$link=NULL;
}


//--------------------- AfficheComptes ---------------------------

function afficheComptes($nomUtilisateur, $filtre){
	
//récupère tout les comptes correspondants à la chaine entrée dans la recherche et en prenant en compte le filtre
	$link = connexionUserPDO();
	
	if ($filtre == "Client"){
		$result = $link->prepare('SELECT idcompte, nomUtilisateur, estAdmin FROM Compte WHERE nomUtilisateur LIKE ? AND estAdmin = FALSE');
		$result->execute(array("%".$nomUtilisateur."%"));	
	}
	elseif($filtre == "Admin"){
		$result = $link->prepare('SELECT idcompte, nomUtilisateur, estAdmin FROM Compte WHERE nomUtilisateur LIKE ? AND estAdmin = TRUE');
		$result->execute(array("%".$nomUtilisateur."%"));			
	}
	else{
		$result = $link->prepare('SELECT idcompte, nomUtilisateur, estAdmin FROM Compte WHERE nomUtilisateur LIKE ? ');
		$result->execute(array("%".$nomUtilisateur."%"));			
	}
	
	//on affiche une liste repertoriant toutes les comptes renvoyées avec un bouton pour modifier les droits d'administration	*
	$tailleResult = $result->rowCount();
	if ($tailleResult>0){
		if($tailleResult<30){
			echo '<table> ';
			echo '<tr class="texteGras">';
			echo '<td>Nom d\'utilisateur</td>';
			echo '<td>Fonction</td>';
			echo '<td></td>'; //colonne des boutons
			echo '</tr>';
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				echo '<tr>';
				echo '<td>' . $row["nomUtilisateur"].'</td>';
				if($row['estAdmin']){

					echo '<td>Admin';
					echo '<form id="formulaireResultComptes" action="ModifCompte.php" method="post">
						<input type="text" name="nomUtilisateur" value="'.$row["nomUtilisateur"].'" hidden>
						<input type="text" name="idcompte" value="'.$row["idcompte"].'" hidden>
						<div class="block"><input type="submit" name="boutonModifAdmin" class="input-res adaptBouton" value="Passer compte en client"></div>
						</form></td>';
					echo '</tr>';
				}
				else{
					echo '<td>Client';
					echo '<form id="formulaireResultComptes" action="ModifCompte.php" method="post">
						<input type="text" name="nomUtilisateur" value="'.$row["nomUtilisateur"].'" hidden>
						<input type="text" name="idcompte" value="'.$row["idcompte"].'" hidden>
						<div class="block"><input type="submit" name="boutonModifAdmin" class="input-res adaptBouton" value="Passer le compte en Admin"></div>
						</form></td>';
					echo '</tr>';
				}
			}
			echo '</table>';	
		}
		else
			echo '<p>Recherche trop vague, veuillez préciser votre recherche</p>';
	}
	else
		echo "<p>Pas de résultats pour votre recherche</p>";	
	$link=NULL;
}

?>
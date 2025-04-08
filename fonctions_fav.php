<?php
function favoris($bdd)
{
	
	if($_SESSION["connecte"]=true) {													// vérifie si il y a un compte connecté
		$requser = $bdd->query("SELECT * FROM compte");
		$re = $requser->fetch(PDO::FETCH_ASSOC);
		$_SESSION['idcompte'] = $re['idcompte'];
		$req = $bdd->prepare('SELECT * FROM est_favori JOIN recettes ON est_favori.idrecette = recettes.idrecette JOIN compte ON est_favori.idcompte = compte.idcompte WHERE compte.idcompte = ?');         //recherche les recettes dans la table est_favori du compte connecté
		$req->execute(array($_SESSION['idcompte']));
		
		while ($ligne = $req->fetch()) {
			echo '<div class="menuDroite">',
				 '<a href="Accueil.php/#'.$ligne["nomRecette"].'";  style="text-decoration:none; font-family:Handlee><div class="formFooter" style="height:60px;">',$ligne["nomRecette"], '</div></a><br>',					// affiche les recettes favoris
				 '<form method="POST" action="" class="formFooter">',
				 '<div class="bouton boutonFooter" style="height:60px;"><input type="submit" name="supr_fav" value="supprimer des favoris"></div>',								// affiche le bouton suprimer pour chaque recettes
				 '</form>',
				 '</div>';
			supprimer_favoris($ligne["nomRecette"]);
		} 
	}
	
	else {
		echo '<div class="menuDroite">',
			 '<div class="fakeimg" style="height:60px;">','Vous devez vous connecter pour voir votre liste de favoris.', '</div></div><br>';
	}
}


function ajouter_favoris($nomRec)
{
	$bdd = connexionUserPDO();
	if($_SESSION["connecte"]=true) 
	{
		echo '<form method="POST" action="">
			 <input type="submit" name="ajou_fav" value="ajouter aux favoris">
			 </form>';
		if(isset($_POST['ajou_fav']))									// si bouton ajou_fav appuyé alors ...
		{
			$requete = $bdd->query('SELECT idcompte FROM est_favori JOIN recettes ON est_favori.idrecette=recettes.idrecette WHERE nomRecette="'.$nomRec.'"');
			$requete->execute(array());
			if ($requete->fetch())										// si la recette préciser en paramètre est déjà dans favoris alors on ne la reajoute pas
			{
				echo "Vous avez déjà ajouté cet article en favoris."; 
			}
			else
			{
				$insert1 = $bdd->prepare('SELECT idrecette FROM recettes WHERE nomRecette ="'.$nomRec.'"');
				$insert1->execute(array());								// enregistre la recette
				while ($ligne = $insert1->fetch()) 
				{
					
					$insert2 = $bdd->prepare('INSERT INTO est_favori(idrecette,idcompte) VALUES ('.$ligne["idrecette"].','.$_SESSION["idcompte"].');');      // met la recette dans la table est_favori
					$insert2->execute(array());
					echo "L'article ".$nomRec." a été ajoutée en favoris !"; 
				}
			}
		}
		else{
		echo "Une erreur s'est produite";
		}
	}
} 



function supprimer_favoris($nomRec)
{
	$bdd = connexionUserPDO();
	if($_SESSION["connecte"]=true) 
	{
		if(isset($_POST['supr_fav']))											// si bouton supr_fav appuyé alors ...
		{
			$requete = $bdd->query('SELECT idcompte FROM est_favori JOIN recettes ON est_favori.idrecette=recettes.idrecette WHERE nomRecette="'.$nomRec.'"');   
			$requete->execute(array());
			if ($requete->fetch())
			{
				$retire1 = $bdd->prepare('SELECT idrecette FROM recettes WHERE nomRecette ="'.$nomRec.'"');						// enregistre l'id de la recette
				$retire1->execute(array());
				if ($li = $retire1->fetch())
				{
					$retire2 = $bdd->prepare('DELETE FROM est_favori WHERE idrecette ="'.$li["idrecette"].'" AND idcompte="'.$_SESSION["idcompte"].'"');				// supprime la recette de la base de donnée
					$retire2->execute(array());
					echo "L'article ".$nomRec." a été retiré des favoris !"; 
				}
			}
			else
			{
				echo "Une autre erreur s'est produite";
			}
		}
	}
} 


?>



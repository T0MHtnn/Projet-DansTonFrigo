<?php
// $bdd = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');		//trouver la bdd que j'ai créée sur mysql
require_once('connexionBDD.php');
require_once('component.php');
// $bdd = connexionUserPDO();
session_start();
if(isset($_SESSION['connecte']) AND !empty($_SESSION['connecte']))
{
	$connecte = true;
}
else
{
	$connecte = false;
}
if(isset($_POST['rechingr']) AND !empty(trim($_POST['rechingr'])))			//trim() -> enlève les espaces de début / fin
{
	$bdd = connexionUserPDO();
	$rechingr = htmlspecialchars($_POST['rechingr']);
	$rep = $bdd->query('SELECT nomIngre FROM ingredients WHERE nomIngre LIKE "%'.$rechingr.'%" ORDER BY idingredient DESC');
	$bdd = NULL;
}
if(isset($_POST['ajtlistingr']))		//bouton d'ajout à la liste d'ingrédient
{
	if(isset($_SESSION['listeingredient'])){
		$_SESSION['listeingredient'][] = $_POST['nomIngre'];
		$listeingredient = $_SESSION['listeingredient'];
	}
	else{
		$_SESSION['listeingredient'] = [];
		$_SESSION['listeingredient'][] = $_POST['nomIngre'];
		$listeingredient = $_SESSION['listeingredient'];
	}
}

/*Bouton supprimer ingredients de la liste*/

if(isset($_POST['suppingr'])){
	supprimeringredientliste($_POST['nomIngre']);
}
?>

<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Accueil Dans Ton Frigo !</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>

	<body>
		<!-- Header -->
		<div class="header">
			<?php headerPage(); ?>
		</div>


		<div class="menuGauche">
            <div class="side1">
                <h2 class="centrageTexte" >Vos ingrédients : </h2>

                <form method="POST" action="rechercheIngredient.php" >
                    <input type="search" name="rechingr" class="centrage saisieIngredient" size="20" placeholder=" Rechercher un ingrédient...">
                </form>
                            
            </div>

            <div class="side2">
				<?php 
                if(isset($_SESSION['listeingredient'])){
				foreach($_SESSION['listeingredient'] as $cle=>$valeur){
									echo '<ul>
									<li><form method="POST" action="rechercheIngredient.php">
									<input type="text" name="nomIngre" value="'.$valeur.'" hidden>'
									.$valeur.' <input type="submit" value="Supprimer" name="suppingr"></form></li>
									</ul>';
							}
							if(isset($_SESSION['dejaexist']) AND $_SESSION['dejaexist'] == true){
								if(isset($_SESSION['messg'])){
									echo $_SESSION['messg'];
								}
							}
						}
				?>
            </div>
            
			<div class="side3">
                <form method="POST" action="rechercher.php">
                    <button type=submit name="rechercheViaIngre" id="chercheRecetteIngredient" class="centrage" >
                       Rechercher une recette en fonction de mes ingrédients
                    </button>
                </form>
            </div>           
		</div>
		  
		<div class="main">
			<h2>Résultats de la recherche :</h2>
			<?php
			if(isset($rechingr)){
				if(isset($rep)){
					if($rep->rowCount() > 1){
						echo '<br>'.$rep->rowCount().' résultats trouvés !';
					}
					else{
						echo '<br>'.$rep->rowCount().' résultat trouvé !';
					}
					if($rep->rowCount() > 0) {
						
							echo '<ul>';
							while($a = $rep->fetch()) {
								echo '<li>
								<form method="POST" action="Accueil.php" >
								<input type="text" name="nomIngre" value="'. $a['nomIngre'].'" hidden>
								<p>'. $a['nomIngre'].' <input type="submit" name="ajtlistingr" value="Ajouter à ma liste d\'ingrédients"></p></form></li>';
							}
							echo '</ul>';
						
					}
					else{
						echo '<p>Aucun résultat pour :'. $rechingr.'</p>';
					}
				}
				else{
					echo '<p>Aucun résultat pour :'. $rechingr.'</p>';
				}
			}
			
			?>	
			<!-- Footer -->
			<div class="footer">
				<?php footer(); ?>
			</div>
		</div>
				
	</body>
</html>
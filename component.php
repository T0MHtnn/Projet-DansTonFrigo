<?php


function HeaderHtml($namePage) {

    switch($namePage){

        case "Accueil" :
            $name2 = "Page d'accueil";
            $description= "Page d'accueil du site dans ton frigo";
            break;

        case "Recettes" :
            $name2 = "Page recettes";
            $description= "Page sur laquelle on retrouve toutes les recettes disponibles";
            break;
        
        case "Recette" : // voir si on peut automatiser avec le bon nom de recette ex crepes
            $name2 = "Page d'une recette";
            $description= "Page d'une recette avec étapes/explications";         
            break;

       case "Connexion" :
            $name2 = "Page de connexion";
            $description= "Permet de se connecter ou de se créer un compte";
            break;

        case "Compte" : // meme chose que recette avec le nom de la personne
            $name2 = "Page du compte";
            $description= "Permet d'acceder au paramètres et spécialités d'un compte";
            break;
                    
        case "Help" :
            $name2 = "Page besoin d'aide";
            $description= "Page de réponses aux questions les plus posés";
            break;

    };

    echo '	
    <head>
		<meta charset="UTF-8">
		<title>'.$namePage.'</title>
		<link href="Style_Accueil1.css" rel="stylesheet">
		<meta name="'.$name2.'" content="'.$description.'">
	</head>
    ';

}

function HeaderPage() {
    
    echo '		<!-- Header -->

            <div class="accueil">

                <div class="mascotte"> ';
    
    $bool = (bool)rand(0, 1);
    if ($bool == 1) {
        echo '<img src="Images/Mascotte/sucrine1.png" class="image_mascotte"
            alt = "Image de la mascotte du site">';
    } else {
        echo '<img src="Images/Mascotte/tomate1.png" class="image_mascotte2"
            alt = "Image de la mascotte du site">';
    };
	
    echo '
                </div>

                <div class="titre">
                    <a href="Accueil.php" class="lienDiscret"><h1> Dans ton Frigo ! </h1></a>
                </div>

            </div>
            
            <div class="centrage boite_recherche">
                <form method="POST" action="rechercher.php" >
                    <input type="search" name="rech" class="centrage 
                    saisieRecette" size="50" placeholder=" Rechercher une recette...">
                </form>
            </div>
            
            <div class="navbar">';
            if(empty($_SESSION['connecte'])) {
				$pageCible = 'connexion.php';
			}
			else{
				$pageCible = 'connexionconnecte.php';
			}
			
			if(isset($_SESSION['nomUtilisateur'])){
				$nomUti = $_SESSION['nomUtilisateur'];
			} 
			else{
				$nomUti = 'Compte';
			} 
            
			echo '<a href="'.$pageCible.'" class="iconenav centrage lien_icone">
                    <img src="Images/Icones/compte.png" class="image_icone" alt="Icone du compte">
                    <p class="icone_texte">'.$nomUti.'</p>
                </a>

                <a href="Recettes.php" class="iconenav centrage lien_icone">
                    <img src="Images/Icones/livre_recette.png" class="image_icone" alt="Icone des recettes">
                    <p class="icone_texte">Recettes</p>
                </a>
                    
                <a href="Besoin_D\'aide.php" class="iconenav centrage lien_icone need_help">
                    <img src="Images/Icones/point_interrogation.png" class="image_icone" alt="Icone de besoin daide">
                    <p class="icone_texte">Besoin d aide ?</p>
                </a>
            
            </div>

    <!-- FIN DU HEADER --> 
    ';

}

function SlideBarGauche($numeroSide){

    switch($numeroSide){
        case "Side1" :
            echo '
                <div class="side1">
                    <h2 class="centrageTexte" >Vos ingrédients : </h2>

                    <form method="POST" action="rechercheIngredient.php" >
                        <input type="search" name="rechingr" class="centrage saisieIngredient" size="20" placeholder=" Rechercher un ingrédient...">
                    </form>
                            
                </div>
				
                    <div class="side2">';
                        if(isset($_SESSION['listeingredient'])){
							foreach($_SESSION['listeingredient'] as $cle=>$valeur){
									echo '<ul>
									<li><form method="POST" action="Accueil.php">
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
                	echo '</div>

                    <div class="side3">
                        <form method="POST" action="rechercher.php">
                            <button type=submit name="rechercheViaIngre" id="chercheRecetteIngredient" class="centrage" >
                                Rechercher une recette en fonction de mes ingrédients
                            </button>
                        </form>
                    </div>           
                ';
            break ;
        
        case "Side2" :
            echo '
                <div class="side1">
                    <a href="Accueil.php" id="retourAccueil" class="centrageTexte">
                    <p id="texteRetourAccueil">retour à l\'accueil</p>
                    </a>
                </div>
                <div class="side2-2">
                    <h2 class="centrageTexte" id="titreAdmin" >Tableau d\'administration</h2>
                    <div class="colonneGest">
                        <a href="ModifRecette.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Recettes</p></div></a><br>
                        <a href="ModifIngredient.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Ingrédients</p></div></a><br>
                        <a href="ModifUstensile.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Ustensiles</p></div></a><br>
                        <a href="ModifCategRecette.php" class="lienPageModif"><div class="panneauSide"><p class="textSide categ">Catégories de recettes</p></div></a><br>
                        <a href="ModifCategIngre.php" class="lienPageModif"><div class="panneauSide"><p class="textSide categ">Catégories d\'ingrédients</p></div></a><br>
                        <a href="ModifImageRecette.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Images de recettes</p></div></a><br>
                        <a href="ModifImageIngre.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Images d\'ingrédient</p></div></a><br>
                        <a href="ModifCompte.php" class="lienPageModif"><div class="panneauSide"><p class="textSide">Comptes</p></div></a><br>	
                        								
                    </div>
                </div>';
            break;

        case "Side3" :
            echo '
                <div class="side1">
                    <a href="Accueil.php" id="retourAccueil" class="centrageTexte">
                    <p id="texteRetourAccueil">retour à l\'accueil</p>
                    </a>
                </div>
                <div class="side2-2">
                    <div class="colonneGest">
                        <a href="#RC" class="lienPageModif"><div class="panneauSide"><p class="textSide">Recherche compliquée ?</p></div></a><br>
                        <a href="#F" class="lienPageModif"><div class="panneauSide"><p class="textSide">Favoris</p></div></a><br>
                        <a href="#R" class="lienPageModif"><div class="panneauSide"><p class="textSide">Recettes</p></div></a><br>
                        <a href="#E" class="lienPageModif"><div class="panneauSide"><p class="textSide">Emploi du temps</p></div></a><br>
                        <a href="#CO" class="lienPageModif"><div class="panneauSide"><p class="textSide">Un compte est-il obligatoire ?</p></div></a><br>
                        <a href="#BPA" class="lienPageModif"><div class="panneauSide"><p class="textSide">Besoin de plus d\'aide ? Contactez nous !</p></div></a><br>
                        <a href="#DM" class="lienPageModif"><div class="panneauSide"><p class="textSide">Devenir Modérateur</p></div></a><br>
                        <a href="#C" class="lienPageModif"><div class="panneauSide"><p class="textSide">Crédits</p></div></a><br>
                    </div>
                </div>
        ';

            break;
    }
    

}

function choixmain(){
	
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
						<form method="POST" action="" >
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
	if(isset($rech)){
		if(isset($rep)){
			echo'<h2>Résultats de la recherche :</h2>';
			if($rep->rowCount() > 0){
				echo'<ul>';
				while($a = $rep->fetch()) {
					echo '<li> 
					<div class="RecetteGauche">
						<h2>'.$nomRecette.'</h2>
						<div class="recette-img">
							<img src="" alt="Illustration de la recette">
						</div>
						<p>';
						if($a['nomRecette'] == "Pot au feu"){
							echo 'Pot au feu blablabla';
						}
						echo '</p>
					</div>
					<div class="RecetteDroite">
						<div class="recette-info">
							<div class="recette-difficulte">
								<span>Difficulté :</span>
								<span>'.$difficulte.'/5</span>
							</div>
							<br>
							<div class="recette-temps">
								<span>Temps :</span>
								<span>'.$tempsTotal.' minutes</span>
							</div>
						</div>
						
						<ul>';
							for($i=0;$i<count($tabingr) && $cpt!=3;$i++){
								echo '<li>'.$tabingr[$i]["nomIngre"].'</li>';
								$cpt++;
							}
							if($cpt>0){
								$cpt=0;
							}
						echo '</ul>
					</div>
					</li>';
				}
				echo '</ul>';
			}
			else {
				echo '<p>Aucun résultat pour : '.$rech.' </p>';
			}
		}
		else{
			echo '<p>Aucun résultat pour : '.$rech.'</p>';
		}
	}
	if(!isset($rechingr) AND !isset($rech)){
		
		echo '<h2>Recettes phares :</h2>

        <div class="contentR">

            <div class="R1">
            
                <div class="recette">

                    <div class="RecetteGauche">

                        <h2 class="centrageTexte">Tarte aux pommes</h2>

                        <div class="recette-img">
                            <img src="Images/tarteauxpommes.jpg" alt="Image de tarte aux pommes">
                        </div>

                        <p>Tarte aux pommes pouvant se décliner avec d’autres fruits. Ce dessert peu sucré fera la joie des petits comme des grands ! </p>
                    </div>

                    <div class="RecetteDroite">
                                    
                        <div class="recette-info">
                            <div class="recette-difficulte">
                                <span>Difficulté :</span>
                                <span>1/5</span>
                            </div>
                            <br>
                            <div class="recette-temps">
                                <span>Temps :</span>
                                <span>30 minutes</span>
                            </div>
                        </div>

                        <ul class="listeIng">
                            <li class="listIngSolo">Pommes</li>
                            <li class="listIngSolo">Pate feuilleté 2</li>
                            <li class="listIngSolo">Sucre</li>
                        </ul>

                
                        <img src="Images/etoile.png" class="image_icone" alt="Ajouter aux favoris" onclick="ajouter_favoris("Tarte pommes")">
                        
                    </div>
                </div>
            </div>

            <div class="R2">
                <div class="recette">

                    <div class="RecetteGauche">

                        <h2 class="centrageTexte">Melon d\'été</h2>

                        <div class="recette-img">
                            <img src="Images/melon.jpg" alt="Image de Melon">
                        </div>

                        <p>Une recette qui peut se décliner à la fois en entrée et en dessert !</p>
                    </div>

                    <div class="RecetteDroite">
                                    
                        <div class="recette-info">
                            <div class="recette-difficulte">
                                <span>Difficulté :</span>
                                <span>1/5</span>
                            </div>
                            <br>
                            <div class="recette-temps">
                                <span>Temps :</span>
                                <span>5 minutes</span>
                            </div>
                        </div>

                        <ul class="listeIng">
                            <li class="listIngSolo">Melon</li>
                            <li class="listIngSolo">Jambon sec espagnol</li>
                        </ul>

                
                        <img src="Images/etoile.png" class="image_icone" alt="Ajouter aux favoris" onclick="ajouter_favoris("Tarte pommes")">
                        
                    </div>
                </div>
            </div>

            <div class="R3">
            
                <div class="recette">

                    <div class="RecetteGauche">

                        <h2 class="centrageTexte">Potaufeu</h2>

                        <div class="recette-img">
                            <img src="Images/Potaufeu.jpg" alt="Image de Pot au feu">
                        </div>

                        <p>Un plat réconfortant avec des légumes aux choix !</p>
                    </div>

                    <div class="RecetteDroite">
                                    
                        <div class="recette-info">
                            <div class="recette-difficulte">
                                <span>Difficulté :</span>
                                <span>3/5</span>
                            </div>
                            <br>
                            <div class="recette-temps">
                                <span>Temps :</span>
                                <span>2 heures</span>
                            </div>
                        </div>

                        <ul class="listeIng">
                            <li class="listIngSolo">Viande</li>
                            <li class="listIngSolo">Carotte</li>
                            <li class="listIngSolo">Pommes de terres</li>
                        </ul>

                
                        <img src="Images/etoile.png" class="image_icone" alt="Ajouter aux favoris" onclick="ajouter_favoris("Potaufeu")">
                        
                    </div>
                </div>
            </div>

            <div class="R4">
            
                <div class="recette">

                    <div class="RecetteGauche">

                        <h2 class="centrageTexte">Gateau au Chocolat</h2>

                        <div class="recette-img">
                            <img src="Images/GateauChocolat.jpg" alt="Image de Gateau au Chocolat">
                        </div>

                        <p>Indéniablement le plat de notre enfance ! c\est la meilleur recette possible</p>
                    </div>

                    <div class="RecetteDroite">
                                    
                        <div class="recette-info">
                            <div class="recette-difficulte">
                                <span>Difficulté :</span>
                                <span>2/5</span>
                            </div>
                            <br>
                            <div class="recette-temps">
                                <span>Temps :</span>
                                <span>1 heure</span>
                            </div>
                        </div>

                        <ul class="listeIng">
                            <li class="listIngSolo">chocolat</li>
                            <li class="listIngSolo">oeufs</li>
                            <li class="listIngSolo">Sucre</li>

                        </ul>

                
                        <img src="Images/etoile.png" class="image_icone" alt="Ajouter aux favoris" onclick="ajouter_favoris("GateauChocolat")">
                        
                    </div>
                </div>
            </div>
        </div>
	';

    
    
	}
			
}

function footer(){
	echo '
	<div class="flex-footer">
		<form action="Besoin_D\'aide.php#BPA" method="post">
			<input type="submit" name="boutonContacter" class="bouton boutonFooter" value="Nous contacter">
		</form>
		
		<form action="Besoin_D\'aide.php#DM" method="post">
			<input type="submit" name="boutonDevenirModo" class="bouton boutonFooter" value="Devenir modérateur">
		</form>
	
		<form action="Besoin_D\'aide.php#C" method="post">
			<input type="submit" name="boutonCrédits" class="bouton boutonFooter" value="Crédits">
		</form>
	
	</div>';
}

?>
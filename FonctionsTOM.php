<html>
	<?php
	function accueil() {
		echo '<div class="side">
					<div class="elemHeader centrage boite_recherche">
						<p>Vos ingrédients</p>
						<form method="POST" action="rechercheIngredient.php" >
							<input type="search" name="rechingr" class="saisieRecette" size="50" placeholder=" Rechercher un ingrédient...">
							<!--<button type="submit" id="boutonLoupe"><img src="Images/loupe.png" id="loupe"></button>-->
						</form>';
						
						 
						if(!empty($_SESSION['listeingredient']))
						{
							"<ul>";
						}
							print_r($_SESSION['listeingredient']);
							foreach($_SESSION['listeingredient'] as $cle=>$valeur)
							{
								echo '<br><li>'.$valeur.'</li><br>';
							}
						if(!empty($_SESSION['listeingredient']))
						{
							"</ul>";
						}
						
						
					echo '</div>
				</div>
			  
			  <div class="main">
				<h2>Résultats de la recherche :</h2>
				<h5>Title description, Dec 7, 2017</h5>
				<div class="fakeimg" style="height:200px;">Image</div>
				<p>Some text..</p>
				<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
				<br>
				<h2>TITLE HEADING</h2>
				<h5>Title description, Sep 2, 2017</h5>
				<div class="fakeimg" style="height:200px;">Image</div>
				<p>Some text..</p>
				<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
			  </div>';
	}
	function connexion(){
		echo '<div class="side">
					<div class="elemHeader centrage boite_recherche">
						<form method="POST" action="rechercheIngredient.php" >
							<input type="search" name="rechingr" class="saisieRecette" size="50" placeholder=" Rechercher un ingrédient...">
							<!--<button type="submit" id="boutonLoupe"><img src="Images/loupe.png" id="loupe"></button>-->
						</form>
					</div>
					<!--
					<h2>About Me</h2>
					<h5>Photo of me:</h5>
					<div class="fakeimg" style="height:200px;">Image</div>
					<p>Some text about me in culpa qui officia deserunt mollit anim..</p>
					<h3>More Text</h3>
					<p>Lorem ipsum dolor sit ame.</p>
					<div class="fakeimg" style="height:60px;">Image</div><br>
					<div class="fakeimg" style="height:60px;">Image</div><br>
					<div class="fakeimg" style="height:60px;">Image</div>
					-->
				</div>
			  
			  <div class="main">
				<div align="center">
					<h2>Connexion</h2>
					<br><br>
					<form method="POST" action="">
						<!-- <input type="text" name="pseudoconnect" placeholder="Pseudo"> -->		<!-- Se connecter à partir du pseudo -->
						<input type="email" name="mailconnect" placeholder="mail">
						<input type="password" name="mdpconnect" placeholder="Mot de passe">
						<input type="submit" name="formconnexion" value="Se connecter">
					</form>';
					 if(isset($mot)){echo $mot;} 
					echo '<br>
					<p> Pas encore de compte ? <a href="inscription.php">Clique ici pour te créer un compte</a></p>';
					
						if(isset($erreur))
						{
							echo '<font color="red">'.$erreur."</font>";
						}
					
				echo '</div>
			  </div>';
	}
	
	function mainAccueil(){
		echo '
			<h2>Résultats de la recherche :</h2>
			<h5>Title description, Dec 7, 2017</h5>
			<div class="fakeimg" style="height:200px;">Image</div>
			<p>Some text..</p>
			<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
			<br>
			<h2>TITLE HEADING</h2>
			<h5>Title description, Sep 2, 2017</h5>
			<div class="fakeimg" style="height:200px;">Image</div>
			<p>Some text..</p>
			<p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
			';
	}
	function supprimeringredientliste($nomIngre){
		for( $i = 0 ; $i < $_SESSION['listeingredient']; $i++ ){
			if($_SESSION['listeingredient'][$i] == $nomIngre){
				unset($_SESSION['listeingredient'][$i]);
			}
		}
		
	}
	
	
	
	
	
	
	
	
	?>
</html>
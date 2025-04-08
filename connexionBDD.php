<?php

function connexionUser() {
  $link = mysqli_connect('localhost', 'root', '', 'danstonfrigo', 3306); //remplacer root par "nomutilisateur" et l'espace vide '' par un mot de passe si il y a un utilisateur crée pour la base

  if (!$link) {
    echo 'Erreur d\'accès à la base de données - FIN';
    exit;
    //ou die('Erreur d\'accès à la base de données - FIN')
  }
  return $link;
}


function connexionUserPDO(){
	$link = new PDO('mysql:host=127.0.0.1;dbname=danstonfrigo', 'root' , '');
	
	if (!$link) {
		echo 'Erreur d\'accès à la base de données - FIN';
		exit;
		//ou die('Erreur d\'accès à la base de données - FIN')
	}
	return $link;
}


?>

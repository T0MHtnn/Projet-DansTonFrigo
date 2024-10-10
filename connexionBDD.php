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

/* 
pour gérer les droits sur la base il y aura pt besoin de 2 façons de se connecter, l'une avec un compte utilisateur lambda
qui n'aura accès qu'aux SELECT partout et à INSERT ET DELETE pour gérer son compte, son emploi du temps et ses favoris, 
et l'autre avec un compte Admin qui pourra avoir tout les droits
*/


// pour cette fonction il faudra récupérer le mdp en amont via un formulaire
function connexionAdmin($mdp) {
  $link = mysqli_connect('localhost', 'Administrator', $mdp, 'danstonfrigo', 3306); 

  if (!$link) {
    echo 'Erreur d\'accès à la base de données - FIN';
    exit;
    //ou die('Erreur d\'accès à la base de données - FIN')
  }
  return $link;
}

?>

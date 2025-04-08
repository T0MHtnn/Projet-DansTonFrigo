<?php
session_start();			//Démarrer les sessions (nécésaire si on utilise les variables de sessions )
// $_SESSION = array();				//Vider les sessions (mettre les cellules du tableau vides)
// session_destroy();				//Detruire la session
unset($_SESSION['connecte']);
unset($_SESSION['idcompte']);
unset($_SESSION['nomUtilisateur']);
unset($_SESSION['mail']);
header("Location: connexion.php");
?>
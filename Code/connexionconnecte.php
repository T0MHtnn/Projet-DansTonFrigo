<?php
session_start();
header("Location:profil.php?idcompte=".$_SESSION['idcompte']);
?>

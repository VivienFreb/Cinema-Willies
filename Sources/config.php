<?php
	//Connexion Base de données
	try
	{
	   $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
	  die('Erreur : '.$e->getMessage());
	}


	// Path pour les affiches films
	$movie_path = "../Images/Film/";
	$acteur_path = "../Images/Acteur/";
	$realisateur_path = "../Images/Realisateur/";
	$img_extension = ".jpg";
?>
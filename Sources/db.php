<?php
	try
	{
	   //$bdd = new PDO('mysql:host=10.10.13.95;dbname=vFrebourg;charset=utf8', 'vFrebourg', 'vFrebourg');
	   //$mysqli = new mysqli("10.10.13.95", "vFrebourg", "vFrebourg", "vFrebourg");
	   $bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'CineUser', 'password');
	   $mysqli = new mysqli("localhost", "CineUser", "password", "cinema");
	}
	catch(Exception $e)
	{
	  echo "<p> Erreur ! " . $e->getMessage(). "</p>";
	}
?>
<!DOCTYPE html> 
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

	<link rel="stylesheet" href="css/bootstrap.min.css">


	<link rel="stylesheet" type="text/css" href="css/identifiants.css">

	<link rel="shortcut icon" type="image/x-icon" href="../Images/Affichage/shortcut-icon.png">

	<!-- Pour permettre à jQueryUI d'utiliser jQuery -->
	<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
	<script src="js/jquery.min.js"></script>    
	<script>if (window.module) module = window.module;</script>

	<script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>	 	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->


	<link rel="stylesheet" type="text/css" href="../Sources/css/header.css">
	<link rel="stylesheet" type="text/css" href="../Sources/css/style.css">
	<link rel="stylesheet" type="text/css" href="../Sources/css/film.css">
	<link rel="stylesheet" type="text/css" href="../Sources/css/accueil.css">

	<link rel="stylesheet" type="text/css" href="../Sources/css/reset.css">
	<link rel="stylesheet" type="text/css" href="../Sources/css/normalise.css">

	<title>Cinémas Willies : Films, Sorties cinémas, E-billet, Horaires</title>	
</head>

<?php
// session_cache_limiter('private_no_expire'); // works
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('db.php');
include_once('config.php');
include_once('object/Acteur.php');
include_once('object/Film.php');
include_once('object/Acteur_Film.php');
include_once('object/Horaire.php');
include_once('object/Cinema.php');
include_once('object/Ville.php');
include_once('object/Pays.php');
include_once('object/Categorie.php');
include_once('object/Categorie_Film.php');
include_once('object/Reservation.php');
include_once('object/Realisateur.php');
include_once('object/Realisateur_Film.php');

if(isset($_POST["email"], $_POST["pass"]))
{
	$requete = $bdd->prepare('SELECT `Id_Client`,`Nom`,`Prenom`,`Mail`,`Mdp` FROM `client` WHERE Mail = :mail');
	$requete->bindValue(':mail', $_POST["email"], PDO::PARAM_STR);
	$requete->execute();

	$donnees=$requete->fetch();

	if($donnees["Mdp"] == md5($_POST["pass"]))
	{
		$_SESSION['idclient'] = $donnees['Id_Client'];
		$_SESSION['nomclient'] = $donnees['Nom'];
		$_SESSION['prenomclient'] = $donnees['Prenom'];
		$_SESSION['mailclient'] = $donnees['Mail'];
		echo '<div class="alert alert-success" role="alert" >Connexion réussie ! <a href="index.php">Cliquez ici</a> pour revenir à la page d\'accueil.</div>';
		unset($_SESSION["save_email"]);
		header('Location: index.php');
	}else{
		echo '<div class="alert alert-danger">Mot de passe ou adresse mail non reconnu.</div>';
	}
}


if(isset($_POST["nbrPlaces"]))
{
	$idClient = $_SESSION['idclient'];
	$idHoraire = $_POST["idHoraire"];
	$nbrPlaces = $_POST["nbrPlaces"];
	$nbrPlacesRestantes = $_POST["nbrPlacesRestantes"];

	//On regarde si la personne a déjà réservée avant.

	$requete = $bdd->prepare("SELECT * FROM `reservation_film` WHERE Id_Client = ". $idClient . " AND Id_Horaire = ". $idHoraire);
	$requete->execute();

	if($requete->rowCount() > 0)
	{
		echo '<div class="alert alert-danger">Vous avez déjà réservé pour cette séance! Vous pouvez modifier votre réservation.</div>';
	}
	else // La personne n'a pas déjà réservée, on peut donc modifier la bdd
	{
		$newNbrPlaces = $nbrPlacesRestantes - $nbrPlaces;
		if($newNbrPlaces < 0)
		{
			echo '<div class="alert alert-danger">Erreur, votre réservation n\'a pas aboutie.</div>';			
		}else{
			$requete = $bdd->prepare("INSERT INTO `reservation_film` (`Id_Reservation`, `Id_Client`, `Id_Horaire`, `nbReserv`) VALUES (NULL,". $idClient .",". $idHoraire .",". $nbrPlaces .")");
			$requete->execute();

			$newNbrPlaces = $nbrPlacesRestantes - $nbrPlaces;

			$reqPlaces = $bdd->prepare("UPDATE `horaire` SET `Nbr_Places` = ". $newNbrPlaces ." WHERE `horaire`.`Id_Horaire` = ". $idHoraire);
			$reqPlaces->execute();


			echo '<div class="alert alert-success">Votre réservation a bien été prise en compte.</div>';
		}
	}

	
}


if(isset($_POST["newNbrPlaces"], $_POST["prevNbrPlaces"], $_POST["idReservation"], $_POST["idHoraire"]))
{
	$reqPlaces = $bdd->prepare('SELECT `Id_Horaire`,`Nbr_Places` FROM `horaire` WHERE `Id_Horaire` = ' . $_POST["idHoraire"]);
	$reqPlaces->execute();
	$donnees=$reqPlaces->fetch();

	$newPlaces = $donnees['Nbr_Places'] + $_POST["prevNbrPlaces"];
	$newPlaces = $newPlaces - $_POST["newNbrPlaces"];

	if($_POST["newNbrPlaces"] > $_POST["prevNbrPlaces"])
	{
		//On a plus de places qu'avant

		echo '<div class="alert alert-success">L\'ajout du nombre de places a été prise en compte.</div>';

	}
	else if($_POST["newNbrPlaces"] < $_POST["prevNbrPlaces"])
	{
		//On a moins de places qu'avant
		echo '<div class="alert alert-success">La diminution du nombre de places a été prise en compte.</div>';
	}
	else
	{
		//Pas de modif
		echo '<div class="alert alert-success">La modification a été prise en compte.</div>';
	}

	$reqUpdatePlacesHoraire = $bdd->prepare("UPDATE `horaire` SET `Nbr_Places` = ". $newPlaces ." WHERE `horaire`.`Id_Horaire` = ". $_POST["idHoraire"]);
	$reqUpdatePlacesHoraire->execute();

	$reqUpdatePlacesReserv = $bdd->prepare("UPDATE `reservation_film` SET `nbReserv` = ". $_POST["newNbrPlaces"] ." WHERE `Id_Reservation` = ". $_POST["idReservation"]);
	$reqUpdatePlacesReserv->execute();


}


if(isset($_POST["delReservation"], $_POST["delPrevNbrPlaces"], $_POST["delReservHoraire"]))
{	
	$requete = $bdd->prepare("DELETE FROM `reservation_film` WHERE `reservation_film`.`Id_Reservation` = " . $_POST["delReservation"]);
	$requete->execute();

	$reqPlaces = $bdd->prepare('SELECT `Id_Horaire`,`Nbr_Places` FROM `horaire` WHERE `Id_Horaire` = ' . $_POST["delReservHoraire"]);
	$reqPlaces->execute();
	$donnees=$reqPlaces->fetch();

	$nbrPlacesNewHoraire = $donnees["Nbr_Places"] + $_POST["delPrevNbrPlaces"];

	$reqUpdatePlaces = $bdd->prepare("UPDATE `horaire` SET `Nbr_Places` = ". $nbrPlacesNewHoraire ." WHERE `horaire`.`Id_Horaire` = ". $_POST["delReservHoraire"]);
	$reqUpdatePlaces->execute();


	echo '<div class="alert alert-success">La suppresion a été prise en compte.</div>';
}


	if(isset($_POST["ville"]))
	{
		$Ville = Ville::getVilleId($_POST["ville"]);
		$_SESSION["VilleChoisie"] = $Ville->getNomVille();
		$_SESSION["IdVilleChoisie"] = $_POST["ville"];
	}

?>




<body class="bd">
	<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-white">

		<?php
		/*
		$_SESSION["VilleChoisie"] = null;
		$_SESSION["IdVilleChoisie"] = null; 
		*/

    	//Cinema de base sera "Le havre"
		if(empty($_SESSION["VilleChoisie"]) && empty($_SESSION["IdVilleChoisie"]))
		{
			$_SESSION["VilleChoisie"] = "Le Havre";
			$_SESSION["IdVilleChoisie"] = 1;
		};
		?>


		<a class="navbar-brand" href="index.php">
			<div class="divlogo"></div>
			<img src="../Images/Affichage/logo.png" alt="logo" class="logo">
			
		</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon" style=" background-color: black;"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExample07">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="cinema.php">Cinémas</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="films.php">Films</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="acteurs.php">Acteurs</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="realisateurs.php">Realisateurs</a>
				</li>
			</ul>


			<?php
			if(empty($_SESSION['mailclient'])){ 
				echo '
				<ul class="nav navbar-nav flex-row justify-content-md-center justify-content-start flex-nowrap">
				<li class="nav-item">
				<a class="nav-link" href="inscription.php">Inscription</a> 
				</li>
				<li class="nav-item">
				<a class="nav-link" href="connexion.php">Connexion</a>
				</li>
				</ul>';
			}else{
				echo '
				<ul class="nav navbar-nav flex-row justify-content-md-center justify-content-start flex-nowrap">
				<li class="nav-item">
				<a class="nav-link" href="profil.php">Mon Profil</a> 
				</li>
				<li class="nav-item">
				<a class="nav-link" href="deconnexion.php">Déconnexion</a>
				</li>
				';
			}

			?>
			<?php
			echo '<li class="nav-item"><p class="nav-link">Ville choisie : ' .$_SESSION["VilleChoisie"] . ' </p></li>';
			echo '<li class=\"nav-item\" style=\"color:red\">';
			echo '<a class="nav-link" href="ville.php">Changer de ville</a></li>';
			?>

			</ul>

			<form action="recherche.php" method="post" class="form-inline my-2 my-md-0">
				<input name="recherche" class="form-control" type="search" placeholder="Recherche..." aria-label="Search">
				<button id="search" class="btn btn-dark" type="submit">Rechercher</button>
			</form>

		</div>

	</nav>

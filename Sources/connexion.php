<!-- https://openclassrooms.com/fr/courses/1401411-creer-son-forum-de-toutes-pieces/1401751-inscription-et-connexion -->
<!DOCTYPE html>
<html lang="en">
<?php session_start();
if(isset($_SESSION["inscription"])){
	echo '<div class="alert alert-success" role="alert">
	Inscription effectuée avec succès! Veuillez vous connecter.
	</div>';
	unset($_SESSION["inscription"]);
}
/*
if(isset($_POST["email"], $_POST["pass"]))
{
	include_once('db.php');
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
	}else{
		echo '<div class="alert alert-danger">Mot de passe ou adresse mail non reconnu.</div>';
	}


}*/
?>

<?php include_once('header.php'); ?>
<head>

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body style="background-color: #999999;">


	<div class="limiter">
		<div class="container-form">

			<div class="identifiants">
				<form method="post" action="connexion.php" class="identifiants-form validate-form">
					<span class="form-title" style="text-align: left!important">
						Connexion
					</span>

					<div class="id-wrap-input validate-input" data-validate = "Une adresse mail valide est requise ex: cinema@willies.com">
						<span class="id-input">Email</span>
						<input class="input" type="email" name="email" placeholder="Adresse mail..." value=" <?php if(isset($_SESSION["save_email"])){ echo($_SESSION["save_email"]);} ?> ">
						<span class="focus-input"></span>
					</div>

					<div class="id-wrap-input validate-input" data-validate = "Le mot de passe est requis">
						<span class="id-input">Mot de passe</span>
						<input class="input" type="password" name="pass" placeholder="**************" id="pass">
						<span class="focus-input"></span>
					</div>

					<div class="container-form-btn">
						<a href="inscription.php" class="other-btn">
							Inscription
						</a>

						<div class="wrap-form-btn">
							<div class="login-form-bgbtn"></div>
							<button class="login-form-btn">
								Connexion
							</button>
						</div>
					</div>
				</form>
			</div>

			<div class="log-img" style="background-image: url('images/bg-02.jpg');"></div>
		</div>
	</div>

	<script src="js/identifiants.js"></script>

</body>
</html>
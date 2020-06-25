<!DOCTYPE html>
<html lang="en">
<?php session_start();

	if(isset($_POST['submit'])){
		include_once "db.php";
		$email = htmlspecialchars($_POST['email']);
		$nom = htmlspecialchars($_POST['name']);
		$prenom = htmlspecialchars($_POST['firstname']);
		$password = htmlspecialchars($_POST['pass']);
		$passwordverification = htmlspecialchars($_POST['repeat-pass']);
		$ddn = htmlspecialchars($_POST['ddn']);

		$_SESSION["newInscriptionMail"] = $email;

	    //$mysqli = mysqli_connect('localhost','CineUser','iYAOZFLlOnvwnD6J','cinema');
		
		$verifExistant = "Select * FROM client WHERE (Mail='$email');";
		$resultat = mysqli_query($mysqli, $verifExistant);

		if(mysqli_num_rows($resultat) == 0){
			$pwdsecur = md5($password);
			$requete = $bdd->prepare("INSERT INTO client (Nom,Prenom,Mail,Mdp,Date_Naissance) VALUES ('$nom','$prenom','$email','$pwdsecur','$ddn')");
			$requete->execute(array(
				"Nom" => $nom, 
				"Prenom" => $prenom,
				"Mail" => $email,
				"Mdp" => $pwdsecur,
				"Date_Naissance" => $ddn
			));

		
		$_SESSION["inscription"] = 1;
		$_SESSION["save_email"] = htmlspecialchars($_POST['email']);

		header('Location: connexion.php');
  		exit();

		}
		else{
			if(isset($_SESSION["inscription"])){unset($_SESSION["inscription"]);}
			echo '<div class="alert alert-danger">L\'email est déjà utilisé</div>';
		}
	}
?>

<?php
	include('header.php');
?>

<body style="background-color: #999999;">

	
	<div class="limiter">
		<div class="container-form">
			<div class="log-img" style=""></div>

			<div class="identifiants">
				<form action="inscription.php" method="post" class="login-form validate-form">
					<span class="form-title">
						Inscription
					</span>

					<div class="id-wrap-input validate-input" data-validate="Nom requis">
						<span class="id-input">Nom</span>
						<input class="input" type="text" name="name" placeholder="Nom...">
						<span class="focus-input"></span>
					</div>
					
					<div class="id-wrap-input validate-input" data-validate="Prénom requis">
						<span class="id-input">Prénom</span>
						<input class="input" type="text" name="firstname" placeholder="Prénom...">
						<span class="focus-input"></span>
					</div>

					<div class="id-wrap-input validate-input" data-validate = "Une adresse mail valide est requise ex: cinema@willies.com">
						<span class="id-input">Email</span>
						<input class="input" type="email" name="email" placeholder="Adresse mail...">
						<span class="focus-input"></span>
					</div>

					<div class="id-wrap-input validate-input" data-validate="La date de naissance est requise">
						<span class="id-input">Date de naissance</span>
						<input class="input no-spin" type="date" name="ddn">
						<span class="focus-input"></span>
					</div>

					<div class="id-wrap-input validate-input" data-validate = "Le mot de passe est requis">
						<span class="id-input">Mot de passe</span>
						<input class="input" type="password" name="pass" placeholder="**************" id="pass">
						<span class="focus-input"></span>
					</div>

					<div class="id-wrap-input validate-input" data-validate = "Les mots de passe ne sont pas identiques">
						<span class="id-input">Répéter Mot de passe</span>
						<input class="input" type="password" name="repeat-pass" placeholder="**************" id="repeat-pass">
						<span class="focus-input"></span>
					</div>


					<div class="container-form-btn">
						<div class="wrap-form-btn">
							<div class="login-form-bgbtn"></div>
							<button type="submit" name="submit" class="login-form-btn">
								Inscription
							</button>
						</div>

						<a href="connexion.php" class="other-btn">
							Connexion
							<i class="fa fa-long-arrow-right m-l-5"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="js/identifiants.js"></script>



</body>
</html>
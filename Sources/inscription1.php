  <?php if(empty($_POST['email'])){
    header('Refresh: 0; URL=inscription.php');
  } else{

  include('db.php');
      $email = htmlspecialchars($_POST['email']);
      $nom = htmlspecialchars($_POST['name']);
      $prenom = htmlspecialchars($_POST['firstname']);
      $password = htmlspecialchars($_POST['pass']);
      $passwordverification = htmlspecialchars($_POST['repeat-pass']);
      $ddn = htmlspecialchars($_POST['ddn']);

      $_SESSION["newInscriptionMail"] = $email;

      $mysqli = mysqli_connect('localhost','root','','cinema');

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

        var_dump($requete);
        
        ?>
        <div class="alert alert-success"><?php echo "Votre inscription a été prise en compte ! Redirection automatique"; header('Refresh: 0; URL=connexion.php');  ?></div>
        <a href="index.php"><div class="btn btn-default btn-lg">Retourner à la page d'accueil</div></a>
        <?php
      }
      else
      {
        ?>

        <div class="alert alert-danger"><?php echo "L'email est déjà utilisé"; header('Refresh: 2; URL=inscription.php'); ?></div>
        <a href="inscription.php"><div class="btn btn-default btn-lg">Retourner à la page d'inscription</div></a>
        <?php
      }

      ?>

    </body>

    </html>
<?php include('header.php'); 

$vide = false;
if(empty($_SESSION["idclient"])){
    $vide = true;
    echo '<meta http-equiv="Refresh" content="0; url=connexion.php">';
    exit();
}else{
    $listeReservations = Reservation::getReservationClient($_SESSION["idclient"]);
}


//echo $_POST["idFilm"];

?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;"><?php if($vide == false){echo "Profil";}?></p>
  <p>Bienvenue <b><?php echo $_SESSION["prenomclient"] . " " ;echo $_SESSION["nomclient"];?></b></p>
  <p>Adresse mail : <b><?php echo $_SESSION["mailclient"]; ?></b></p>

  <p class="titre" style="font-variant: small-caps;">Vos réservations</p>
  <?php 
  if($vide == false){

    if(empty($listeReservations))
    {
        echo "<p>Vous n'avez pas de réservations</p>";
    }
    else
    {
        ;?>
        <div class="horaires_cinemas">
            <table>
                <tbody>
                    <tr>
                        <th style="width: 220px;">Film</th>
                        <th>Cinema</th>
                        <th>Salle</th>
                        <th>Horaire</th>
                        <th>Places réservées</th>
                        <th>Modification</th>
                    </tr>

                    <?php 

                    foreach($listeReservations as $reservation)
                    { 
                        $lefilm = Film::getFilmId($reservation->getIdFilm());
                        $lecinema = Cinema::getCinema($reservation->getIdCinema());

                        $horaire = $reservation->getHoraire();
                        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //Nous permet d'afficher les dates au format français (Lundi au lieu de Monday)
                        $nomJour =  utf8_encode(strftime("%a %d %b", strtotime($horaire))); //%a %d et %b permettent d'obtenir le jour abrégé en 3 lettres, le jour en deux chiffres et le mois en 3 lettres (Ex  :  ven. 23 nov.)
                        $heure = date("H:i:s", strtotime($horaire));

                        $nbReserv = $reservation->getNbrReserv();
                        if($nbReserv <= 1)
                        {
                            $phrase = $nbReserv . " place réservée.";
                        }
                        else{
                            $phrase = $nbReserv . " places réservées.";
                        }

                        echo "
                        <tr>
                            <td>
                                <img class='img-fluid' style ='height:170px' src='". $lefilm->getPhotoFilm() ."' alt=''/>
                                <p> ". $lefilm->getTitre() . " </p>
                            </td>
                            <td>
                                ". $lecinema->getNomCinema() ."
                            </td>
                            <td>
                                Salle n°". $reservation->getIdSalle() ."
                            </td>
                            <td>
                                ". $nomJour ." à " . $heure . "
                            </td>
                            <td>
                                ". $phrase ."
                            </td>
                            <td>
                                <a href='modification.php?idr=". $reservation->getIdReservation() . "' class='btn btn-danger' role='button'>Edit</a>
                            </td>
                        </tr>";

                    }

                    ?>  
                </tbody>
            </table>
        </div>


<?php
    }
}
?>






<div class = "clear"></div>

</div>
<!-- /.container -->


</body>
</html>

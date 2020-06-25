<?php include('header.php'); 

$vide = false;
if(empty($_SESSION["idclient"])){
    $vide = true;
    echo '<meta http-equiv="Refresh" content="0; url=connexion.php">';
    exit();
}else{

    $laReservation = Reservation::getReservationId($_GET["idr"]);
    if($laReservation->getIdClient() != $_SESSION["idclient"])
    {
        echo '<meta http-equiv="Refresh" content="0; url=profil.php">';
        exit();
    }
}


//echo $_POST["idFilm"];

?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;">Modification réservation</p>
  <?php 
  if($vide == false){
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
                    </tr>

                    <?php 

 
                        $lefilm = Film::getFilmId($laReservation->getIdFilm());
                        $lecinema = Cinema::getCinema($laReservation->getIdCinema());

                        $horaire = $laReservation->getHoraire();
                        $lHoraire = Horaire::getHoraireById($laReservation->getIdHoraire());
                        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //Nous permet d'afficher les dates au format français (Lundi au lieu de Monday)
                        $nomJour =  utf8_encode(strftime("%a %d %b", strtotime($horaire))); //%a %d et %b permettent d'obtenir le jour abrégé en 3 lettres, le jour en deux chiffres et le mois en 3 lettres (Ex  :  ven. 23 nov.)
                        $heure = date("H:i:s", strtotime($horaire));

                        $nbReserv = $laReservation->getNbrReserv();
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
                                Salle n°". $laReservation->getIdSalle() ."
                            </td>
                            <td>
                                ". $nomJour ." à " . $heure . "
                            </td>
                            <td>
                                ". $phrase ."
                            </td>
                        </tr>";

                    

                    ?>  
                    
                </tbody>
            </table>

        </div>

  <p class="titre" style="font-variant: small-caps;">Ajouter/Suppprimer des places</p>
  <?php 
    $nbrPlacesMax = $lHoraire->getIdCinema() . $laReservation->getIdSalle() . "0";
  ?>
   <?php echo "Nombre de places restantes : <b>" . $lHoraire->getNbrPlaces() ."</b>"; ?>
   <?php echo "- Nombre de places max : <b>" . $nbrPlacesMax ."</b>"; ?>
   <p>Vous avez réservé : <b><?php echo $laReservation->getNbrReserv() ?></b> place(s).</p>
    <form action="profil.php" method="post">
     <p>Nouveau nombre de places réservées : <input type="number" name="newNbrPlaces" value=<?php echo $laReservation->getNbrReserv(); ?> min="1" max=<?php echo $nbrPlacesMax; ?> ></p>
     <input name="prevNbrPlaces" type="hidden" value=<?php echo $laReservation->getNbrReserv() ?>>
     <input name="idReservation" type="hidden" value=<?php echo $laReservation->getIdReservation() ?>>
     <input name="idHoraire" type="hidden" value=<?php echo $lHoraire->getIdHoraire() ?>>
     <p><input class='btn btn-danger' type="submit" value="Modifier"></p>
    </form>


  <p class="titre" style="font-variant: small-caps;">Annuler la réservation</p>
  <form action="profil.php" method="post">
    <input name="delReservation" type="hidden" value=<?php echo $laReservation->getIdReservation() ?>>
    <input name="delReservHoraire" type="hidden" value=<?php echo $lHoraire->getIdHoraire() ?>>
    <input name="delPrevNbrPlaces" type="hidden" value=<?php echo $laReservation->getNbrReserv(); ?> >
    <p><input class='btn btn-danger' type="submit" value="Annuler la réservation"></p>
  </form>


<?php
    
}
?>






<div class = "clear"></div>
</div>
<!-- /.container -->


</body>
</html>

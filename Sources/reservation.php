<?php include('header.php'); 


if(empty($_SESSION["prenomclient"])){
    echo '<meta http-equiv="Refresh" content="0; url=connexion.php">';
    exit();
}
else if(empty($_GET["idh"])){
    echo '<meta http-equiv="Refresh" content="0; url=films.php">';
    exit();
}else{
    $horaire = Horaire::getHoraireById($_GET["idh"]);
    $film = Film::getFilmId($horaire->getIdFilm());
    setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //Nous permet d'afficher les dates au format français (Lundi au lieu de Monday)
    $nomJour =  utf8_encode(strftime("%A %d %B", strtotime($horaire->getHoraire()))); //%a %d et %b permettent d'obtenir le jour abrégé en 3 lettres, le jour en deux chiffres et le mois en 3 lettres (Ex  :  ven. 23 nov.)
    $heure = date("H:i", strtotime($horaire->getHoraire()));
    $cinema = Cinema::getCinema($horaire->getIdCinema());
}

//echo $_POST["idFilm"];

?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;">Réservez vos places.</p>
  <p><b><?php echo $film->getTitre();?> - <?php echo $cinema->getNomCinema();?></b></p>



  <div class="presentation-film">
      <div class="affiche-film"><?php echo '<img src="'. $film->getPhotoFilm() .'">'?></div>
      <div class="description-film">
        <p><?php echo $film->getDescription();?></p>
        <form action="profil.php" method="post" >


             <p><?php echo "Séance du <b>" . $nomJour . " </b> à <b> " . $heure . " </b>" ?> </p>
             <input type="hidden" name="idHoraire" value=<?php echo '"' . $_GET["idh"] . '"' ;?>>
             <input type="hidden" name="nbrPlacesRestantes" value=<?php echo '"' . $horaire->getNbrPlaces() . '"';?>>
             <label for="nbrPlaces">Nombre de places à réserver : </label>  
             <input type="number" name="nbrPlaces" min="1" max=<?php echo '"' . $horaire->getNbrPlaces() . '"';?> value="1" style="width: 30px;text-align: right;">
             <p>Places restantes : <b><?php echo $horaire->getNbrPlaces(); ?></b></p>


            <p>
                <?php 
                    if($horaire->getNbrPlaces() == 0)
                    {
                        echo '<p class ="btn-Clr" style="cursor: not-allowed;user-select:none;opacity: 0.5;width:200px">Plus de places.</p>';
                    }
                    else{
                        echo '<input style="cursor: pointer;" type="submit" class="btn-Clr" value="Réserver" />';
                    }
                ?>
             
            </p>
     </form>

 </div>
</div>









<div class = "clear"></div>
<p class="titre" style="font-variant: small-caps;">Autres horaires.</p>




<div class="horaires_cinemas">
    <?php
    $PasDeSeances = true;
    $cinema = $horaire->getIdCinema();      
    if(!empty($_SESSION["IdVilleChoisie"]))
    {                    
        $unIdCinema = $horaire->getIdCinema();
        $unIdFilm = $horaire->getIdFilm();

        $planning = Horaire::planningSemaine($unIdCinema, $unIdFilm);
                    //affichage horaires par jour en fonction de (idCinema et idFilm)


                    //$planning = array(); 

        if(!empty($planning))
        {         
            $PasDeSeances = false;
            echo "<table>";
                        //On regarde la colonne avec le plus de valeur pour pouvoir régler le nombre de passage de la boucle
            $biggestColumn = 0;
            foreach($planning as $value)
            {
                if(count($value) > $biggestColumn)
                {
                    $biggestColumn = count($value);
                }
            }

            /* ************************************************** */
            /* ON AFFICHE LES 7 JOURS SUIVANT LA DATE D'AJOURDHUI */ 
            /* ************************************************** */

                        $dateAujourdui = date("Y-m-d"); //On comme à partir de la date du jour
                        

                        
                        echo "<tr> ";
                        for($i = 0; $i < 7; $i++)
                        {

                            //On effectue une requete pour récupérer les horaires de chaque jour, en commencant par 
                            //Lundi puis ensuite date + 1 -> mardi...
                            $date = date("Y-m-d", strtotime($dateAujourdui.' + '. $i .' days')); 
                            
                            setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //Nous permet d'afficher les dates au format français (Lundi au lieu de Monday)
            $nomJour =  utf8_encode(strftime("%a %d %b", strtotime($date))); //%a %d et %b permettent d'obtenir le jour abrégé en 3 lettres, le jour en deux chiffres et le mois en 3 lettres (Ex  :  ven. 23 nov.)

            echo "<th>". $nomJour . "</th>";
        }
        echo "<tr>";


        /* *********************************************** */
        /* ON MET LES VALEURS DES HORAIRES DANS LE TABLEAU */ 
        /* *********************************************** */

                        //On parcourt ensuite le tableaux pour créer les lignes suivante et ajouter les horaires
        for($ligne = 0; $ligne < $biggestColumn; $ligne++)
        {
            echo "<tr> ";
            for($col = 0; $col < count($planning); $col++)
            {
                                //Certains jours ont un plus grand nombre de séances que d'autres
                                //On fait donc une vérification si la case est vide et si oui, on y mettra un espace.
                if(!empty($planning[$col][$ligne]))
                {
                    echo '<td><a href="reservation.php?idh='. $planning[$col][$ligne]->getIdHoraire() .'" class="btn btn-danger" role="button">' . $planning[$col][$ligne]->getHoraire() . '</a></td>';     
                }
                else
                    echo "<td></td>";
            }

            echo "</tr>";
        }
        echo "</table>"; 
    }
}


if($PasDeSeances == true){
    echo "Il n'y a pas de séances dans la ville sélectionnée : " . $_SESSION["VilleChoisie"];
}

?>







</div>


<?php

?>






<div class = "clear"></div>

</div>
<!-- /.container -->


</body>
</html>

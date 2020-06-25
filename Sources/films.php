<?php include('header.php'); 

$vide = false;
if(empty($_GET["idf"])){
    $vide = true;
}else{
    $film = Film::getFilmId($_GET["idf"]);
    $cinemaFilm = Horaire::CinemasPourFilm($_GET["idf"]);
    $acteursFilm = Acteur_Film::getListeActeur($_GET["idf"]);
    $categorieFilm = Categorie_Film::getCategorieFilm($_GET["idf"]);
    if(empty($film->getTitre())){
        echo '<div class="container">
        <p class="titre" style="font-variant: small-caps;">Film non trouvé.</p>
        </div>';
        exit();
    }
}


//echo $_POST["idFilm"];

?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;"><?php if($vide == false){echo $film->getTitre();} else{echo "Liste des films";}?></p>
<div class="presentation-film">
    <?php 
    if($vide == true){
        echo '<div class="row">';
        $donnees = Film::getListeFilm();
        foreach ($donnees AS $resultat)
        {
          echo '<div class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" onclick="window.location=\'films.php?idf=' . $resultat->getIdFilm() . '\'">';
          echo '<img class="img-fluid" src="../Images/Film/' . $resultat->getIdFilm() . '.jpg" alt="">' ;
          echo '<p class="movie_title">' . $resultat->getTitre() .'</p>';
          echo "</div>";
      };
      echo '</div>';
      echo '</div>';
      exit();
  } ?>
  <!--<h3 class="film-titre"> <?php echo $film->getTitre();?> </h3>-->
  <div class="affiche-film"> <?php echo "<img src='" . $film->getPhotoFilm() . "'>";?> </div>
  <div class="description-film">
    <p>
        <?php echo $film->getDescription();?>
    </p>
</div>
</div>

<div class = "clear"></div>

<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXX AFFICHAGE DES GENRES/CATEGORIES XXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->

<p class="titre" style="font-variant: small-caps;">Catégories et genres
</p>
<div class="acteur_film">

    <?php   

    foreach($categorieFilm as $categorie)
    { 
        echo "<div class='categorie'>";
        echo "<a target='_blank' href='#" . $categorie->getIdCategorie() ."'>";
        echo "<p>" . $categorie->getLibelleCategorie() . "</p>";
        echo "</a>";
        echo "</div>";   
    }
    
    ?>
    
    <div class = "clear"></div>
    

<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXX AFFICHAGE DES ACTEURS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<p class="titre" style="font-variant: small-caps;">Acteurs  principaux
</p>
<div class="acteur_film">

    <?php

    foreach($acteursFilm as $acteur)
    { 
        echo '
      <div class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" style="display: inline-block;" onclick="window.location=\'acteurs.php?ida=' . $acteur->getIdActeur() . '\'">
      <div class="img-acteur"><img class="div-fit" src=' . $acteur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() .'</p>
      </div>';
    }

        ?>




    </div>
<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXX AFFICHAGE DES HORAIRES XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<div class = "clear"></div>

<p class="titre" style="font-variant: small-caps;">Les séances
</p>
<p>Ville choisie : <?php echo $_SESSION["VilleChoisie"]; ?> </p>


<div class="horaires_cinemas">
    <?php
    $PasDeSeances = true;
    foreach($cinemaFilm as $value)
    {
        $cinema = Cinema::getCinema($value);            
        if(!empty($_SESSION["IdVilleChoisie"]) && (!empty($_GET["idf"])))
        {                    
            $unIdCinema = $value;
            $unIdFilm = $_GET["idf"];

            $planning = Horaire::planningSemaine($unIdCinema, $unIdFilm);
					//affichage horaires par jour en fonction de (idCinema et idFilm)


                    //$planning = array(); 

            if(!empty($planning))
            {         
                $PasDeSeances = false;
                echo "<br><h3 class='nom_cinema'>" . $cinema->getNomCinema() . "</h3>";
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

}

if($PasDeSeances == true){
    echo "Il n'y a pas de séances dans la ville sélectionnée : " . $_SESSION["VilleChoisie"];
    echo '<br/><a href="ville.php" class="btn btn-danger" role="button">Changer de ville.</a>';
}

?>
</div>

</div>
<!-- /.container -->


</body>
</html>

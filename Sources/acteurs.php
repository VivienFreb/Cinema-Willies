<?php include('header.php'); 

$vide = false;
if(empty($_GET["ida"])){
    $vide = true;
}else{
    $filmsActeurs = Acteur_Film::getListeFilm($_GET["ida"]);
    $acteur = Acteur::getActeurId($_GET["ida"]);
    if(empty($acteur->getNomActeur())){
        echo '<div class="container">
        <p class="titre" style="font-variant: small-caps;">Acteur non trouvé.</p>
        </div>';
        exit();
    }
}


?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;"><?php if($vide == false){echo $acteur->getFullNameActeur();} else{echo "Liste des acteurs";}?></p>
</p>
<?php 
if($vide == true){
    $donnees = Acteur::getListeActeur();
    foreach ($donnees AS $acteur)
    {
              /*echo '
              <form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" action="acteurs.php" style="display: inline-block;">
              <button type="submit" class="submit-film">
              <input type="hidden" name="idActeur" value="' . $acteur->getIdActeur()  . '"/>   
              <div class="img-acteur"><img class="div-fit" src=' . $acteur->getPhotoActeur() . ' alt=""/></div>    
              <p class="btn-Clr">' .  $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() .'</p>
              </button>
              </form>';

                    echo '
      <form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" action="acteurs.php" style="display: inline-block;">
      <button type="submit" class="submit-film">
      <input type="hidden" name="idActeur" value="' . $acteur->getIdActeur()  . '"/>   
      <div class="img-acteur"><img class="div-fit" src=' . $acteur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() .'</p>
      </button>
      </form>';
            */ 
        /*echo '<div class="acteur" onclick="window.location=\'acteurs.php?ida=' . $acteur->getIdActeur() . '\'">';
        echo "<div class='img-acteur'><img class='div-fit' src='" . $acteur->getPhotoActeur() . "'/></div>" ;
        echo "<p class='btn-Clr'>" . $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() . "</p>";
        echo "</div>";    
        };
      echo '<div class = "clear"></div>';
      echo '</div>';*/

      echo '
      <div class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" style="display: inline-block;" onclick="window.location=\'acteurs.php?ida=' . $acteur->getIdActeur() . '\'">
      <div class="img-acteur"><img class="div-fit" src=' . $acteur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() .'</p>
      </div>';
    }
    echo '<div class = "clear"></div>';
    echo '</div>';
    exit();
} ?>

<div class="presentation-film">
    <div class="affiche-film"> <?php echo "<img src='" . $acteur->getPhotoActeur() . "'>";?> </div>
    <div class="description-film">
        <p>Date de naissance : <?php echo $acteur->getDDNActeur();?>.</p>
        <p>Age : <?php echo $acteur->getAgeActeur();?> ans.</p>
        <p>Nationalité : <?php echo $acteur->getNationaliteClair();?>.</p>
        <p><?php echo $acteur->getBio();?></p>
    </div>
</div>

<div class = "clear"></div>




<!-- XXXXXXXXXXXXXXXXXXXWXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXX AFFICHAGE DES ACTEURS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<p class="titre" style="font-variant: small-caps;">Filmographie</p>
<div class="presentation-film">

    <?php

    echo '<div class="row">';
    foreach($filmsActeurs as $film)
    {    
        $annee = explode('-', $film->getDateSortie());
        /*echo '<form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" action="films.php" style="display: inline-block;">
        <button type="submit" class="submit-film">
        <input type="hidden" name="idFilm" value="' . $film->getIdFilm() . '"/>    
        <img class="img-fluid" src="../Images/Film/'. $film->getIdFilm() . '.jpg" alt=""/>      
        <p class="movie_title">' . $film->getTitre() . ' (' . $annee[0] . ')</p>
        </button>
        </form>' ;*/
        echo '<div class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" onclick="window.location=\'films.php?idf=' . $film->getIdFilm() . '\'">';
          echo '<img class="img-fluid" src="../Images/Film/' . $film->getIdFilm() . '.jpg" alt="">' ;
          echo '<p class="movie_title">' . $film->getTitre() .'</p>';
          echo "</div>";
    }
      echo '</div>';
    echo '</div>';
    ?>









<div class = "clear"></div>


</div>
<!-- /.container -->


</body>
</html>
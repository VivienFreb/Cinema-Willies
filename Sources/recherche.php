<?php include('header.php'); ?>

<script>

  function showhide(id){
    if(id === "all")
    {
      var divs = document.getElementsByClassName("category");
      for(var i=0;i<divs.length;i++)
      {
       divs[i].style.display = "block";
     }
   }
   else if (document.getElementById) {
    var divid = document.getElementById(id);
    var divs = document.getElementsByClassName("category");
    for(var i=0;i<divs.length;i++) {
     divs[i].style.display = "none";
   }
   divid.style.display = "block";

 } 
 return false;
} 
</script>




<!-- Page Content -->
<div class="container">
  <ul class="navbar">
    <li class="active"><a class="choose" onclick="showhide('all');">Tous les résultats</a></li>
    <li><a class="choose" onclick="showhide('cinemas');">Cinemas</a></li>
    <li><a class="choose" onclick="showhide('films');">Films</a></li>
    <li><a class="choose" onclick="showhide('acteurs');">Acteurs</a></li>
    <li><a class="choose" onclick="showhide('realisateurs');">Realisateurs</a></li>
  </ul>
  <!-- Portfolio Item Heading -->
  <p class="titre">Résultats de la recherche
  </p>
  <p>Vous avez recherché : <b><?php echo $_POST["recherche"]; ?></b>.</p>
  <?php 

  // ************** FILMS ****************
  echo '<div  class="category" id="cinemas">';
  $listeCinemas = Cinema::getListeCinema($_POST["recherche"]); 
  //echo sizeof($listeActeurSearch);
  if(sizeof($listeCinemas) > 0){
    echo '<p class="titre">Cinémas</p>';
    if(sizeof($listeCinemas) == 1)
    {
      echo '<p> ' . sizeof($listeCinemas) . ' cinéma a été trouvé.';
    }
    else
    {
      echo '<p> ' . sizeof($listeCinemas) . ' cinémas ont été trouvés.';
    }
    foreach($listeCinemas as $cinema)
    { 
      echo '
      <form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" action="acteurs.php" style="display: inline-block;">
      <button type="submit" class="submit-film">
      <input type="hidden" name="idActeur" value="' . "". '"/>        
      <p class="btn-Clr">' .  $cinema->getNomCinema() . " (" . $cinema->getVille()->getCpVille() .')</p>
      </button>
      </form>';
    }
  }

  echo '</div><div class = "clear"></div>';



  // ************** FILMS ****************
  echo '<div class="category" id="films">';
  $listeFilm = Film::getFilmSearch($_POST["recherche"]);
  //echo sizeof($listeActeurSearch);
  if(sizeof($listeFilm) > 0){
    echo '<p class="titre">Films</p>';
    if(sizeof($listeFilm) == 1)
    {
      echo '<p> ' . sizeof($listeFilm) . ' film a été trouvé.';
    }
    else
    {
      echo '<p> ' . sizeof($listeFilm) . ' films ont été trouvés.';
    }
    echo '<div class="presentation-film">';
    echo '<div class="row">';
    foreach($listeFilm as $film)
    { 
      $annee = explode('-', $film->getDateSortie());
      echo '<div class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" onclick="window.location=\'films.php?idf=' . $film->getIdFilm() . '\'">';
          echo '<img class="img-fluid" src="../Images/Film/' . $film->getIdFilm() . '.jpg" alt="">' ;
          echo '<p class="movie_title">' . $film->getTitre() . '</p>';
          echo "</div>";
    }
    echo '</div>';
    echo '</div>';
  }

  echo '</div><div class = "clear"></div>';



  // ************** ACTEURS ****************
  $listeActeurSearch = Acteur::getActeurSearch($_POST["recherche"]); 
  //echo '<div class="category" id="acteurs">';
  echo '<div class="category" id="acteurs">';
  //echo sizeof($listeActeurSearch);
  if(sizeof($listeActeurSearch) > 0){
    echo '<p class="titre">Acteurs</p>';
    if(sizeof($listeActeurSearch) == 1)
    {
      echo '<p> ' . sizeof($listeActeurSearch) . ' acteur a été trouvé.';
    }
    else
    {
      echo '<p> ' . sizeof($listeActeurSearch) . ' acteurs ont été trouvés.'; 
    }
    foreach($listeActeurSearch as $acteur)
    { 
      echo '
      <div class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" style="display: inline-block;" onclick="window.location=\'acteurs.php?ida=' . $acteur->getIdActeur() . '\'">
      <div class="img-acteur"><img class="div-fit" src=' . $acteur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $acteur->getPrenomActeur() . " " . $acteur->GetNomActeur() .'</p>
      </div>';
    }
  }


  echo '</div><div class = "clear"></div>';

  // ************** REALISATEURS ****************
  $listeRealisateur = Realisateur::getRealisateurSearch($_POST["recherche"]); 
  //echo '<div class="category" id="acteurs">';
  echo '<div class="category" id="realisateurs">';
  //echo sizeof($listeRealisateur);
  if(sizeof($listeRealisateur) > 0){
    echo '<p class="titre">Réalisateurs</p>';
    if(sizeof($listeRealisateur) == 1)
    {
      echo '<p> ' . sizeof($listeRealisateur) . ' réalisateur a été trouvé.';
    }
    else
    {
      echo '<p> ' . sizeof($listeRealisateur) . ' réalisateurs ont été trouvés.'; 
    }
    foreach($listeRealisateur as $realisateur)
    { 
      echo '
      <div class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" style="display: inline-block;" onclick="window.location=\'realisateur.php?idr=' . $realisateur->getIdActeur() . '\'">
      <div class="img-acteur"><img class="div-fit" src=' . $realisateur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $realisateur->getPrenomActeur() . " " . $realisateur->GetNomActeur() .'</p>
      </div>';
    }
  }


  echo '</div>';
  ?>

  <div class = "clear"></div>

</div>
<!-- /.container -->

</div>


</body>
</html>

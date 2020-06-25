<?php include('header.php'); 

$vide = false;
if(empty($_GET["idr"])){
    $vide = true;
}else{
    $filmsActeurs = Realisateur_Film::getListeFilm($_GET["idr"]);
    $realisateur = Realisateur::getRealisateurId($_GET["idr"]);
    if(empty($realisateur->getNomActeur())){
        echo '<div class="container">
        <p class="titre" style="font-variant: small-caps;">Réalisateur non trouvé.</p>
        </div>';
        exit();
    }
}


?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;"><?php if($vide == false){echo $realisateur->getFullNameActeur();} else{echo "Liste des réalisateurs";}?></p>
</p>
<?php 
if($vide == true){
    $donnees = Realisateur::getListeRealisateur();
    foreach ($donnees AS $realisateur)
    {
      echo '
      <div class="hov-img-zoom col-md-3 col-sm-6 mb-4 acteur" style="display: inline-block;" onclick="window.location=\'realisateurs.php?idr=' . $realisateur->getIdActeur() . '\'">
      <div class="img-acteur"><img class="div-fit" src=' . $realisateur->getPhotoActeur() . ' alt=""/></div>    
      <p class="btn-Clr">' .  $realisateur->getPrenomActeur() . " " . $realisateur->GetNomActeur() .'</p>
      </div>';
    }
    echo '<div class = "clear"></div>';
    echo '</div>';
    exit();
} ?>

<div class="presentation-film">
    <div class="affiche-film"> <?php echo "<img src='" . $realisateur->getPhotoActeur() . "'>";?> </div>
    <div class="description-film">
        <p>Date de naissance : <?php echo $realisateur->getDDNActeur();?>.</p>
        <p>Age : <?php echo $realisateur->getAgeActeur();?> ans.</p>
        <p>Nationalité : <?php echo $realisateur->getNationaliteClair();?>.</p>
        <p><?php echo $realisateur->getBio();?></p>
    </div>
</div>

<div class = "clear"></div>




<!-- XXXXXXXXXXXXXXXXXXXWXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXX AFFICHAGE DES ACTEURS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
<p class="titre" style="font-variant: small-caps;">Réalisations</p>
<div class="presentation-film">

    <?php

    echo '<div class="row">';
    foreach($filmsActeurs as $film)
    {    
        $annee = explode('-', $film->getDateSortie());

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
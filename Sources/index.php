<?php include('header.php'); ?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" >Avant première !</p>


  <!-- Portfolio Item Row -->
  <div class="row">

    <div class="col-md-5">
      <img class="img-fluid" src="../Images/Film/4.jpg" alt="">
    </div>

    <div class="col-md-7">
      <h3 class="my-3">Bohemian Rhapsody</h3>
      <p>Bohemian Rhapsody retrace le destin extraordinaire du groupe Queen et de leur chanteur emblématique Freddie Mercury, qui a défié les stéréotypes, brisé les conventions et révolutionné la musique. Du succès fulgurant de Freddie Mercury à ses excès, risquant la quasi-implosion du groupe, jusqu’à son retour triomphal sur scène lors du concert Live Aid, alors qu’il était frappé par la maladie, découvrez la vie exceptionnelle d’un homme qui continue d’inspirer les outsiders, les rêveurs et tous ceux qui aiment la musique.</p>
      <h3 class="my-3">Horaires</h3>
        <a href="films.php?idf=4"><li class="btn-Clr">Voir les horaires</li></a>
    </div>

  </div>
  <!-- /.row -->

  <!-- Related Projects Row -->
  <div class="my-4">
    <p class="titre">Les dernières sorties</p>
  </div>



  <div class="row">

    <?php
    $donnees = Film::getListeFilm();
    foreach ($donnees AS $resultat)
    {
      echo '<div class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" onclick="window.location=\'films.php?idf=' . $resultat->getIdFilm() . '\'">';
      echo '<img class="img-fluid" src="../Images/Film/' . $resultat->getIdFilm() . '.jpg" alt="">' ;
      echo '<p class="movie_title">' . $resultat->getTitre() .'</p>';
      echo "</div>";
    }
    ?>

    <?php /*
    $donnees = Film::getListeFilm();
    foreach ($donnees AS $resultat)
    { 
      ?>
      <form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" action="films.php" style="display: inline-block;">
        <input type="hidden" name="idFilm" value="<?php echo $resultat->getIdFilm()?>"/>    
        <img class="img-fluid" src="../Images/Film/<?php echo $resultat->getIdFilm() . ".jpg"?>" alt=""/>      
        <input type="submit" class="movie_title" value="<?php echo $resultat->getTitre()?>">
      </form>
    <?php }*/
    ?>

    <?php /*
    $donnees = Film::getListeFilm();
    foreach ($donnees AS $resultat)
    { 
      ?>
      <form method="POST" class="hov-img-zoom col-md-3 col-sm-6 mb-4 film" action="films.php" style="display: inline-block;">
        <button type="submit" class="submit-film">
          <input type="hidden" name="idFilm" value="<?php echo $resultat->getIdFilm()?>"/>    
          <img class="img-fluid" src="../Images/Film/<?php echo $resultat->getIdFilm() . ".jpg"?>" alt=""/>      
          <p class="movie_title"><?php echo $resultat->getTitre()?></p>
        </button>
      </form>
    <?php }*/
    ?>    

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->




</body>
</html>

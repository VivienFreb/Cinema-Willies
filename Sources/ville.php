<?php include('header.php'); ?>
<!-- Page Content -->
<div class="container">

  <!-- Portfolio Item Heading -->
  <p class="titre" style="font-variant: small-caps;">Changer de ville</p>

  <p> Veuillez sélectionner la ville désirée: </p>
  <?php $listeVille = Ville::getListeVille();
    if(empty($_SERVER['HTTP_REFERER']))
    {
      $page = "index.php";
    }
    else
    {
      $page = $_SERVER['HTTP_REFERER'];
    }
  	echo '<form action="'. $page .'" method="post">';
  	echo "<select name='ville'>";
  	foreach($listeVille AS $ville){
  		echo "<option value=". $ville->getIdVille() . ">" . $ville->getNomVille() . " (" . $ville->getCpVille() . ")</option>";
  	}
  	echo "</form>";
   ?>




  
  <!-- On affiche tout les cinémas dans la ville selectionnée si jamais on a pas d'idc (id cinéma) sinon on affiche le cinéma avec -->



</div>

<div class="clear"></div>

<input style="cursor: pointer;" type="submit" class="btn-Clr" value="Changer de ville" />
<!-- /.container -->
<div class="clear"></div>

<br/>


</body>
</html>
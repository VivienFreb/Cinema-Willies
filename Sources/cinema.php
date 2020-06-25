<?php include('header.php'); 

$vide = false;
if(empty($_GET["idc"])){
	$vide = true;
}else{
	$cinema = Cinema::getCinema($_GET["idc"]);
	if(empty($cinema->getNomCinema())){
		echo '<div class="container">
		<p class="titre" style="font-variant: small-caps;">Cinéma non trouvé.</p>
		</div>';
		exit();
	}
}


?>
<!-- Page Content -->
<!-- On affiche tout les cinémas dans la ville selectionnée si jamais on a pas d'idc (id cinéma) sinon on affiche le cinéma avec tous les films dans celui-ci -->
<div class="container">
	<!-- Portfolio Item Heading -->
	<?php if(empty($_GET["idc"])){
		echo '<p class="titre" style="font-variant: small-caps;">Cinémas de : ' .$_SESSION["VilleChoisie"].'</p>';		
		$CinemasDeLaVille = Cinema::getListeCinemaVille($_SESSION["IdVilleChoisie"]);
		echo '<a href="ville.php"><li style="width:250px" class="btn-Clr">Changer de ville</li></a>';
	}
	else{
		$CinemasDeLaVille = array();
		array_push($CinemasDeLaVille, $cinema);
		echo '<p class="titre" style="font-variant: small-caps;">' . $cinema->getNomCinema().'</p>';
		echo '<a href="cinema.php"><li style="width:250px" class="btn-Clr">Retour</li></a>';

	}

	?>
	
	<div class="horaires_cinemas">
		<?php

		foreach($CinemasDeLaVille AS $cinema)
		{
			$vide = true;
			$listeFilmDuCinema = Horaire::getListeFilmsCinema($cinema->getIdCinema());

			echo "<br><h3 class='nom_cinema' ><a href='cinema.php?idc=". $cinema->getIdCinema() ."' style='font-size: 28px;'>" . $cinema->getNomCinema() . "</a></h3>";
			foreach($listeFilmDuCinema AS $film)
			{
				$planning = Horaire::planningSemaine($cinema->getIdCinema(), $film);
				$leFilm = Film::getFilmId($film);
				if(!empty($planning))
				{         
					$vide = false;
					$PasDeSeances = false;
					echo '<p style="font-variant: small-caps; margin-top: 10px; ">'. $leFilm->getTitre() .'</p>';
					echo '	  <div class="presentation-film">
					<div class="affiche-film"><img src="'. $leFilm->getPhotoFilm() .'"></div>
					<div class="description-film">';
					echo "<p>Les séances pour ce film</p>";
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
		echo "</div></div>";
		echo "<div class='clear'></div>";
	}
}
if($vide==true)
{
	echo "Pas de séances pour le moment.";
}
		echo "<div class='clear'></div><br>";


}
?>
</div>

</div>
<!-- /.container -->


</body>
</html>
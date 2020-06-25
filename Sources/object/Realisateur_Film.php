<?php 

class Realisateur_Film
{
	
	public static function getListeFilm($unIdRealisateur)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT film.`Id_Film`, Titre, Duree_Film, Description, Date_Sortie, Langue, Limitation FROM film_realisateur INNER JOIN film ON film_realisateur.`Id_Film` = film.`Id_Film` INNER JOIN langue ON film.`Langue` = langue.`Id_Langue` WHERE `Id_Realisateur` =' . $unIdRealisateur);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$film = new Film();

			$film->setIdFilm($donnees['Id_Film']);
			$film->setTitreFilm($donnees['Titre']);
			$film->setDureeFilm($donnees['Duree_Film']);
			$film->setDescription($donnees['Description']);
			$film->setPhotoFilm($donnees['Id_Film']);
			$film->setDateSortie($donnees['Date_Sortie']);
			$film->setLangue($donnees['Langue']);
			$film->setLimitation($donnees['Limitation']);
			$resultat[] = $film;
		}

		return $resultat;
	}
	


	public static function getListeActeur($unIdFilm)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT acteur.`Id_Acteur`, `Prenom_Acteur`, `Nom_Acteur`, `DDN_Acteur`, `Age_Acteur`, `Nom_Langue` FROM acteur_film INNER JOIN acteur ON acteur_film.Id_Acteur = acteur.Id_Acteur INNER JOIN langue ON acteur.`Nationalite_Acteur` = langue.`Id_Langue` WHERE Id_Film =' . $unIdFilm);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteurs = new Acteur();

			$acteurs->setIdActeur($donnees['Id_Acteur']);
			$acteurs->setPrenomActeur($donnees['Prenom_Acteur']);
			$acteurs->setNomActeur($donnees['Nom_Acteur']);
			$acteurs->setPhotoActeur($donnees['Id_Acteur']);
			$acteurs->setDDNActeur($donnees['DDN_Acteur']);
			$acteurs->setAgeActeur($donnees['Age_Acteur']);
			$acteurs->setNationaliteActeur($donnees['Nom_Langue']);
			$resultat[] = $acteurs;
		}

		return $resultat;
	}
} 

?>
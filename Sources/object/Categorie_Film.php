<?php 

class Categorie_Film{
	
	//Méthodes
	public static function getCategorieFilm($unIdFilm)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT categorie_film.`Id_Categorie` AS IdCat, Nom_Categorie AS NomCat FROM categorie_film INNER JOIN categorie ON categorie_film.Id_Categorie = categorie.Id_Categorie WHERE categorie_film.Id_Film = ' . $unIdFilm);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$categorie = new Categorie();

			$categorie->setUnId($donnees['IdCat']);
			$categorie->setUnLibelle($donnees['NomCat']);
			$resultat[] = $categorie;
		}

		return $resultat;
	}

	
	
	public static function a()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Acteur, Prenom_Acteur, Nom_Acteur, DDN_Acteur, Age_Acteur, Nom_Langue FROM acteur INNER JOIN langue ON acteur.Nationalite_Acteur = langue.Id_Langue ORDER BY Nom_Acteur, Prenom_Acteur');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteurs = new Acteur();

			$acteurs->_Id = $donnees['Id_Acteur'];
			$acteurs->_Prenom = $donnees['Prenom_Acteur'];
			$acteurs->_Nom = $donnees['Nom_Acteur'];
			$acteurs->setPhotoActeur($donnees['Id_Acteur']);
			$acteurs->_DDN = $donnees['DDN_Acteur'];
			$acteurs->_Age = $donnees['Age_Acteur'];
			$acteurs->_Nationalite = $donnees['Nom_Langue'];
			$resultat[] = $acteurs;
		}

		return $resultat;
	}

	public static function UpdateActeur(Acteur $acteur)
	{
		global $bdd;
	    $requete = $bdd->prepare('UPDATE acteur SET Prenom_Acteur = :prenom, Nom_Acteur = :nom, DDN_Acteur = :ddn, Nationalite_Acteur = :nationalite WHERE Id_Acteur = :id');

	    $requete->bindValue(':id', $acteur->getIdActeur(), PDO::PARAM_INT);
	    $requete->bindValue(':prenom', $acteur->getPrenomActeur(), PDO::PARAM_INT);
	    $requete->bindValue(':nom', $acteur->getNomActeur(), PDO::PARAM_INT);
	    $requete->bindValue(':ddn', $acteur->getDDNActeur(), PDO::PARAM_INT);
	    $requete->bindValue(':nationalite', $acteur->getNationaliteActeur(), PDO::PARAM_INT);

	    $requete->execute();
	}

	
}

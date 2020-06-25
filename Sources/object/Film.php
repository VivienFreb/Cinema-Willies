<?php 

class Film{
	//Declaration variables
	private $_Id;
	private $_Titre;
	private $_DureeFilm;
	private $_Description;
	private $_Affiche_Path;
	private $_DateSortie;
	private $_Langue;
	private $_Limitation;
	
	//CONSTRUCTEUR
	public function __construct($unId ='', $unTitre='', $uneDuree='', $uneDescription='', $unePhoto='', $uneDateSortie='', $uneLangue='', $uneLimitation=''){
		$this->setIdFilm($unId);
		$this->setTitreFilm($unTitre);
		$this->setDureeFilm($uneDuree);
		$this->setDescription($uneDescription);
		$this->setPhotoFilm($unePhoto);
		$this->setDateSortie($uneDateSortie);
		$this->setLangue($uneLangue);
		$this->setLimitation($uneLimitation);
	}

	//Liste des gets	
	public function getIdFilm(){return $this->_Id;}
	public function getTitre(){return $this->_Titre;}
	public function getDureeFilm(){return $this->_DureeFilm;}
	public function getDescription(){return $this->_Description;}
	public function getPhotoFilm(){return $this->_Affiche_Path;}	
	public function getDateSortie(){return $this->_DateSortie;}
	public function getLangue(){return $this->_Langue;}
	public function getLimitation(){return $this->_Limitation;}

	//Liste des sets
	public function setIdFilm($id)
	{
		if(is_string($id))
		{
			$this->_Id = $id;
		}
	}

	public function setTitreFilm($titre)
	{
		if(is_string($titre))
		{
			$this->_Titre = $titre;
		}
	}

	public function setDureeFilm($duree)
	{
		if(is_string($duree))
		{
			$this->_DureeFilm = $duree;
		}
	}

	public function setDescription($description)
	{
		if(is_string($description))
		{
			$this->_Description = $description;
		}
	}

	/* Verif lien ? */
	public function setPhotoFilm($id)
	{
		global $movie_path, $img_extension;
		if(is_string($id))
		{
			$path = $movie_path . $id . $img_extension;
			$this->_Affiche_Path = $path;
		}
	}

	public function setDateSortie($dateSortie)
	{
		if(is_string($dateSortie))
		{
			$this->_DateSortie = $dateSortie;
		}
	}

	public function setLangue($langue)
	{
		if(is_string($langue))
		{
			$this->_Langue = $langue;
		}
	}

	public function setLimitation($limitation)
	{
		if(is_string($limitation))
		{
			$this->_Limitation = $limitation;
		}
	}
	
	//Méthodes
	public function AddFilm()
	{
		global $bdd;
		
		$requete = $bdd->prepare('INSERT INTO acteur (Prenom_Acteur, Nom_Acteur, DDN_Acteur, Nationalite_Acteur)
		VALUES (:prenom, :nom, :ddn, :nationalite)');
		
		
		$requete->bindValue(':prenom', $this->getPrenomActeur());
		$requete->bindValue(':nom', $this->getNomActeur());
		$requete->bindValue(':ddn', $this->getDDNActeur());
		$requete->bindValue(':nationalite', $this->getNationaliteActeur());
		
		$requete->execute();
	}

    public static function getFilmId($id)
	{
		global $bdd;
            
        $film = new Film();

		$requete = $bdd->query('SELECT Id_Film, Titre, Duree_Film, Description, Date_Sortie, Langue, Limitation FROM film WHERE Id_Film = '.$id . ' ORDER BY Titre');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{

			$film->_Id = $donnees['Id_Film'];
			$film->_Titre = $donnees['Titre'];
			$film->_DureeFilm = $donnees['Duree_Film'];
			$film->_Description = $donnees['Description'];
			$film->setPhotoFilm($donnees['Id_Film']);
			$film->_DateSortie = $donnees['Date_Sortie'];
			$film->_Langue = $donnees['Langue'];
			$film->_Limitation = $donnees['Limitation'];
		}

		return $film;
	}    
    
	public static function getListeFilm()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Film, Titre, Duree_Film, Description, Date_Sortie, Langue, Limitation FROM film ORDER BY Titre');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$film = new Film();

			$film->_Id = $donnees['Id_Film'];
			$film->_Titre = $donnees['Titre'];
			$film->_DureeFilm = $donnees['Duree_Film'];
			$film->_Description = $donnees['Description'];
			$film->setPhotoFilm($donnees['Id_Film']);
			$film->_DateSortie = $donnees['Date_Sortie'];
			$film->_Langue = $donnees['Langue'];
			$film->_Limitation = $donnees['Limitation'];
			$resultat[] = $film;
		}

		return $resultat;
	}

	public static function getFilmCinemaId($idCinema)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Film`,`Titre`,`Duree_Film`,`Description`, `Date_Sortie`, `Langue`, `Limitation` FROM `film` WHERE `Titre` LIKE "%' . $recherche .'%" OR year(`Date_Sortie`) = "' . $recherche .'"');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$film = new Film();	

			$film->_Id = $donnees['Id_Film'];
			$film->_Titre = $donnees['Titre'];
			$film->_DureeFilm = $donnees['Duree_Film'];
			$film->_Description = $donnees['Description'];
			$film->setPhotoFilm($donnees['Id_Film']);
			$film->_DateSortie = $donnees['Date_Sortie'];
			$film->_Langue = $donnees['Langue'];
			$film->_Limitation = $donnees['Limitation'];
			$resultat[] = $film;
		}

		return $resultat;
	}

	public static function getFilmSearch($recherche)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Film`,`Titre`,`Duree_Film`,`Description`, `Date_Sortie`, `Langue`, `Limitation` FROM `film` WHERE `Titre` LIKE "%' . $recherche .'%" OR year(`Date_Sortie`) = "' . $recherche .'"');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$film = new Film();	

			$film->_Id = $donnees['Id_Film'];
			$film->_Titre = $donnees['Titre'];
			$film->_DureeFilm = $donnees['Duree_Film'];
			$film->_Description = $donnees['Description'];
			$film->setPhotoFilm($donnees['Id_Film']);
			$film->_DateSortie = $donnees['Date_Sortie'];
			$film->_Langue = $donnees['Langue'];
			$film->_Limitation = $donnees['Limitation'];
			$resultat[] = $film;
		}

		return $resultat;
	}


		

	
}

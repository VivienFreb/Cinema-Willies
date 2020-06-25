<?php 

class Cinema{
	//Declaration variables
	private $_Id;
	private $_Nom;
	private $_Id_Ville;
	private $_Adresse_Cinema;
	private $_une_Ville; //Objet ville
	
	//CONSTRUCTEUR
	public function __construct($unId ='', $unNom='', $unIdVille='', $uneAdresse='', $uneVille=''){
		$this->setIdCinema($unId);
		$this->setNomCinema($unNom);
		$this->setIdVille($unIdVille);		
		$this->setAdresseCinema($uneAdresse);
		$this->setVille($uneVille);
	}

	//Liste des gets	
	public function getIdCinema(){return $this->_Id;}
	public function getNomCinema(){return $this->_Nom;}
	public function getIdVille(){return $this->_Id_Ville;}
	public function getAdresseCinema(){return $this->_Adresse_Cinema;}
	public function getVille(){return $this->_une_Ville;}

	//Liste des sets
	public function setIdCinema($id)
	{
		if(is_string($id))
		{
			$this->_Id = $id;
		}
	}

	public function setNomCinema($nom)
	{
		if(is_string($nom))
		{
			$this->_Nom = $nom;
		}
	}

	public function setIdVille($idVille)
	{
		if(is_string($idVille))
		{
			$this->_Id_Ville = $idVille;
		}
	}

	public function setAdresseCinema($adresse)
	{
		if(is_string($adresse))
		{
			$this->_Adresse_Cinema = $adresse;
		}
	}

	public function setVille($idCinema)
	{
			$this->_une_Ville = Ville::getVilleCinema($idCinema);
	}
	    
	//Méthodes
    
    public static function getCinema($id)
	{
		global $bdd;

		$requete = $bdd->query('SELECT `Id_Cinema`,`Nom`,`Id_Ville`,`Adresse_Cinema` FROM `cinema` WHERE `Id_Cinema` = ' . $id);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$cinema = new Cinema($donnees['Id_Cinema'], $donnees['Nom'], $donnees['Id_Ville'], $donnees['Adresse_Cinema'], $donnees['Id_Cinema']);
		}
        
        return $cinema;
	}

    
	public static function getListeCinema($recherche)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Cinema, Nom, Adresse_Cinema, V.Id_Ville, Nom_Ville, Cp_Ville, P.Id_Pays, Nom_Pays FROM `cinema` C INNER JOIN ville V ON C.Id_Ville = V.Id_Ville INNER JOIN pays P ON V.Id_Pays = P.Id_Pays WHERE Nom LIKE "%' . $recherche .'%" OR Nom_Ville LIKE "%' . $recherche .'%" OR Cp_Ville LIKE "%' . $recherche .'%"');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$cinema = new Cinema($donnees['Id_Cinema'], $donnees['Nom'], $donnees['Id_Ville'], $donnees['Adresse_Cinema'], $donnees['Id_Cinema']);			//$unId ='', $unNom='', $unIdVille='', $uneAdresse='', $uneVille=''

			$resultat[] = $cinema;
		}

		return $resultat;
	}


	public static function getListeCinemaVille($idVille)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Cinema, Nom, Adresse_Cinema, V.Id_Ville, Nom_Ville, Cp_Ville, P.Id_Pays, Nom_Pays FROM `cinema` C INNER JOIN ville V ON C.Id_Ville = V.Id_Ville INNER JOIN pays P ON V.Id_Pays = P.Id_Pays WHERE V.Id_Ville = '. $idVille);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$cinema = new Cinema($donnees['Id_Cinema'], $donnees['Nom'], $donnees['Id_Ville'], $donnees['Adresse_Cinema'], $donnees['Id_Cinema']);			//$unId ='', $unNom='', $unIdVille='', $uneAdresse='', $uneVille=''

			$resultat[] = $cinema;
		}

		return $resultat;
	}


	/*
	
	public static function getListeCinema()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query("SELECT Id_Cinema, Nom, Adresse_Cinema, V.Id_Ville, Nom_Ville, Cp_Ville, P.Id_Pays, Nom_Pays FROM `cinema` C INNER JOIN ville V ON C.Id_Ville = V.Id_Ville INNER JOIN pays P ON V.Id_Pays = P.Id_Pays WHERE Nom LIKE "%9%" OR Nom_Ville LIKE "%9%" OR Cp_Ville LIKE "%9%"";);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$cinema = new Cinema();


			$cinema->_Id = $donnees['Id_Cinema'];
			$cinema->_Nom = $donnees['Nom'];
			$cinema->_Id_Ville = $donnees['Id_Ville'];
			$cinema->_Adresse_Cinema = $donnees['Adresse_Cinema'];

			$resultat[] = $cinema;
		}

		return $resultat;
	}
public static function getActeurSearch($recherche)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Acteur`, `Prenom_Acteur`, `Nom_Acteur`, `DDN_Acteur`, `Age_Acteur`, `Nationalite_Acteur` FROM acteur WHERE `Prenom_Acteur` LIKE "%' . $recherche .'%" OR `Nom_Acteur` LIKE "%' . $recherche .'%"');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteurs = new Acteur();

			$acteurs->_Id = $donnees['Id_Acteur'];
			$acteurs->_Prenom = $donnees['Prenom_Acteur'];
			$acteurs->_Nom = $donnees['Nom_Acteur'];
			$acteurs->setPhotoActeur($donnees['Id_Acteur']);
			$acteurs->_DDN = $donnees['DDN_Acteur'];
			$acteurs->_Age = $donnees['Age_Acteur'];
			$acteurs->_Nationalite = $donnees['Nationalite_Acteur'];
			$resultat[] = $acteurs;
		}

		return $resultat;
	}
	*/
	
}

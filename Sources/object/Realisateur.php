<?php 

class Realisateur{
	
	//Declaration variables
	private $_Id;
	private $_Prenom;
	private $_Nom;
	private $_Photo_Path;	
	private $_DDN;
	private $_Age;
	private $_Nationalite;
	private $_Bio;
	
	//CONSTRUCTEUR

	//Surcharge
	public function __construct($unId ='', $unPrenom='', $unNom='', $unePhoto='' , $uneDDN='', $uneNationalite='', $uneBio=''){
		$this->setIdActeur($unId);
		$this->setPrenomActeur($unPrenom);
		$this->setNomActeur($unNom);
		$this->setPhotoActeur($unePhoto);
		$this->setDDNActeur($uneDDN);
		$this->setNationaliteActeur($uneNationalite);
		$this->setBio($uneBio);
	}

	//Liste des gets	
	public function getIdActeur(){return $this->_Id;}
	public function getNomActeur(){return $this->_Nom;}
	public function getPrenomActeur(){return $this->_Prenom;}
	public function getPhotoActeur(){return $this->_Photo_Path;}
	public function getDDNActeur(){return $this->_DDN;}
	public function getAgeActeur(){return $this->_Age;}
	public function getNationaliteActeur(){return $this->_Nationalite;}
	public function getBio(){return $this->_Bio;}	
	public function getFullNameActeur(){ 
		$fullname;

		$fullname = $this->_Nom . " " . $this->_Prenom;

		return $fullname;
	}

	public function getNationaliteClair(){
		global $bdd;

		$film;

		$requete = $bdd->query('SELECT `Nom_Langue` FROM `cinema`.`langue` WHERE `Id_Langue` = '. $this->_Nationalite);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$film = $donnees["Nom_Langue"];
		}

		return $film;
	}

	//Liste des sets
	public function setIdActeur($id)
	{
		if(is_string($id))
		{
			$this->_Id = $id;
		}
	}

	public function setPrenomActeur($prenom)
	{
		if(is_string($prenom))
		{
			$this->_Prenom = $prenom;
		}
	}

	public function setNomActeur($nom)
	{
		if(is_string($nom))
		{
			$this->_Nom = $nom;
		}
	}

	public function setPhotoActeur($id)
	{
		global $realisateur_path, $img_extension;
		if(is_string($id))
		{
			$path = $realisateur_path . $id . $img_extension;
			$this->_Photo_Path = $path;
		}
	}

	public function setDDNActeur($ddn)
	{
		if(is_string($ddn))
		{
			$this->_DDN = $ddn;
		}
	}

	public function setAgeActeur($age)
	{
		if(is_string($age))
		{
			$this->_Age = $age;
		}
	}

	public function setNationaliteActeur($nationalite)
	{
		if(is_string($nationalite))
		{
			$this->_Nationalite = $nationalite;
		}
	}
	
	public function setBio($bio)
	{
		if(is_string($bio))
		{
			$this->_Bio = $bio;
		}
	}

    public static function getRealisateurId($id)
	{
		global $bdd;
            
        $acteur = new Realisateur();

		$requete = $bdd->query('SELECT `Id_Realisateur`,`Prenom_Realisateur`,`Nom_Realisateur`,`DDN_Realisateur`,`Age_Realisateur`,`Nationalite_Realisateur`,`Realisateur_Bio` FROM realisateur WHERE `Id_Realisateur` = '.$id);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteur->_Id = $donnees['Id_Realisateur'];
			$acteur->_Prenom = $donnees['Prenom_Realisateur'];
			$acteur->_Nom = $donnees['Nom_Realisateur'];
			$acteur->setPhotoActeur($donnees['Id_Realisateur']);
			$acteur->_DDN = $donnees['DDN_Realisateur'];
			$acteur->_Age = $donnees['Age_Realisateur'];
			$acteur->_Nationalite = $donnees['Nationalite_Realisateur'];
			$acteur->_Bio = $donnees['Realisateur_Bio'];
		}

		return $acteur;
	}

	
	public static function getListeRealisateur()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Realisateur`,`Prenom_Realisateur`,`Nom_Realisateur`,`DDN_Realisateur`,`Age_Realisateur`, `Nom_Langue`, `Realisateur_Bio` FROM realisateur INNER JOIN langue ON realisateur.`Nationalite_Realisateur` = langue.Id_Langue ORDER BY `Nom_Realisateur`,`Prenom_Realisateur`');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteurs = new Realisateur();

			$acteurs->_Id = $donnees['Id_Realisateur'];
			$acteurs->_Prenom = $donnees['Prenom_Realisateur'];
			$acteurs->_Nom = $donnees['Nom_Realisateur'];
			$acteurs->setPhotoActeur($donnees['Id_Realisateur']);
			$acteurs->_DDN = $donnees['DDN_Realisateur'];
			$acteurs->_Age = $donnees['Age_Realisateur'];
			$acteurs->_Nationalite = $donnees['Nom_Langue'];
			$acteurs->_Bio = $donnees['Realisateur_Bio'];

			$resultat[] = $acteurs;
		}

		return $resultat;
	}


	public static function getRealisateurSearch($recherche)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Realisateur`,`Prenom_Realisateur`,`Nom_Realisateur`,`DDN_Realisateur`,`Age_Realisateur`,`Nationalite_Realisateur` FROM realisateur WHERE `Prenom_Realisateur` LIKE "%' . $recherche .'%" OR `Nom_Realisateur` LIKE "%' . $recherche .'%"');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteurs = new Realisateur();

			$acteurs->_Id = $donnees['Id_Realisateur'];
			$acteurs->_Prenom = $donnees['Prenom_Realisateur'];
			$acteurs->_Nom = $donnees['Nom_Realisateur'];
			$acteurs->setPhotoActeur($donnees['Id_Realisateur']);
			$acteurs->_DDN = $donnees['DDN_Realisateur'];
			$acteurs->_Age = $donnees['Age_Realisateur'];
			$acteurs->_Nationalite = $donnees['Nationalite_Realisateur'];
			$resultat[] = $acteurs;
		}

		return $resultat;
	}


	
}

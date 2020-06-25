<?php 

class Acteur{
	
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
		global $acteur_path, $img_extension;
		if(is_string($id))
		{
			$path = $acteur_path . $id . $img_extension;
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

    public static function getActeurId($id)
	{
		global $bdd;
            
        $acteur = new Acteur();

		$requete = $bdd->query('SELECT `Id_Acteur`, `Prenom_Acteur`, `Nom_Acteur`, `DDN_Acteur`, `Age_Acteur`, `Nationalite_Acteur`, `Acteur_Bio` FROM acteur WHERE Id_Acteur = '.$id);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$acteur->_Id = $donnees['Id_Acteur'];
			$acteur->_Prenom = $donnees['Prenom_Acteur'];
			$acteur->_Nom = $donnees['Nom_Acteur'];
			$acteur->setPhotoActeur($donnees['Id_Acteur']);
			$acteur->_DDN = $donnees['DDN_Acteur'];
			$acteur->_Age = $donnees['Age_Acteur'];
			$acteur->_Nationalite = $donnees['Nationalite_Acteur'];
			$acteur->_Bio = $donnees['Acteur_Bio'];
		}

		return $acteur;
	}


	//Méthodes
	public function AddActeur()
	{
		global $bdd;
		
		$requete = $bdd->prepare('INSERT INTO acteur (Prenom_Acteur, Nom_Acteur, DDN_Acteur, Nationalite_Acteur, Acteur_Bio)
		VALUES (:prenom, :nom, :ddn, :nationalite)');
		
		
		$requete->bindValue(':prenom', $this->getPrenomActeur());
		$requete->bindValue(':nom', $this->getNomActeur());
		$requete->bindValue(':ddn', $this->getDDNActeur());
		$requete->bindValue(':nationalite', $this->getNationaliteActeur());
		
		$requete->execute();
	}

	
	
	public static function getListeActeur()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Acteur, Prenom_Acteur, Nom_Acteur, DDN_Acteur, Age_Acteur, Nom_Langue, Acteur_Bio FROM acteur INNER JOIN langue ON acteur.Nationalite_Acteur = langue.Id_Langue ORDER BY Nom_Acteur, Prenom_Acteur');

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
			$acteurs->_Bio = $donnees['Acteur_Bio'];

			$resultat[] = $acteurs;
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

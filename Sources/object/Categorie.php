<?php 

class Categorie{
	
	//Declaration variables
	private $_Id;
	private $_Libelle;
	
	//CONSTRUCTEUR

	//Surcharge
	public function __construct($unId ='', $unLibelle=''){
		$this->setUnId($unId);
		$this->setUnLibelle($unLibelle);
	}

	//Liste des gets	
	public function getIdCategorie(){return $this->_Id;}
	public function getLibelleCategorie(){return $this->_Libelle;}


	//Liste des sets
	public function setUnId($id)
	{
		if(is_string($id))
		{
			$this->_Id = $id;
		}
	}

	public function setUnLibelle($unLibelle)
	{
		if(is_string($unLibelle))
		{
			$this->_Libelle = $unLibelle;
		}
	}
	/*
	//Méthodes
	public function AddActeur()
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

	
	
	public static function getCategorieFilm()
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
*/
	
}

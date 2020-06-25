<?php 

class Ville{
	//Declaration variables
	private $_Id_Ville;
	private $_Nom_Ville;
	private $_Cp_Ville;
	private $_Id_Pays;
	
	//CONSTRUCTEUR
	public function __construct($unIdVille ='', $unNomVille='', $unCpVille='', $unIdPays=''){
		$this->setIdVille($unIdVille);
		$this->setNomVille($unNomVille);
		$this->setCpVille($unCpVille);
		$this->setIdPays($unIdPays);
	}

	//Liste des gets	
	public function getIdVille(){return $this->_Id_Ville;}
	public function getNomVille(){return $this->_Nom_Ville;}
	public function getCpVille(){return $this->_Cp_Ville;}
	public function getIdPays(){return $this->_Id_Pays;}

	//Liste des sets
	public function setIdVille($idVille)
	{
		if(is_string($idVille))
		{
			$this->_Id_Ville = $idVille;
		}
	}

	public function setNomVille($nomVille)
	{
		if(is_string($nomVille))
		{
			$this->_Nom_Ville = $nomVille;
		}
	}

	public function setCpVille($cpVille)
	{
		if(is_string($cpVille))
		{
			$this->_Cp_Ville = $cpVille;
		}
	}

	public function setIdPays($idpays)
	{
		if(is_string($idpays))
		{
			$this->_Id_Pays = $idpays;
		}
	}
	
	//Méthodes
	public static function getListeVille()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Ville`, `Nom_Ville`, `Cp_Ville`, `Id_Pays` FROM `ville`');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$ville = new Ville();

			$ville->_Id_Ville = $donnees['Id_Ville'];
			$ville->_Nom_Ville = $donnees['Nom_Ville'];
			$ville->_Cp_Ville = $donnees['Cp_Ville'];
			$ville->_Id_Pays = $donnees['Id_Pays'];

			$resultat[] = $ville;
		}

		return $resultat;
	}

	public static function getVilleId($idVille)
	{
		global $bdd;

		$requete = $bdd->query('SELECT `Id_Ville`, `Nom_Ville`, `Cp_Ville`, `Id_Pays` FROM `ville` WHERE `Id_Ville` = ' . $idVille);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$ville = new Ville();

			$ville->_Id_Ville = $donnees['Id_Ville'];
			$ville->_Nom_Ville = $donnees['Nom_Ville'];
			$ville->_Cp_Ville = $donnees['Cp_Ville'];
			$ville->_Id_Pays = $donnees['Id_Pays'];

		}

		return $ville;
	}

	public static function getVilleCinema($idCinema)
	{
		global $bdd;

		$requete = $bdd->query('SELECT Id_Cinema, Nom, Adresse_Cinema, V.Id_Ville, Nom_Ville, Cp_Ville, P.Id_Pays, Nom_Pays FROM `cinema` C INNER JOIN ville V ON C.Id_Ville = V.Id_Ville INNER JOIN pays P ON V.Id_Pays = P.Id_Pays WHERE Id_Cinema = ' . $idCinema);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$ville = new Ville();
			

			$ville->_Id_Ville = $donnees['Id_Ville'];
			$ville->_Nom_Ville = $donnees['Nom_Ville'];
			$ville->_Cp_Ville = $donnees['Cp_Ville'];
			$ville->_Id_Pays = $donnees['Id_Pays'];
		}

		return $ville;
	}


	
}

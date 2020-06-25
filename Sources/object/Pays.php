<?php 

class Pays{
	//Declaration variables
	private $_Id_Pays;
	private $_Nom_Pays;
	
	//CONSTRUCTEUR
	public function __construct($unIdPays ='', $unNomPays=''){
		$this->setIdPays($unIdPays);
		$this->setNomPays($unNomPays);
	}

	//Liste des gets	
	public function getIdVille(){return $this->_Id_Pays;}
	public function getNomVille(){return $this->_Nom_Pays;}

	//Liste des sets
	public function setIdPays($idPays)
	{
		if(is_string($idPays))
		{
			$this->_Id_Pays = $idPays;
		}
	}

	public function setNomPays($nomPays)
	{
		if(is_string($nomPays))
		{
			$this->_Nom_Pays = $nomPays;
		}
	}
	
	//Méthodes
	public static function getListePays()
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Pays`, `Nom_Pays` FROM `pays`');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$pays = new Pays();

			$pays->_Id_Pays = $donnees['Id_Pays'];
			$pays->_Nom_Pays = $donnees['Nom_Pays'];

			$resultat[] = $pays;
		}
		return $resultat;
	}


	
}

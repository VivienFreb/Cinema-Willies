<?php 

class Reservation{
	//Declaration variables
	private $_Id_Reservation;
	private $_Id_Client;
	private $_Id_Horaire;
	private $_Id_Film;
	private $_Id_Cinema;
	private $_Id_Salle;
	private $_Horaire;
	private $_nbrReserv;
	
	//CONSTRUCTEUR
	public function __construct($unIdReservation ='', $unIdClient='', $unIdHoraire=''){
		$this->setIdReservation($unIdReservation);
		$this->setIdClient($unIdClient);
		$this->setIdHoraire($unIdHoraire);
	}

	//Liste des gets	
	public function getIdReservation(){return $this->_Id_Reservation;}
	public function getIdClient(){return $this->_Id_Client;}
	public function getIdHoraire(){return $this->_Id_Horaire;}
	public function getIdFilm(){return $this->_Id_Film;}
	public function getIdCinema(){return $this->_Id_Cinema;}
	public function getIdSalle(){return $this->_Id_Salle;}
	public function getHoraire(){return $this->_Horaire;}
	public function getNbrReserv(){return $this->_nbrReserv;}

	//Liste des sets
	public function setIdReservation($IdReservation)
	{
		if(is_string($IdReservation))
		{
			$this->_Id_Reservation = $IdReservation;
		}
	}

	public function setIdClient($IdClient)
	{
		if(is_string($IdClient))
		{
			$this->_Id_Client = $IdClient;
		}
	}

	public function setIdHoraire($IdHoraire)
	{
		if(is_string($IdHoraire))
		{
			$this->_Id_Horaire = $IdHoraire;
		}
	}
	
	//Méthodes

	public static function getReservationId($idReservation)
	{
		global $bdd;

		$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, nbReserv FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Reservation = ' . $idReservation);
		/*$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, COUNT(*) FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Client = 39 GROUP BY Id_Client, Id_Horaire');*/
		$reservation = new Reservation();
		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{			
			$reservation->_Id_Reservation = $donnees['Id_Reservation'];
			$reservation->_Id_Client = $donnees['Id_Client'];
			$reservation->_Id_Horaire = $donnees['Id_Horaire'];
			$reservation->_Id_Film = $donnees['Id_Film'];
			$reservation->_Id_Cinema = $donnees['Id_Cinema'];
			$reservation->_Id_Salle = $donnees['Id_Salle'];
			$reservation->_Horaire = $donnees['Horaire'];
			$reservation->_nbrReserv = $donnees['nbReserv'];
		}

		return $reservation;
	}

	public static function getReservationClient($idClient)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, nbReserv FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Client = ' . $idClient . '  ORDER BY Horaire');
		/*$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, COUNT(*) FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Client = 39 GROUP BY Id_Client, Id_Horaire');*/

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$reservation = new Reservation();
			

			$reservation->_Id_Reservation = $donnees['Id_Reservation'];
			$reservation->_Id_Client = $donnees['Id_Client'];
			$reservation->_Id_Horaire = $donnees['Id_Horaire'];
			$reservation->_Id_Film = $donnees['Id_Film'];
			$reservation->_Id_Cinema = $donnees['Id_Cinema'];
			$reservation->_Id_Salle = $donnees['Id_Salle'];
			$reservation->_Horaire = $donnees['Horaire'];
			$reservation->_nbrReserv = $donnees['nbReserv'];

			$resultat[] = $reservation;
		}

		return $resultat;
	}

	public static function old_getReservationClient($idClient)
	{
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, COUNT(*) AS nbrReserv FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Client = ' . $idClient . ' GROUP BY Id_Client, Id_Horaire ORDER BY Horaire');
		/*$requete = $bdd->query('SELECT Id_Reservation, Id_Client, H.Id_Horaire, Id_Film, Id_Cinema, Id_Salle, Id_Langue, Horaire, Nbr_Places, COUNT(*) FROM `reservation_film` RF INNER JOIN `horaire` H ON RF.`Id_Horaire` = H.`Id_Horaire` WHERE Id_Client = 39 GROUP BY Id_Client, Id_Horaire');*/

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$reservation = new Reservation();
			

			$reservation->_Id_Reservation = $donnees['Id_Reservation'];
			$reservation->_Id_Client = $donnees['Id_Client'];
			$reservation->_Id_Horaire = $donnees['Id_Horaire'];
			$reservation->_Id_Film = $donnees['Id_Film'];
			$reservation->_Id_Cinema = $donnees['Id_Cinema'];
			$reservation->_Id_Salle = $donnees['Id_Salle'];
			$reservation->_Horaire = $donnees['Horaire'];
			$reservation->_nbrReserv = $donnees['nbrReserv'];

			$resultat[] = $reservation;
		}

		return $resultat;
	}

}

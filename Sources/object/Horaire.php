<?php 

class Horaire
{
	private $_Id_Horaire;
	private $_Id_Film;
	private $_Id_Cinema;
	private $_Id_Salle;
	private $_Id_Langue;
	private $_Horaire;
	private $_nbrPlaces;

    //CONSTRUCTEUR
	public function __construct($unIdHoraire ='', $unIdFilm='', $unIdCinema='', $unIdSalle='', $IdLangue='', $unHoraire=''){
		$this->setIdHoraire($unIdHoraire);
		$this->setIdFilm($unIdFilm);
		$this->setIdCinema($unIdCinema);
		$this->setIdSalle($unIdSalle);
		$this->setIdLangue($IdLangue);
		$this->setHoraire($unHoraire);
	}
    
    
    //Liste des gets	
	public function getIdHoraire(){return $this->_Id_Horaire;}
	public function getIdFilm(){return $this->_Id_Film;}
	public function getIdCinema(){return $this->_Id_Cinema;}
	public function getIdSalle(){return $this->_Id_Salle;}
	public function getIdLangue(){return $this->_Id_Langue;}	
	public function getHoraire(){return $this->_Horaire;}
	public function getNbrPlaces(){return $this->_nbrPlaces;}

	//Liste des sets
	public function setIdHoraire($id)
	{
		if(is_int($id))
		{
			$this->_Id_Horaire = $id;
		}
	}

	public function setIdFilm($idFilm)
	{
		if(is_int($idFilm))
		{
			$this->_Id_Film = $idFilm;
		}
	}

	public function setIdCinema($idCinema)
	{
		if(is_int($idCinema))
		{
			$this->_Id_Cinema = $idCinema;
		}
	}

	public function setIdSalle($idSalle)
	{
		if(is_int($idSalle))
		{
			$this->_Id_Salle = $idSalle;
		}
	}

	public function setIdLangue($idLangue)
	{
		if(is_int($idLangue))
		{
			$this->_Id_Langue = $idLangue;
		}
	}

	public function setHoraire($unHoraire)
	{
		if(is_string($unHoraire))
		{
			$this->_Horaire = $unHoraire;
		}
	}
    
    
	public static function planningSemaine($unIdCinema, $unIdFilm)
	{
		//Permet d'afficher un planning des horaires en fonction du film et de la salle
		//Le planning s'étends sur 7 jours (Lundi au dimanche)
		global $bdd;

		$dateAujourdui = date("Y-m-d"); //On commence à partir de la date du jour
		//$dateAujourdui=mktime(12, 00, 00, 3, 22, 2019); //Pour test
		//echo "Created date is " . date("Y-m-d", $dateAujourdui);

		$planning = array();

		for($i = 0; $i < 7; $i++)
		{
			//On effectue une requete pour récupérer les horaires de chaque jour, en commencant par 
			//Lundi puis ensuite date + 1 -> mardi...
			$date = date("Y-m-d", strtotime($dateAujourdui.' + '. $i .' days')); 

			//Requete qui pour afficher les horaires en fonction du cinéma choisi et du film choisi       
            $requete = $bdd->query('select `Id_Horaire`,`Id_Film`, horaire.`Id_Cinema`, horaire.`Id_Salle`,`Id_Langue`,`Horaire` from `horaire` where DATE(`Horaire`) = "' . $date . '" AND horaire.Id_Cinema = '. $unIdCinema . ' AND `Id_Film` = ' . $unIdFilm . ' ORDER BY `Horaire` ');
            //var_dump($requete);

 /*           if($requete->rowCount() > 0)
            {
                echo "Il y a quelque chose <br>";
            }
            else{
                echo "Il n'y a rien <br>";
            }
            */


			$HoraireDuJour = array(); //On créer un tableau par jour (Un tableau pour lundi, un autre pour mardi...)
            
			while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
			{
                $horaire = new Horaire();
                
                $horaire->_Id_Horaire = $donnees['Id_Horaire'];
                $horaire->_Id_Film = $donnees['Id_Film'];
                $horaire->_Id_Cinema = $donnees['Id_Cinema'];
                $horaire->_Id_Salle = $donnees['Id_Salle'];
                $horaire->_Id_Langue = $donnees['Id_Langue'];
                
                $horaireSeance = new DateTime($donnees["Horaire"]);//Le champ Horaire étant au format DateTime dans la base de données, 
                $horaire->_Horaire = $horaireSeance->format('H:i:s'); //il faut récupérer seulement l'heure. Pour cela on passe par un date->format() et on insére à la suite du tableau.
                
				array_push($HoraireDuJour, $horaire); 
			}
            
            
            
			$planning[] = $HoraireDuJour; //On ajoute nos tableaux de chaque jour dans un permettant l'affichage de tout les horaires pendant une semaine
            
            //var_dump($requete);

		}

        for($i=0;$i<=7;$i++)
        {
            if(!empty($planning[$i]))
            {
                return $planning;
            } 
        }    

        
    }
    
    public static function CinemasPourFilm($unFilm)
    {
        global $bdd;
        $CinemaParVille = array();
        $requete = $bdd->query('SELECT `Id_Cinema` FROM `cinema` WHERE `Id_Ville` =' . $_SESSION["IdVilleChoisie"]);
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $CinemaParVille[] = $donnees['Id_Cinema'];
        }
 
        
        return $CinemaParVille;
    }

    public static function getHoraireById($unId)
    {
    	global $bdd;

    	$horaire = new Horaire();

		$requete = $bdd->query('SELECT `Id_Horaire`,`Id_Film`,`Id_Cinema`,`Id_Salle`,`Id_Langue`,`Horaire`,`Nbr_Places` FROM `horaire` WHERE `Id_Horaire` = ' . $unId);

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
                $horaire->_Id_Horaire = $donnees['Id_Horaire'];
                $horaire->_Id_Film = $donnees['Id_Film'];
                $horaire->_Id_Cinema = $donnees['Id_Cinema'];
                $horaire->_Id_Salle = $donnees['Id_Cinema'];
                $horaire->_Id_Langue = $donnees['Id_Langue'];
                $horaire->_Horaire = $donnees['Horaire'];
                $horaire->_nbrPlaces = $donnees['Nbr_Places'];                
		}
        
        return $horaire;
    }


    //Liste des films proposé par le cinéma (id)
    public static function getListeFilmsCinema($idCinema)
    {
		global $bdd;

		$resultat = array();

		$requete = $bdd->query('SELECT `Id_Horaire`,`Id_Film`,`Id_Cinema` FROM `horaire` WHERE `Id_Cinema` =' . $idCinema . ' GROUP BY `Id_Film`');

		while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$idFilm = $donnees['Id_Film'];

			$resultat[] = $idFilm;
		}

		return $resultat;
    }


	}

?>

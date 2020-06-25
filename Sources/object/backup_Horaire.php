<?php 

class Horaire
{
	private $_Id_Horaire;
	private $_Id_Film;
	private $_Id_Salle;
	private $_Id_Langue;
	private $_Horaire;

	public static function planningSemaine($unIdCinema, $unIdFilm)
	{
		//Permet d'afficher un planning des horaires en fonction du film et de la salle
		//Le planning s'étends sur 7 jours (Lundi au dimanche)
		global $bdd;

		$dateAujourdui = date("Y-m-d"); //On comme à partir de la date du jour

		$planning = array();

		for($i = 0; $i < 7; $i++)
		{
			//On effectue une requete pour récupérer les horaires de chaque jour, en commencant par 
			//Lundi puis ensuite date + 1 -> mardi...
			$date = date("Y-m-d", strtotime($dateAujourdui.' + '. $i .' days')); 

			//Requete qui pour afficher les horaires en fonction du cinéma choisi et du film choisi
			$requete = $bdd->query('select `Id_Horaire`,`Id_Film`, horaire.`Id_Salle`,`Langue_Version`,`Horaire`, `Nbr_Places`, `Id_Cinema` from `horaire` INNER JOIN salles ON horaire.Id_Salle = salles.Id_Salle where DATE(`Horaire`) = "' . $date . '" AND salles.Id_Cinema = '. $unIdCinema . ' AND `Id_Film` = ' . $unIdFilm);

			setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1'); //Nous permet d'afficher les dates au format français (Lundi au lieu de Monday)
			$nomJour =  strftime("%a %d %b", strtotime($date)); //%a %d et %b permettent d'obtenir le jour abrégé en 3 lettres, le jour en deux chiffres et le mois en 3 lettres (Ex  :  ven. 23 nov.)

			$HoraireDuJour = array(); //On créer un tableau par jour (Un tableau pour lundi, un autre pour mardi...)
			array_push($HoraireDuJour, $nomJour);	//Dans la première case on y mettra la date abrégée

			while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
			{
				$horaireSeance = new DateTime($donnees["Horaire"]); //Le champ Horaire étant au format DateTime dans la base de données, 
				array_push($HoraireDuJour, $horaireSeance->format('H:i:s')); //il faut récupérer seulement l'heure. Pour cela on passe par un date->format() et on insére à la suite du tableau.
			}

			$planning[] = $HoraireDuJour; //On ajoute nos tableaux de chaque jour dans un permettant l'affichage de tout les horaires pendant une semaine

		}




			return $planning;
/*
		//On créer un tableau pour pourmettre l'affichage des horaires.
		echo "<table>";
		echo "<caption>Affichage horaire en fonction d'un film et d'un cinéma</caption>";
			for($ligne = 0; $ligne < $biggestColumn; $ligne++){
				echo "<tr> ";

				for($col = 0; $col < count($planning); $col++)
				{
					//Certains jours ont un plus grand nombre de séances que d'autres
					//On fait donc une vérification si la case est vide et si oui, on y mettra un espace.
					if(!empty($planning[$col][$ligne]))
					echo "<td>" . $planning[$col][$ligne]. "</td>";
					else
						echo "<td></td>";
				}				

				echo "</tr>";
			}


		echo "</table>";
*/

	}
}



?>
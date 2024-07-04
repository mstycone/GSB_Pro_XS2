<?php
	include("vues/v_sommaireVisiteur.php");

	// Vérifie que l'action est définie
	$action = $_REQUEST['action'];

	// Récupère l'identifiant du visiteur depuis la session
	$idvisiteur = (isset($_SESSION['id']) && isset($_SESSION['idtypeemploye']) && $_SESSION['idtypeemploye'] == 'V') ? $_SESSION['id'] : null;

	// Vérifie que l'utilisateur est connecté
	if ($idvisiteur === null) {
		ajouterErreur("Visiteur non connecté ou type inconnu");
		include("vues/v_erreurs.php");
		include("vues/v_connexion.php");
		exit;
	}

	// Utilisation d'un switch pour gérer les différentes actions possibles
	switch($action){

		case 'selectionnerMois': {

			// Récupère les mois disponibles pour le visiteur
			$lesMois=$pdo->getLesMoisDisponibles($idvisiteur);
			// Afin de sélectionner par défaut le dernier mois dans la zone de liste
			// on demande toutes les clés, et on prend la première,
			// les mois étant triés décroissants
			$lesCles = array_keys( $lesMois );
			$moisASelectionner = $lesCles[0];
			include("vues/v_listeMois.php");
			break;

		}

		case 'voirEtatFrais': {
			
			$leMois = $_REQUEST['lstMois']; 

			// Récupère les mois disponibles pour le visiteur
			$lesMois=$pdo->getLesMoisDisponibles($idvisiteur);
			$moisASelectionner = $leMois;
			include("vues/v_listeMois.php");

			// Récupère les frais hors forfait pour le mois sélectionné
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur,$leMois);
			// Récupère les frais forfait pour le mois sélectionné
			$lesFraisForfait= $pdo->getLesFraisForfait($idvisiteur,$leMois);
			// Récupère les informations du mois sélectionné
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idvisiteur,$leMois);
			
			// Extrait l'année et le mois du mois sélectionné
			$numAnnee =substr( $leMois,0,4);
			$numMois =substr( $leMois,4,2);

			// Récupère les informations de l'état de la fiche de frais
			$libEtat = $lesInfosFicheFrais['libEtat'];
			$montantvalide = $lesInfosFicheFrais['montantvalide'];
			$nbjustificatifs = $lesInfosFicheFrais['nbjustificatifs'];
			$datemodif =  $lesInfosFicheFrais['datemodif'];

			// Convertit la date de modification au format français
			$datemodif =  dateAnglaisVersFrancais($datemodif);
			include("vues/v_etatFrais.php");
			//Ici on pourrait rajouter un 'break'
		}
	}
?>
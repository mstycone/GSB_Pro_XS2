<?php
include("vues/v_sommaireVisiteur.php");

// Récupère l'action à effectuer depuis la requête
$action = $_REQUEST['action'];

// Récupère l'identifiant de l'empoyé depuis la session
$idemploye = $_SESSION['idemploye'];

if ($_SESSION['idtypeEmploye'] !== 'V') {
	include('vues/v_erreurs.php');
	exit(); 
}

// Utilisation d'un switch pour gérer les différentes actions possibles
switch($action){
	case 'selectionnerMois':{
        // Récupère les mois disponibles pour l'employe (visiteur)
		$lesMois=$pdo->getLesMoisDisponibles($idemploye);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMois.php");
		break;
	}
	case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois']; 

        // Récupère les mois disponibles pour l'employe (visiteur)
		$lesMois=$pdo->getLesMoisDisponibles($idemploye);
		$moisASelectionner = $leMois;
		include("vues/v_listeMois.php");

        // Récupère les frais hors forfait pour le mois sélectionné
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idemploye,$leMois);
		// Récupère les frais forfait pour le mois sélectionné
		$lesFraisForfait= $pdo->getLesFraisForfait($idemploye,$leMois);
		// Récupère les informations du mois sélectionné
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idemploye,$leMois);
		
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
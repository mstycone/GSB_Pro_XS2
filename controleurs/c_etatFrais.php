<?php
include("vues/v_sommaireVisiteur.php");
include("vues/v_sommaireComptable.php");

// Récupère l'action à effectuer depuis la requête
$action = $_REQUEST['action'];

// Récupère l'identifiant de l'empoyé depuis la session
$idemploye = $_SESSION['idemploye'];

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
		
		// Récupération des visiteurs
        $lesVisiteurs = $pdo->getLesVisiteurs();
        // Récupère les mois disponibles pour les visiteurs
		$lesMois=$pdo->getLesMoisDisponiblesAValider();
		include("vues/v_selectionFicheFrais.php");

        if (isset($_POST['lstVisiteur']) && isset($_POST['lstMois'])) {
		$idVisiteur = $_POST['lstVisiteur'];
        $leMois = $_POST['lstMois'];

		// Récupère les informations du mois sélectionné
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);

        // Vérifie si une fiche de frais existe
		if (!$lesInfosFicheFrais) {
			ajouterErreur("Pas de fiche de frais pour ce visiteur ce mois.");
			include("vues/v_erreurs.php");
			header('Location: index.php?uc=etatfrais&action=voirEtatFrais');
			exit();
		} else {
        // Récupère les frais hors forfait pour le mois sélectionné
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		// Récupère les frais forfait pour le mois sélectionné
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		
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
		break;
		}
	  } else {  
		ajouterErreur("Les champs visiteur et mois doivent être sélectionnés.");
		include("vues/v_erreurs.php");
	  } 
	  break;
	} 
    case 'mettrePaiement':{
		$idemploye = $_REQUEST['idemploye'];
		$mois = $_REQUEST['mois'];
		$pdo->majEtatFicheFrais($idemploye, $mois, 'VA');
		header('Location: index.php?uc=etatfrais&action=voirEtatFrais');
		exit();
		break;
	}
	case 'fichePaye':{
		$idemploye = $_REQUEST['idemploye'];
		$mois = $_REQUEST['mois'];
		$pdo->majEtatFicheFrais($idemploye, $mois, 'RB');
		header('Location: index.php?uc=etatfrais&action=voirEtatFrais');
		exit();
		break;
	}
}
?>
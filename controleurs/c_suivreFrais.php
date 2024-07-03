<?php
include("vues/v_sommaireComptable.php");

// Vérifie que l'action est définie
// ƒ strtolower permet d'éviter la casse et rend le code plus tolérant aux variations 
$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : '';


// Vérifie que l'identifiant du comptable est défini dans la session
if (isset($_SESSION['idcomptable'])) {
	$idcomptable = $_SESSION['idcomptable'];
} else {
	echo 'Identifiant du comptable non défini';
}

// Utilisation d'un switch pour gérer les différentes actions possibles
switch($action){

	case 'selectionnerVisiteur' : {
		// Récupère les informations des visiteurs
		$lesVisiteurs = $pdo->getInfosVisiteur();

		if (!empty($lesVisiteurs)) {
            // Pour le premier visiteur récupéré, récupère les mois disponibles
			$visiteurASelectionner = $LesVisiteurs [0]['id'];
			// Récupère les mois disponibles pour le visiteur sélectionner
		    $lesMois=$pdo->getLesMoisDisponibles($visiteurASelectionner);

		    if (!empty($lesMois)) {
				// Afin de sélectionner par défaut le dernier mois dans la zone de liste
				// on demande toutes les clés, et on prend la première,
				// les mois étant triés décroissants
				$lesCles = array_keys( $lesMois );
				$moisASelectionner = $lesCles[0];
				include('vues/v_listeVisiteurs.php');

			} else {
				echo "Aucun mois disponible pour ce visiteur";
			}

		} else {
			echo "Aucun visiteur dans la base de données";
		}
		break;
	}

    case 'afficheFicheFraisAValider': {
        $leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';
		$leVisiteur = isset($_REQUEST['lstVisiteur']) ? $_REQUEST['lstVisiteur'] : '';

		if ($leVisiteur && $leMois){
			// Récupère les informations des visiteurs
			$lesVisiteurs = $pdo->getInfosVisiteur();
			// Récupère les mois disponibles pour le visiteur
			$lesMois=$pdo->getLesMoisDisponibles($leVisiteur);
			$moisASelectionner = $leMois;
			include('vues/v_listeVisiteurs.php');

			// Récupère les frais hors forfait pour le mois sélectionné
			$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($leVisiteur,$leMois);
			// Récupère les frais forfait pour le mois sélectionné
			$lesFraisForfait= $pdo->getLesFraisForfait($leVisiteur,$leMois);
			// Récupère les informations de la fiche du mois sélectionné
			$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);

			// Extrait l'année et le mois du mois sélectionné
			$numAnnee =substr( $leMois,0,4);
			$numMois =substr( $leMois,4,2);

			// Récupère les informations de l'état de la fiche de frais
			$libEtat = $lesInfosFicheFrais['libEtat'];
			$montantvalide = $lesInfosFicheFrais['montantvalide'];
			$nbjustificatifs = $lesInfosFicheFrais['nbjustificatifs'];
			$datemodif = dateAnglaisVersFrancais($lesInfosFicheFrais['datemodif']);
			include('vues/v_suivreFrais.php');

		} else {
			echo "Veuillez sélectionner un visiteur et un mois";
		}
		break;
	}	

    case 'misePaiement' : {
		$leVisiteur = isset($_REQUEST['lstVisiteur']) ? $_REQUEST['lstVisiteur'] : '';
		$leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';

		if ($leVisiteur && $leMois){
			$ficheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
			$ficheEtat = $ficheFrais['idEtat'];

			if ($ficheEtat == 'CL') {
				// Met à jour les frais forfaitisés en état 'VA':'Validée et mise en paiement'
		 		$majEtatFrais= $pdo->majEtatFicheFrais($leVisiteur,$leMois,'VA');
		 		echo 'la fiche a bien été mise en paiement';

			} else {
				echo 'la fiche doit être clôturé avant d\'être mise en paiement';
			}

		} else {
			echo " Veuillez sélectionner un visiteur et un mois ";
		} 
		break;
		
	}

	case 'remboursee' : {
		$leVisiteur = isset($_REQUEST['leVisiteur']) ? $_REQUEST['leVisiteur'] : '';
		$leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';

		if ($leVisiteur && $leMois){
			$ficheFrais = $pdo->getLesInfosFicheFrais($leVisiteur,$leMois);
			$ficheEtat = $ficheFrais['idEtat'];

				if ($ficheEtat == 'VA') {
					// Met à jour les frais forfaitisés en état 'VA':'Validée et mise en paiement'
		 			$majEtatFrais= $pdo->majEtatFicheFrais($leVisiteur,$leMois,'RB');
		 			echo 'la fiche a bien été remboursée';

				} else { 
					echo 'la fiche doit être en etat "validé et mise en paiement" avant d\'être remboursée';
				}
				
		} else {
			echo " Veuillez sélectionner un visiteur et un mois ";
		} 
		break;
	}	
}

?> 
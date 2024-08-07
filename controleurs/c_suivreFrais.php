<?php
	include("vues/v_sommaireComptable.php");

	// Vérifie que l'action est définie
	$action = $_REQUEST['action'];


	// Récupère l'identifiant du visiteur depuis la session
	$idcomptable = (isset($_SESSION['id']) && isset($_SESSION['idtypeemploye']) && $_SESSION['idtypeemploye'] == 'C') ? $_SESSION['id'] : null;

	// Vérifie que l'utilisateur est connecté
	if ($idcomptable === null) {
		ajouterErreur("Comptable non connecté ou type inconnu");
		include("vues/v_erreurs.php");
		include("vues/v_connexion.php");
		exit;
	}
	// Utilisation d'un switch pour gérer les différentes actions possibles
	switch($action){

		case 'selectionnerVisiteur' : {
			// Récupère les informations des visiteurs
			$lesVisiteurs = $pdo->getInfosVisiteurs();

			if (!empty($lesVisiteurs)) {
				// Pour le premier visiteur récupéré, récupère les mois disponibles
				$visiteurASelectionner = $lesVisiteurs [0]['id'];
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
					echo "<span style='color:white; font-size:bold'>Aucun mois disponible pour ce visiteur</span>";
				}

			} else {
				echo "<span style='color:white; font-size:bold'>Aucun visiteur dans la base de données</span>";
			}
			break;
		}

		case 'afficheFicheFraisAValider': {
			$leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';
			$leVisiteur = isset($_REQUEST['lstVisiteur']) ? $_REQUEST['lstVisiteur'] : '';

			if (!empty($leVisiteur) && !empty($leMois)){
				// Récupère les informations des visiteurs
				$lesVisiteurs = $pdo->getInfosVisiteurs();
				// Récupère les mois disponibles pour le visiteur
				$lesMois=$pdo->getLesMoisDisponibles($leVisiteur);
				$moisASelectionner = $leMois;
				include('vues/v_listeVisiteurs.php');

				// Récupère les détails du visiteur sélectionné
				foreach ($lesVisiteurs as $unVisiteur) {
					if ($unVisiteur['id'] == $leVisiteur) {
						$nom = $unVisiteur['nom'];
						$prenom = $unVisiteur['prenom'];
						break;
					}
				}

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
				echo "<span style='color:white; font-size:bold'>Veuillez sélectionner un visiteur et un mois</span>";
			}
			break;
		}	

		case 'misePaiement' : {
			$leVisiteur = isset($_REQUEST['lstVisiteur']) ? $_REQUEST['lstVisiteur'] : '';
			$leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';
			$ficheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        	$ficheEtat = $ficheFrais['libEtat'];

			if ($ficheEtat == 'Saisie clôturée') {
				// Met à jour les frais forfaitisés en état 'VA':'Validée et mise en paiement'
				$pdo->majEtatFicheFrais($leVisiteur,$leMois,'VA');
				echo "<span style='color:white; font-size:bold'>la fiche a bien été mise en paiement</span>";

			} else {
				echo "<span style='color:white; font-size:bold'>la fiche doit être clôturé avant d\'être mise en paiement</sapn>";
			}

			break;
			
		}

		case 'remboursee' : {
			$leVisiteur = isset($_REQUEST['lstVisiteur']) ? $_REQUEST['lstVisiteur'] : '';
			$leMois = isset($_REQUEST['lstMois']) ? $_REQUEST['lstMois'] : '';
			$ficheFrais = $pdo->getLesInfosFicheFrais($leVisiteur, $leMois);
        	$ficheEtat = $ficheFrais['libEtat'];

			if ($ficheEtat == 'Validée et mise en paiement') {
				// Met à jour les frais forfaitisés en état 'VA':'Validée et mise en paiement'
				$pdo->majEtatFicheFrais($leVisiteur,$leMois,'RB');
				echo "<span style='color:white; font-size:bold'>la fiche a bien été remboursée</span>";

			} else { 
				echo "<span style='color:white; font-size:bold'>la fiche doit être en etat avant d\'être remboursée</span>";
			}

			break;
		}	
	}

?>
<?php
include("vues/v_sommaireVisiteur.php");
include("vues/v_sommaireComptable.php");

// Récupère l'identifiant de l'employé depuis la session
$idemploye = $_SESSION['idemploye'];

// Récupère le mois actuel au format aaaamm
$mois = getMois(date("d/m/Y"));

// Extrait l'année et le mois du format aaaamm
$numAnnee =substr($mois,0,4);
$numMois =substr($mois,4,2);

// Récupère l'action à effectuer depuis la requête
$action = $_REQUEST['action'];
switch($action){
	case 'saisirFrais':{
        // Vérifie si c'est le premier frais du mois pour l'employe (visiteur)
		if($pdo->estPremierFraisMois($idemploye,$mois)){
            // Crée de nouvelles lignes de frais pour l'employe (visiteur) pour le mois courant
			$pdo->creeNouvellesLignesFrais($idemploye,$mois);
		}
		break;
	}
	case 'validerMajFraisForfait':{
        // Récupère les frais forfaitisés depuis la requête
		$lesFrais = $_REQUEST['lesFrais'];

        // Vérifie si les quantités de frais sont valides
		if(lesQteFraisValides($lesFrais)){
            // Met à jour les frais forfaitisés pour l'employe (comptable) pour le mois courant
	  	 	$pdo->majFraisForfait($idemploye,$mois,$lesFrais);
		}
		else{
			ajouterErreur("Les valeurs des frais doivent être numériques");
			include("vues/v_erreurs.php");
		}
	  break;
	}
	case 'validerCreationFrais':{
        // Récupère les informations du nouveau frais depuis la requête
		$dateFrais = $_REQUEST['dateFrais'];
		$libelle = $_REQUEST['libelle'];
		$montant = $_REQUEST['montant'];

        // Valide les informations du nouveau frais
		valideInfosFrais($dateFrais,$libelle,$montant);

        // Vérifie s'il y a des erreurs
		if (nbErreurs() != 0 ){
			include("vues/v_erreurs.php");
		}
		else{
            // Crée un nouveau frais hors forfait pour l'employe (comptable) pour le mois courant
			$pdo->creeNouveauFraisHorsForfait($idemploye,$mois,$libelle,$dateFrais,$montant);
		}
		break;
	}
	case 'supprimerFrais':{
        // Récupère l'identifiant du frais à supprimer depuis la requête
		$idFrais = $_REQUEST['idFrais'];

        // Supprime le frais hors forfait correspondant
	    $pdo->supprimerFraisHorsForfait($idFrais);
		break;
	}
}
// Récupère les frais hors forfait et forfaitisés pour le visiteur pour le mois courant
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idemploye,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idemploye,$mois);

include("vues/v_listeFraisForfait.php");
include("vues/v_listeFraisHorsForfait.php");

?>
<?php

// Récupère tous les employés
function getLesEmployes($pdo)
{
		$req = "select * from employe";
		// Exécute la requête
		$res = $pdo->query($req);
		// Récupère toutes les lignes de résultat
		$lesLignes = $res->fetchAll();
		// Retourne les lignes des employés
		return $lesLignes;
}
// Récupère toutes les fiches de frais
function getLesFichesFrais($pdo)
{
		$req = "select * from fichefrais";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
// Récupère tous les identifiants des frais forfait
function getLesIdFraisForfait($pdo)
{
		$req = "select fraisforfait.id as id from fraisforfait order by fraisforfait.id";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
}
// Récupère le dernier mois des fiches de frais pour un visiteur donné
function getDernierMois($pdo, $idemploye)
{
		$req = "select max(mois) as dernierMois from fichefrais where idemploye = '$idemploye'";
		$res = $pdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['dernierMois'];

}
// Calcule le mois suivant à partir d'un mois donné
function getMoisSuivant($mois){
		$numAnnee =substr( $mois,0,4); // Extrait l'année
		$numMois =substr( $mois,4,2); // Extrait le mois
		if($numMois=="12"){
			$numMois = "01"; // Si décembre, passe à janvier de l'année suivante
			$numAnnee++;
		}
		else{
			$numMois++;

		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois; // Ajoute un zéro devant si nécessaire
		return $numAnnee.$numMois; // Retourne l'année et le mois combinés
}

// Calcule le mois précédent à partir d'un mois donné
function getMoisPrecedent($mois){
		$numAnnee =substr( $mois,0,4); // Extrait l'année
		$numMois =substr( $mois,4,2); // Extrait le mois
		if($numMois=="01"){
			$numMois = "12"; // Si janvier, passe à décembre de l'année précédente
			$numAnnee--;
		}
		else{
			$numMois--;
		}
		if(strlen($numMois)==1)
			$numMois="0".$numMois; // Ajoute un zéro devant si nécessaire
		return $numAnnee.$numMois; // Retourne l'année et le mois combinés
}

//Clôture toutes les fiches du mois écoulé
function clotureFichesMoisPrecedent($pdo){
		//Appel de la fonction getMoisPrecedent pour avoir le mois écoulé 
		$moisActuel = date ('Ym');
		$moisPrecedent = getMoisPrecedent($moisActuel);
		//Requête de màj pour la clôture 
		$req= "update fichefrais set idetat = 'CL', datemodif = NOW() where mois='$moisPrecedent' and idetat = 'CR';";
		//Exécute la requête
		$pdo->exec($req);
}

// Crée des fiches de frais pour chaque employe à partir d'un mois donné
function creationFichesFrais($pdo, $moisDebut)
{
	$lesEmployes = getLesEmployes($pdo); // Récupère tous les employés
	$moisActuel = getMois(date("d/m/Y")); // Récupère le mois actuel
	$moisFin = getMoisPrecedent($moisActuel); // Calcule le mois précédent
	foreach($lesEmployes as $unEmploye)
	{
		// Pour chaque employe, initialise moisCourant avec le mois de fin
		$moisCourant = $moisFin; 
       // Récupère l'identifiant de l'employe
		$idemploye = $unEmploye['id'];
      // Initialise un compteur à 1 pour suivre le nombre de fiches créées
		$n = 1;

      // Tant que moisCourant est supérieur ou égal à moisDebut, continue de créer des fiches
		while($moisCourant >= $moisDebut)
		{
			// Pour la première itération, n == 1
			if($n == 1)
			{
			    // Si c'est la première fiche (n == 1), l'état est "CR" (Créé)
				$etat = "CR"; // État 'CR' pour la première fiche
               // moisModif est défini comme moisCourant
				$moisModif = $moisCourant;
			}
			else
			{
             // Si c'est la deuxième fiche (n == 2), l'état est "VA" (Validé)
				if($n == 2)
				{
					$etat = "VA"; // État 'VA' pour la deuxième fiche
					// moisModif est défini comme le mois suivant moisCourant
					$moisModif = getMoisSuivant($moisCourant);
				}
				else
				{
                  // Pour toutes les fiches suivantes (n >= 3), l'état est "RB" (Remboursé)
					$etat = "RB"; // État 'RB' pour les fiches suivantes
				 // moisModif est défini comme le mois suivant le mois suivant de moisCourant
					$moisModif = getMoisSuivant(getMoisSuivant($moisCourant));
				}
			}
         // Extrait l'année et le mois de moisModif
			$numAnnee =substr( $moisModif,0,4);
			$numMois =substr( $moisModif,4,2);

         // Génère une date de modification aléatoire entre le 1er et le 8 du mois
			$datemodif = $numAnnee."-".$numMois."-".rand(1,8); // Génère une date de modification aléatoire

			$nbjustificatifs = rand(0,12); // Génère un nombre aléatoire de justificatifs
			 // Prépare la requête SQL pour insérer une nouvelle fiche de frais
			$req = "insert into fichefrais(idemploye,mois,nbjustificatifs,montantvalide,datemodif,idetat) 
			values ('$idemploye','$moisCourant',$nbjustificatifs,0,'$datemodif','$etat');";
			$pdo->exec($req);
			// Met à jour moisCourant pour le mois précédent
			$moisCourant = getMoisPrecedent($moisCourant); // Passe au mois précédent
           // Incrémente le compteur n
			$n++;
		}
	}
}
// Crée des frais forfait pour chaque fiche de frais
function creationFraisForfait($pdo)
{
	$lesFichesFrais= getLesFichesFrais($pdo); // Récupère toutes les fiches de frais
	$lesIdFraisForfait = getLesIdFraisForfait($pdo); // Récupère tous les IDs des frais forfait
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idemploye = $uneFicheFrais['idemploye'];
		$mois =  $uneFicheFrais['mois'];
		foreach($lesIdFraisForfait as $unIdFraisForfait)
		{
			$idfraisforfait = $unIdFraisForfait['id'];
			if(substr($idfraisforfait,0,1)=="K")
			{
				$quantite =rand(300,1000); // Quantité aléatoire pour frais kilométriques
			}
			else
			{
				$quantite =rand(2,20); // Quantité aléatoire pour autres frais forfaitaires
			}
			$req = "insert into lignefraisforfait(idemploye,mois,idfraisforfait,quantite)
			values('$idemploye','$mois','$idfraisforfait',$quantite);"; // Insère une nouvelle ligne de frais forfait
			$pdo->exec($req);	
		}
	}

}

// Récupère les types de frais hors forfait avec leurs libellés et leurs montants min et max
//Retourne un tableau associatif de frais hors forfait avec leurs libellés et leurs montants minimum et maximum.
function getDesFraisHorsForfait()
{
    // Définition d'un tableau associatif contenant les frais hors forfait
	$tab = array(
				1 => array(
				      "lib" => "repas avec praticien", // Libellé du frais : repas avec praticien
					  "min" => 30, // Montant minimum : 30
					  "max" => 50 ), // Montant maximum : 50
				2 => array(
				      "lib" => "achat de matériel de papèterie",
					  "min" => 10,
					  "max" => 50 ),
				3	=> array(
				      "lib" => "taxi",
					  "min" => 20,
					  "max" => 80 ),
				4 => array(
				      "lib" => "achat d'espace publicitaire",
					  "min" => 20,
					  "max" => 150 ),
				5 => array(
				      "lib" => "location salle conférence",
					  "min" => 120,
					  "max" => 650 ),
				6 => array(
				      "lib" => "Voyage SNCF",
					  "min" => 30,
					  "max" => 150 ),
				7 => array(
					  "lib" => "traiteur, alimentation, boisson",
					  "min" => 25,
					  "max" => 450 ),
				8 => array(
					  "lib" => "rémunération intervenant/spécialiste",
					  "min" => 250,
					  "max" => 1200 ),
				9 => array(
					  "lib" => "location équipement vidéo/sonore",
					  "min" => 100,
					  "max" => 850 ),
				10 => array(
					  "lib" => "location véhicule",
					  "min" => 25,
					  "max" => 450 ),
				11 => array(
					  "lib" => "frais vestimentaire/représentation",
					  "min" => 25,
					  "max" => 450 ) 
		);
	return $tab; // Retourne le tableau contenant les frais hors forfait

}
//MàJ les mots de passe des visiteurs en générant un mot de passe aléatoire de 5 caractères.
function updateMdpVisiteur($pdo)
{
	$req = "select * from employe";
		$res = $pdo->query($req);
		$lesLignes = $res->fetchAll();
		$lettres ="azertyuiopqsdfghjkmwxcvbn123456789";
		foreach($lesLignes as $unEmploye)
		{
			$mdp = "";
			$id = $unEmploye['id'];
			for($i =1;$i<=5;$i++)
			{
            // Génère une lettre aléatoire parmi les lettres disponibles.
				$uneLettrehasard = substr( $lettres,rand(33,1),1);
				$mdp = $mdp.$uneLettrehasard;
			}
			
			$req = "update employe set mdp ='$mdp' where employe.id ='$id' ";
			$pdo->exec($req);
		}


}
// Cette fonction crée des frais hors forfait aléatoires 
// pour chaque fiche de frais.
function creationFraisHorsForfait($pdo)
{
    // Récupère les types de frais hors forfait
	$desFrais = getDesFraisHorsForfait();
	$lesFichesFrais= getLesFichesFrais($pdo);
	
    // Pour chaque fiche de frais
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		// ID de l'employe pour la fiche de frais
		$idemploye = $uneFicheFrais['idemploye']; 
		// Mois de la fiche de frais
		$mois =  $uneFicheFrais['mois'];

		// Génère un nombre aléatoire de frais hors forfait (entre 0 et 5)
		$nbFrais = rand(0,5);
        // Pour chaque frais hors forfait à générer
		for($i=0;$i<=$nbFrais;$i++)
		{
            // Sélectionne aléatoirement un type de frais parmi les types disponibles
			$hasardNumfrais = rand(1,count($desFrais)); 
			$frais = $desFrais[$hasardNumfrais];

			// Récupère les détails du frais
			$lib = $pdo->quote($frais['lib']); // Libellé du frais
			$min= $frais['min']; // Montant minimum du frais
			$max = $frais['max']; // Montant maximum du frais

            // Génère un montant aléatoire pour le frais dans la plage définie
			$hasardMontant = rand($min,$max);

            // Extrait l'année et le mois du mois de la fiche de frais
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);

            // Génère une date aléatoire pour le frais (entre le 1er et le 28 du mois)
			$hasardJour = rand(1,28);
			if(strlen($hasardJour)==1)
			{
				$hasardJour="0".$hasardJour;
			}
			$hasardMois = $numAnnee."-".$numMois."-".$hasardJour;

            // Prépare et exécute la requête SQL pour insérer le frais hors forfait dans la base de données
			$req = "insert into lignefraishorsforfait(idemploye,mois,libelle,date,montant)
			values('$idemploye','$mois',$lib,'$hasardMois',$hasardMontant);";
			$pdo->exec($req);
		}
	}
}
// Cette fonction extrait le mois et l'année d'une date donnée au format jj/mm/aaaa et retourne le format aaaamm.
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

function majFicheFrais($pdo)
{
	//MàJ les fiches de frais avec le montant validé, basé sur les frais hors forfait et forfaitaires.
	$lesFichesFrais= getLesFichesFrais($pdo);
	foreach($lesFichesFrais as $uneFicheFrais)
	{
		$idemploye = $uneFicheFrais['idemploye'];
		$mois =  $uneFicheFrais['mois'];
		$dernierMois = getDernierMois($pdo, $idemploye);

        // Calcule le total des montants des frais hors forfait pour ce visiteur et ce mois.
		$req = "select sum(montant) as cumul from lignefraishorsforfait where lignefraishorsforfait.idemploye 
			= '$idemploye' and lignefraishorsforfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantHorsForfait = $ligne['cumul'];

        // Calcule le total des montants des frais forfaitaires pour ce visiteur et ce mois.
		$req = "select sum(lignefraisforfait.quantite * fraisforfait.montant) as cumul from lignefraisforfait, fraisforfait 
			 where lignefraisforfait.idfraisforfait = fraisforfait.id   
                           and lignefraisforfait.idemploye = '$idemploye' and lignefraisforfait.mois = '$mois' ";
		$res = $pdo->query($req);
		$ligne = $res->fetch();
		$cumulMontantForfait = $ligne['cumul'];
		$montantEngage = $cumulMontantHorsForfait + $cumulMontantForfait;
		$etat = $uneFicheFrais['idetat'];

        // Si l'état de la fiche est "CR" (créé), le montant validé est 0, sinon il est un pourcentage aléatoire du montant engagé.
		if($etat == "CR" )
			$montantvalide = 0;
		else
			$montantvalide = $montantEngage*rand(80,100)/100;
		$req = "update fichefrais set montantvalide =$montantvalide where
		idemploye = '$idemploye' and mois='$mois'";
		$pdo->exec($req);
		
	}
}
?>





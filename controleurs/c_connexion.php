<?php
// Vérifie si l'action est définie, sinon, la définit par défaut à 'demandeConnexion'
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
// Récupère l'action à effectuer
$action = $_REQUEST['action'];

// Utilisation d'un switch pour gérer les différentes actions possibles
switch($action){
	 // Cas où l'action est 'demandeConnexion'
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
        // Le 'break' empêche l'exécution des cases suivantes après 'demandeConnexion'
		break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];

        // Récupère les informations du visiteur correspondant au login et mot de passe fournis
		$employe = $pdo->getInfosEmploye($login,$mdp);

        // Vérifie si les informations de connexion sont correctes
		if(!is_array( $employe)){

            // Si les informations sont incorrectes, ajoute une erreur et inclut les vues d'erreur et de connexion
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else{
            // Si les informations sont correctes, récupère l'ID, le nom et le prénom du visiteur
			$id = $employe['id'];
			$nom =  $employe['nom'];
			$prenom = $employe['prenom'];
            $code = $employe['typeEmploye']; //ici récupère le type d'employé

      // Fonction pour connecter l'utilisateur
			connecter($id,$nom,$prenom,$code);
      
      //Afficher les sommaires correspondants
      if ($code == 'V'){
					 include("vues/v_sommaireVisiteur.php");
      } else {
        include ("vues/v_sommaireComptable.php"); //modif à faire du v_sommaire.php pour les comptables
      }
		}
		break;
	}
    // Cas par défaut où aucune action spécifique n'est demandée
	default :{
		include("vues/v_connexion.php");
        // Le 'break' ici n'est pas nécessaire car c'est la dernière case, mais il est souvent ajouté pour des raisons de cohérence
		break;
	}
}
?>
<!-- Le break est essentiel dans une structure switch pour s'assurer que seule 
 la case correspondant à l'action actuelle est exécutée. 
 Cela garantit que le code fonctionne comme prévu et 
 évite des comportements indésirables.-->
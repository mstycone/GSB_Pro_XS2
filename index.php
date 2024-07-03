<?php
// Configuration pour afficher les erreurs PHP
error_reporting(E_ALL);
ini_set('display_errors',1);

// Inclusion des fichiers nécessaires
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;

// Démarrage de la session
session_start();

// Connexion à la base de données
$pdo = PdoGsb::getPdoGsb();

// Vérification de la connexion de l'utilisateur
$estConnecte = estConnecte();

// Si l'UC n'est pas défini ou si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
}	 
// Récupération de l'UC depuis la requête
$uc = $_REQUEST['uc'];

// Utilisation d'un switch pour gérer les différentes actions possibles
// Inclusion du contrôleur approprié en fonction de l'UC
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");
		break;
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");
		break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");
		break; 
	}
	case 'validerFrais' :{
		include("controleurs/c_validerFrais.php");
		break;
	}
	case 'suivreFrais' :{
		include("controleurs/c_suivreFrais.php");
		break;
	}

}
include("vues/v_pied.php") ;
?>

<!-- Schéma typique de routage pour une application PHP MVC -->



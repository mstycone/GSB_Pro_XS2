<?php 
// Désactive la mise en mémoire tampon de la sortie et 
//nettoie la mémoire tampon précédente
ini_set('output_buffering',0); ob_end_clean(); ?>
 Programme d'actualisation des lignes des tables,  
 cette mise à jour peut prendre plusieurs minutes...
<?php
include("include/fct.inc.php");

/* Modification des paramètres de connexion */

// Obtient la date actuelle
$time = new DateTime('now');
// Définit le mois de début à il y a un an à partir de la date actuelle
$moisDebut = $time->modify('-1 year')->format('Ym');
echo "<br>moisDebut : $moisDebut<br>";
// Paramètres de connexion à la base de données
$serveur='mysql:host=swetdb';
$bdd='dbname=gsb';
$user='operations' ;    		
$mdp='operations123' ;	

/* fin paramètres*/

// Connexion à la base de données
$pdo = new PDO($serveur.';'.$bdd, $user, $mdp);
$pdo->query("SET CHARACTER SET utf8"); 
// Supprime toutes les lignes des tables concernées
$pdo->exec('delete from lignefraishorsforfait;');
$pdo->exec('delete from lignefraisforfait;');
$pdo->exec('delete from fichefrais;');

// Définit le temps d'exécution maximal à 0 (pas de limite)
set_time_limit(0);
try {

// Appelle les fonctions pour créer et mettre à jour les données
creationFichesFrais($pdo, $moisDebut);
creationFraisForfait($pdo);
creationFraisHorsForfait($pdo);
majFicheFrais($pdo);
clotureFichesMoisPrecedent($pdo); //Clôture toutes les fiches du mois écoulé

} catch (PDOException $e) {
	// Capture et affiche les erreurs PDO
	echo "PDOException<hr>";
	echo $e;
	echo "<hr>";
} catch (Exception $e) {
	// Capture et affiche toutes les autres exceptions
	echo $e;
}
echo "<hr>FIN";
?>

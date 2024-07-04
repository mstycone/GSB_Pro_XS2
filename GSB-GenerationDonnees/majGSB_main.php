<?php ini_set('output_buffering',0); ob_end_clean(); ?>
 Programme d'actualisation des lignes des tables,  
 cette mise à jour peut prendre plusieurs minutes...
<?php
include("include/fct.inc.php");

/* Modification des paramètres de connexion */
$time = new DateTime('now');
$moisDebut = $time->modify('-1 year')->format('Ym');
echo "<br>moisDebut : $moisDebut<br>";
$serveur='mysql:host=swetdb';
$bdd='dbname=gsb';
$user='operations' ;    		
$mdp='operations123' ;	

/* fin paramètres*/

$pdo = new PDO($serveur.';'.$bdd, $user, $mdp);
$pdo->query("SET CHARACTER SET utf8"); 
$pdo->exec('delete from lignefraishorsforfait;');
$pdo->exec('delete from lignefraisforfait;');
$pdo->exec('delete from fichefrais;');

set_time_limit(0);

try {
	creationFichesFrais($pdo, $moisDebut);
	creationFraisForfait($pdo);
	creationFraisHorsForfait($pdo);
	majFicheFrais($pdo);
} 
catch (PDOException $e) {
	echo "PDOException<hr>";
	echo $e;
	echo "<hr>";
}
catch (Exception $e) {
	echo $e;
}

echo "<hr>FIN";
?>

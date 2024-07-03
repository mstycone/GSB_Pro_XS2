
<ul>
<?php
       // Récupère l'identifiant du visiteur depuis la session
	  $prenom = $_SESSION['prenom'];
        $nom = $_SESSION['nom'];
        
      echo "<span style='color: white; font-size:bold;'>bonjour $prenom $nom, vous vous êtes déconnecté de votre session.</span> <br> <span style='color: white; font-size:bold;'>Confirmer votre <a href='index.php?uc=connexion' style='color: rgb(0,85,227); text-decoration:none;'>Deconnexion</a></span> <br>"; 
      echo "<span style='color: white; font-size:bold;'>Redirection vers la page de connexion ...";
      header('Refresh: 7; URL=index.php?uc=connexion');
?>
</ul>

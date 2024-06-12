
<ul>
<?php
       // Récupère l'identifiant du visiteur depuis la session
	  $id = $_SESSION['idvisiteur'];
        
      echo "bonjour $id <a href='Deconnexion.php' >Deconnexion</a>";

?>
</ul>

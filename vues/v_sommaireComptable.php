﻿    <!-- Division pour le sommaire -->
  <!-- À modifier selon les caractéristiques du comptable-->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2></h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  visiteur :<br>
            <!-- Affichage des informations sur le visiteur -->
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
           <li class="smenu">
            <!-- Lien pour la saisie de la fiche de frais -->
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
            <!-- Lien pour la consultation des fiches de frais -->
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
 	   <li class="smenu">
            <!-- Lien pour la déconnexion -->
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    
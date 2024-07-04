    <!-- Division pour le sommaire -->
  <!-- À adapter pour les comptables -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2></h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  Comptable :<br>
            <!-- Affichage des informations sur le comptable -->
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
           <li class="smenu">
            <!-- Lien pour la saisie de la fiche de frais -->
              <a href="index.php?uc=suivreFrais&action=selectionnerVisiteur" title="Suivre le paiement fiche de frais ">Suivre le paiement fiche de frais</a>
           </li>
           <li class="smenu">
            <!-- Lien pour la consultation des fiches de frais -->
              <a href="index.php?uc=validerFrais&action=" title="Valider fiches de frais">Valider fiches de frais</a>
           </li>
 	   <li class="smenu">
            <!-- Lien pour la déconnexion -->
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    
    
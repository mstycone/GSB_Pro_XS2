    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2></h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  comptable :<br>
            <!-- Affichage des informations sur le comptable -->
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
           <li class="smenu">
            <!-- Lien pour valider la fiche de frais -->
              <a href="index.php?uc=gererFrais&action=validerCreationFrais" title="Valider fiche de frais ">Valider fiche de frais</a>
           </li>
           <li class="smenu">
            <!-- Lien pour le suivie du paiement des fiches de frais -->
              <a href="index.php?uc=gererFrais&action=validerMajFraisForfait" title="Suivre paiement fiches de frais">Suivre paiement fiches de frais</a>
           </li>
 	   <li class="smenu">
            <!-- Lien pour la déconnexion -->
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    
﻿  <div id="contenu">
    <h2>Mes fiches de frais</h2>
    <h3>Mois à sélectionner : </h3>
    <!-- pointe vers index.php -->
    <!-- 'uc=' Use Case : Indique la partie du controleur à appeler-->
    <!-- 'action=' action a effectuée-->
    <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
      <div class="corpsForm">  

        <p>
          <label for="lstMois" accesskey="n">Mois : </label>
          <select id="lstMois" name="lstMois">
           <!-- <option value="">--À sélectionner--</option> -->
            <?php
              // Parcourt tous les mois disponibles
              foreach ($lesMois as $unMois)
              {
              // Récupération des informations sur le mois
              $mois = $unMois['mois'];
              $numAnnee =  $unMois['numAnnee'];
              $numMois =  $unMois['numMois'];
              // Vérifie si ce mois est celui sélectionné par défaut
              if($mois == $moisASelectionner){
            ?>
            <option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
            <?php 
              }
              else{ 
            ?>
            <option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
            <?php 
                }
              }
            ?>    
                
          </select>
        </p>
      </div>
      <div class="piedForm">
        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
      </div>
        
    </form>
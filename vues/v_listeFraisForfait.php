<div id="contenu">
  <h2>Renseigner ma fiche de frais du mois <?php echo $numMois."-".$numAnnee ?></h2>
         
  <!-- 'action=' envoie les données à index.php avec les paramètres --> 
  <!-- 'uc=' Cela signifie qu'il sera dirigé vers la partie du code qui gère la validation ou la mise à jour des frais forfaitisés -->
  <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
    <div class="corpsForm">
          
      <fieldset>
        <legend>Eléments forfaitisés</legend>
        <?php
        // Parcourt les frais forfaitisés pour les afficher dans le formulaire
        foreach ($lesFraisForfait as $unFrais)
        {
        // Récupère les informations sur le frais forfaitisé
        $idFrais = $unFrais['idfrais'];
        $libelle = $unFrais['libelle'];
        $quantite = $unFrais['quantite'];
        ?>
        <p>
          <label for="idFrais"><?php echo $libelle ?></label>
          <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais?>]" size="10" maxlength="5" value="<?php echo $quantite?>" >
        </p>
          
        <?php
          }
        ?>
        
      </fieldset>
    </div>

    <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
    </div>    
  </form>
  
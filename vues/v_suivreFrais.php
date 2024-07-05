
  <h3>Détails de la fiche de frais : </h3>
  <h3> Visiteur : <?php echo  $nom." ".$prenom ?> </h3>
  <h3> Mois : <?php echo $numMois."-".$numAnnee?> </h3>
  <div class="encadre">
    <p>
      Etat : <?php echo $libEtat?> depuis le <?php echo $datemodif?> <br> Montant validé : <?php echo $montantvalide?>
                                
    </p>
    <table class="listeLegere">
      <caption>Eléments forfaitisés </caption>
        <tr>
          <?php

            // Parcourt les frais forfaitisés pour afficher les libellés en en-tête du tableau
            foreach ( $lesFraisForfait as $unFraisForfait ) 
            {
            $libelle = $unFraisForfait['libelle'];
          ?>	
          <th> <?php echo $libelle; ?> </th> 
          <?php
            }
          ?>
        </tr>
        <tr>
          <?php
            // Parcourt les frais forfaitisés pour afficher les quantités correspondantes
            foreach (  $lesFraisForfait as $unFraisForfait  ) 
            {
            $quantite = $unFraisForfait['quantite'];
          ?>
          <td class="qteForfait"><?php echo $quantite?> </td>
          <?php
            }
          ?>	  
        </tr>
    </table>
    <table class="listeLegere">
      <caption>Descriptif des éléments hors forfait -<?php echo $nbjustificatifs ?> justificatifs reçus - </caption>
        <tr>
          <th class="date">Date</th>
          <th class="libelle">Libellé</th>
          <th class='montant'>Montant</th>                
        </tr>
        <?php      
          // Parcourt les frais hors forfait pour afficher les détails
          foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
          {
          // Récupère la date, le libellé et le montant de chaque frais hors forfait
          $date = $unFraisHorsForfait['date'];
          $libelle = $unFraisHorsForfait['libelle'];
          $montant = $unFraisHorsForfait['montant'];
        ?>
          <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $libelle ?></td>
            <td><?php echo $montant ?></td>
          </tr>
        <?php 
          }
        ?>
    </table>
    <!-- Actions possible en fonction de l'état de la fiche de frais --> 
    
      <form action="index.php?uc=suivreFrais&action=misePaiement" method="post">
        <input type="hidden" name="lstVisiteur" value="<?php echo $leVisiteur; ?>">
        <input type="hidden" name="lstMois" value="<?php echo $leMois ; ?>">
        <input type="submit" value="Mettre en paiement" size="40">
      </form>
      <form action="index.php?uc=suivreFrais&action=remboursee" method="post">
        <input type="hidden" name="lstVisiteur" value="<?php echo $leVisiteur; ?>">
        <input type="hidden" name="lstMois" value="<?php echo $leMois ; ?>">
        <input type="submit" action="index.php?uc=suivreFrais&action=remboursee" value="Remboursée" size="40">
      </form>
    
  </div>
</div>
 
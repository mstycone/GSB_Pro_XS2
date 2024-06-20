
<h3>Fiche de frais du mois <?php echo $numMois."-".$numAnnee?> : 
    </h3>
    <div class="encadre">
    <p>
        etat : <?php echo $libEtat?> depuis le <?php echo $datemodif?> <br> Montant validé : <?php echo $montantvalide?>
              
                     
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
			<th> <?php echo $libelle?></th>
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
  	   <caption>Descriptif des éléments hors forfait -<?php echo $nbjustificatifs ?> justificatifs reçus -
       </caption>
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
    <form action="index.php?uc=etatfrais&action=mettrePaiement" method="post">
            <input type="hidden" name="idemploye" value="<?php echo $idemploye; ?>">
            <input type="hidden" name="mois" value="<?php echo $mois; ?>">
            <input type="submit" value="Valide et Mettre en paiement" formaction="index.php?uc=etatfrais&action=mettrePaiement">
            <input type="submit" value="Marqué comme payéé" formaction="index.php?uc=etatfrais&action=fichePaye">
    </form>
  </div>
  </div>
 














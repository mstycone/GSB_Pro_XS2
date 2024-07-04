
  <table class="listeLegere">
    <caption>Descriptif des éléments hors forfait</caption>
    <tr>
      <th class="date">Date</th>
      <th class="libelle">Libellé</th>  
      <th class="montant">Montant</th>  
      <th class="action">&nbsp;</th>              
    </tr>
            
    <?php    
      // Parcourt les frais hors forfait pour les afficher dans le tableau
      foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
      {
      // Récupère les informations sur le frais hors forfait
      $libelle = $unFraisHorsForfait['libelle'];
      $date = $unFraisHorsForfait['date'];
      $montant=$unFraisHorsForfait['montant'];
      $id = $unFraisHorsForfait['id']; // Identifiant du frais hors forfait
    ?>		
    <tr>
      <!-- Affiche la date, le libellé et le montant du frais hors forfait -->
      <td> <?php echo $date ?></td>
      <td><?php echo $libelle ?></td>
      <td><?php echo $montant ?></td>
      <!-- Colonne avec le lien pour supprimer le frais hors forfait -->
      <!-- pointe vers index.php -->
      <!-- 'uc=' Use Case: Indique la partie du controleur à appeler-->
      <!-- 'action=' action a effectuée-->
      <!-- 'idFrais=' : Transmet l'identifiant du frais à supprimer-->
      <!-- Lorsque ce lien est cliqué, il envoie une requête à index.php avec les paramètres spécifiés -->
      <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
        onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
    </tr>
    <!-- confirm('Voulez-vous vraiment supprimer ce frais?') : Affiche une boîte de dialogue de 
    confirmation avec le message spécifié. Si l'utilisateur clique sur "OK", 
    la fonction renvoie true, sinon false.-->
    <!-- Le return permet de renvoyer le résultat de la fonction confirm() au navigateur. 
    Si l'utilisateur clique sur "OK", le lien se comporte normalement et 
    la suppression est effectuée. Sinon, rien ne se passe -->
    <?php		       
      }
    ?>	  
                                            
  </table>
  <!-- Formulaire pour ajouter un nouvel élément hors forfait -->
  <!-- pointe vers index.php -->
  <!-- 'uc=' Use Case : Indique la partie du controleur à appeler-->
  <!-- 'action=' action a effectuée-->
  <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
    <div class="corpsForm">     
      <fieldset>
        <legend>Nouvel élément hors forfait</legend>
        <p>
          <label for="txtDateHF">Date (jj/mm/aaaa): </label>
          <input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
        </p>
        <p>
          <label for="txtLibelleHF">Libellé</label>
          <input type="text" id="txtLibelleHF" name="libelle" size="70" maxlength="256" value="" />
        </p>
        <p>
          <label for="txtMontantHF">Montant : </label>
          <input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" />
        </p>
      </fieldset>
    </div>
    <div class="piedForm">
      <p>
        <input id="ajouter" type="submit" value="Ajouter" size="20" />
        <input id="effacer" type="reset" value="Effacer" size="20" />
      </p> 
    </div>
        
  </form>
</div>
  


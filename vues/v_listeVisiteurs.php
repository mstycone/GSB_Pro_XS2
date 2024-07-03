<div id="contenu">
    <h2>Suivi des fiches de frais</h2>
    <h3>Choisir un visiteur : </h3>
    <!-- pointe vers index.php -->
    <!-- 'uc=' Use Case : Indique la partie du controleur à appeler-->
    <!-- 'action=' action a effectuée-->
    <form action="index.php?uc=suivreFrais&action=afficheFicheFraisAValider" method="post">
        <div class="corpsForm">
         
            <p>
	 
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" onchange="this.form.submit()">
                    <!-- la ƒ onchange soumet automatiquement le formulaire une fois 
                    le visiteur sélectionné. Affiche directement le résultat sans valider. 
                    Meilleur ergonomie-->
                    <?php
                        // Parcourt tous les visiteurs disponibles
                        foreach ($lesVisiteurs as $unVisiteur) {

                            // Récupération des informations sur le visiteur 
                            $id = $unVisiteur['id'];
                            $nom =  $unVisiteur['nom'];
                            $prenom =  $unVisiteur['prenom'];
                            
                            // Vérifie si ce visiteur est celui sélectionné par défaut
                            if($id == $visiteurASelectionner){
                            ?>
                            <option selected value="<?php echo $id ?>"><?php echo  $nom."/".$prenom ?> </option>
                            <?php 
                            }
                            else{ ?>
                            <option value="<?php echo $id ?>"><?php echo  $nom."/".$prenom ?> </option>
                            <?php 
                            }			
                        }
                    ?>    
                </select>
                    
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois">
                    <?php
                        // Parcourt tous les mois disponibles
                        foreach ($lesMois as $unMois) {
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
                            else{ ?>
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

<div id="contenu">
    <h2>Suivi des fiches de frais</h2>
    <form action="index.php?uc=etatFrais&action=voirFicheFrais" method="post">
        <label for="lstVisiteur">Choisir un visiteur :</label>
        <select id="lstVisiteur" name="lstVisiteur">
            <?php foreach ($lesVisiteurs as $unVisiteur) { ?>
                <option value="<?php echo $unVisiteur['id']; ?>"><?php echo $unVisiteur['nom'] . ' ' . $unVisiteur['prenom']; ?></option>
            <?php } ?>
        </select>
        <label for="lstMois">Choisir un mois :</label>
        <select id="lstMois" name="lstMois">
            <?php foreach ($lesMois as $unMois) { ?>
                <option value="<?php echo $unMois['mois']; ?>"><?php echo $unMois['numMois'] . '/' . $unMois['numAnnee']; ?></option>
            <?php } ?>
        </select>
        <input type="submit" value="Valider">
    </form>
</div>

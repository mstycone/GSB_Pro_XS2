<div class ="erreur">
	<ul>
		<?php 
			// Parcourt chaque erreur présente dans le tableau 'erreurs' de la requête
			foreach($_REQUEST['erreurs'] as $erreur)
			{
				echo "<li>$erreur</li>";
			}
		?>
	</ul>
</div>

<?php

class Vue{

	/**
	 * Affiche les vues
	 * @param string $vueCentrale La vue à charger
	 * @param array $vars Le tableau des variables dont la vue à besoin
	 */
	public function chargerVue($vue, array $vars){
		extract($vars, EXTR_PREFIX_ALL, 'v'); // Toutes les variables $var pour la vue deviennent $v_var
		include '/vues/header.php';
		include '/vues/' . $vue . '.php';
		include '/vues/footer.php';
	}

}
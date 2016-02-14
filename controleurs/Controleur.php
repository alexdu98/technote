<?php

/**
 * Classe Controleur
 * @author Alexandre CULTY
 * @version 1.0
 * @abstract
 */
abstract class Controleur{

	static public function construct($controleur){
		if($controleur == 'admin')
			return new Admin();
		else
			return new Main();
	}

	/**
	 * Charge le controleur de $page
	 * @abstract
	 * @param string $page
	 * @param string $action
	 * @param array $param
	 */
	abstract public function chargerControleurPage($page, $action, $param);

	public function chargerVues($vueCentrale){
		include '/vues/header.php';
		include $vueCentrale;
		include '/vues/footer.php';
	}

	/**
	 * Retourne la vue de la page 404
	 */
	protected function _404(){
		return '/vues/404.php';
	}

	/**
	 * Renvoi true si $methode est défini pour la première fois dans $classe, false si elle est déjà présente dans parent::
	 * @param string $classe
	 * @param string $methode
	 * @return bool
	 */
	protected function isFirstDefinition($classe, $methode){
		if(method_exists($classe, $methode)){
			$parent = get_parent_class($classe);
			if($parent !== false)
				return !method_exists($parent, $methode);
			return true;
		}
		return false;
	}

}
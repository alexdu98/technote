<?php

/**
 * Classe Controleur
 */
class Controleur{

	/**
	 * Charge le controleur de la page demandé
	 * @param Admin|Main L'instance du controleur
	 * @param string $page
	 * @param string $action
	 * @param array $param
	 */
	public function chargerControleurPage($controleur, $page, $action, $param){
		if(method_exists($controleur, $page)){
			$controleur->$page($action, $param);
		}
		elseif($page == '_403'){
			$vueCentrale = $this->_403();
			$this->ChargerVues($vueCentrale, array());
		}
		else{
			$vueCentrale = $this->_404();
			$this->ChargerVues($vueCentrale, array());
		}
	}

	/**
	 * Affiche les vues
	 * @param string $vueCentrale La vue à charger
	 * @param array $vars Le tableau des variables dont la vue à besoin
	 */
	public function chargerVues($vueCentrale, array $vars){
		include '/vues/header.php';
		include $vueCentrale;
		include '/vues/footer.php';
	}

	/**
	 * Retourne la vue de la page 403
	 * @return string La vue de la page 403
	 */
	protected function _403(){
		return '/vues/403.php';
	}

	/**
	 * Retourne la vue de la page 404
	 * @return string La vue de la page 404
	 */
	protected function _404(){
		return '/vues/404.php';
	}

}
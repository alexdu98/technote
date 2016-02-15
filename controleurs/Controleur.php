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
			$vueCentrale = $controleur->$page($action, $param);
			$this->ChargerVues($vueCentrale);
		}
		elseif($page == '_403'){
			$vueCentrale = $this->_403();
			$this->ChargerVues($vueCentrale);
		}
		else{
			$vueCentrale = $this->_404();
			$this->ChargerVues($vueCentrale);
		}
	}

	/**
	 * Affiche les vues
	 * @param $vueCentrale
	 */
	public function chargerVues($vueCentrale){
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
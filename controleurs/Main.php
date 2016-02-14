<?php

/**
 * Classe Main
 * @author Alexandre CULTY
 * @version 1.0
 */
class Main extends Controleur{

	/**
	 * Charge le controleur de $page
	 * @param string $page
	 * @param string $action
	 * @param array $param
	 */
	public function chargerControleurPage($page, $action, $param){
		if(parent::isFirstDefinition(__CLASS__, $page)){
			$GLOBALS['page'] = $page;
			$vueCentrale = $this->$page($action, $param);
			parent::ChargerVues($vueCentrale);
		}
		else{
			$GLOBALS['page'] = '404';
			$vueCentrale = parent::_404();
			parent::ChargerVues($vueCentrale);
		}
	}

	/**
	 * @return string (la vue de l'accueil)
	 */
	public function accueil($action, $param){
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$tn = $technoteDAO->getAll();
				return '/vues/accueil.php';
			case 'add':
			case 'edit':
			case 'del':
		}
	}

	public function membre($action, $param){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
			case 'add':
				return '/vues/inscription.php';
			case 'edit':
			case 'del':
		}
	}

}
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
			$vueCentrale = $this->$page();
			parent::ChargerVues($vueCentrale);
		}
		else{
			$GLOBALS['page'] = '404';
			$vueCentrale = parent::_404();
			parent::ChargerVues($vueCentrale);
		}
	}



	public function index(){
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		$tn = $technoteDAO->getAll();
		return '/vues/index.php';
	}

}
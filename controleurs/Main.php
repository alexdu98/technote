<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $param){
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'add':
			case 'edit':
			case 'del':
			default:
				$tn = $technoteDAO->getAll();
				return '/vues/accueil.php';
		}
	}

	public function membre($action, $param){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'add':
				return '/vues/inscription.php';
			case 'edit':
			case 'del':
			default:

		}
	}

}
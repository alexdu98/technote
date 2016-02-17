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
			parent::chargerVues('/vues/accueil.php', array());
		}
	}

	public function membre($action, $param){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'add':
				if(!empty($_POST)){
					if(($res = Membre::checkAdd($_POST))){
						$membre = new Membre(array(
							'id_membre' => DAO::UNKNOWN_ID,
							'pseudo' => $_POST['pseudo'],
							'email' => $_POST['email'],
							'password' => $_POST['password'],
							'id_groupe' => 1,
							'bloquer' => 0
						));
						$membreDAO->save($membre);
					}

				}
				parent::chargerVues('/vues/inscription.php', array());
			case 'edit':
			case 'del':
			default:

		}
	}

}
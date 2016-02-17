<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $param){
		$vars = array();
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$tn = $technoteDAO->getAll();
				parent::chargerVues('/vues/accueil.php', $vars);
				break;
			case 'add':
				break;
			case 'edit':
				break;
			case 'del':
				break;
			default:
				parent::chargerVues('/vues/404.php', $vars);
		}
	}

	public function membre($action, $param){
		$vars = array();
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				break;
			case 'add':
				if(!empty($_POST)){
					if(($res = Membre::checkAdd($_POST)) === true){
						$membre = new Membre(array(
							'id_membre' => DAO::UNKNOWN_ID,
							'pseudo' => $_POST['pseudo'],
							'email' => $_POST['email'],
							'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 12)),
							'id_groupe' => 3,
							'bloquer' => 0
						));
						if($membreDAO->save($membre))
							$vars['res'] = array('success' => true, 'msg' => 'Inscription réussie');
						else
							$vars['res'] = array('success' => false, 'msg' => 'Erreur BDD');
					}
					else
						$vars['res'] = array('success' => false, 'msg' => $res);
				}
				parent::chargerVues('/vues/inscription.php', $vars);
				break;
			case 'edit':
				break;
			case 'del':
				break;
			default:
				parent::chargerVues('/vues/404.php', $vars);
		}
	}

	public function connexion($action, $param){
		$vars = array();
		if(!empty($_POST)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if(($res = $membreDAO->checkUser($_POST['pseudo'], $_POST['password'])) !== false){
				var_dump($res);
			}
			else
				$vars['res'] = array('success' => false, 'msg' => 'Couple login / mot de passe invalide');
			parent::chargerVues('/vues/accueil.php', $vars);
		}
	}

}
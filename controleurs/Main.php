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
				$this->vue->chargerVue('accueil_' . $action, $vars);
				break;
			case 'add':
				//break;
			case 'edit':
				//break;
			case 'drop':
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function membre($action, $param){
		$vars = array();
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				if($_SESSION['connecte']){
					$this->vue->chargerVue('membre_' . $action, $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'add':
				if(!$_SESSION['connecte']){
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
						}else
							$vars['res'] = array('success' => false, 'msg' => $res);
					}
					$this->vue->chargerVue('membre_' . $action, $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'edit':
				//break;
			case 'drop':
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function connexion($action, $param){
		$vars = array();
		if(!empty($_POST)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if(($res = $membreDAO->checkUser($_POST['pseudo'], $_POST['password'])) !== false){
				$_SESSION['user'] = $res;
				if(!$_SESSION['user']->bloquer){
					$_SESSION['connecte'] = true;
					if(!empty($_POST['autoConnexion']) && $_POST['autoConnexion'] == 'on'){
						$cle = Token::createToken();
						$token = new Token(array(
							'id_token' => DAO::UNKNOWN_ID,
							'cle' => $cle,
							'id_membre' => $_SESSION['user']->id_membre,
							'date_expiration' => 'NOW()'
						));
						$tokenDAO = new TokenDAO(BDD::getInstancePDO());
						$tokenDAO->save($token);
						setcookie('token', $cle, time() + DUREE_COOKIE_AUTOCONNECT_SEC);
					}
					header('Location: /membre');
					exit();
				}
				else
					$vars['res'] = array('success' => false, 'msg' => 'Votre compte a été bloqué, contactez un admin');
			}
			else
				$vars['res'] = array('success' => false, 'msg' => 'Couple login / mot de passe invalide');
			$this->vue->chargerVue('accueil_' . $action, $vars);
		}
	}

	public function deconnexion($action, $param){
		session_destroy();
		setcookie('token', '', time() - 10);
		header('Location: /');
		exit();
	}

}
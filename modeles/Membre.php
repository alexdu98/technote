<?php

class Membre extends TableObject{

	public function getProfile(){
		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$res['nbTokenActif'] = $tokenDAO->getNbActif($this->id_membre);
		$res['tokenActif'] = $tokenDAO->getActif($this->id_membre);
		$res['nbTechnoteRedige'] = $technoteDAO->getNbRedige($this->id_membre);
		$res['nbCommentaireRedige'] = $commentaireDAO->getNbRedige($this->id_membre);
		$res['nbQuestionRedige'] = $questionDAO->getNbRedige($this->id_membre);
		$res['nbReponseRedige'] = $reponseDAO->getNbRedige($this->id_membre);
		$res['actions'] = $actionDAO->getLast($this->id_membre);
		return $res;
	}

	static public function connexion($param){
		$pseudo = !empty($param['pseudo']) ? $param['pseudo'] : NULL;
		$password = !empty($param['password']) ? $param['password'] : NULL;
		$autoConnexion = !empty($param['autoConnexion']) ? $param['autoConnexion'] : NULL;

		if(empty($pseudo))
			return array('success' => false, 'message' => 'Le pseudo n\'est pas renseigné');
		elseif(empty($password))
			return array('success' => false, 'message' => 'Le mot de passe n\'est pas renseigné');

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($pseudo, $password) === true){
			if(($res = $membreDAO->connexion($pseudo)) !== false){
				if(!$res->bloquer){
					$_SESSION['user'] = $res;
					$jeton = '';
					if($autoConnexion == 'on'){
						Token::createToken();
						$jeton = ' avec jeton';
					}
					$actionDAO = new ActionDAO(BDD::getInstancePDO());
					$action = new Action(array(
						'id_action' => DAO::UNKNOWN_ID,
						'libelle' => "Connexion$jeton ($_SERVER[REMOTE_ADDR])",
						'id_membre' => $_SESSION['user']->id_membre
					));
					$actionDAO->save($action);
					return array('success' => true, 'message' => '');
				}
				return array('success' => false, 'message' => 'Votre compte a été bloqué');
			}
			return array('success' => false, 'message' => 'Problème de BDD');
		}
		return array('success' => false, 'message' => 'Couple login / mot de passe incorrect');
	}

	static public function checkAdd(&$param){
		if(!empty($param['pseudo']) && !empty($param['email']) && !empty($param['password']) && !empty($param['passwordConfirm']) && !empty($param['conditions']) && !empty($param['g-recaptcha-response'])){
			if(($res = self::checkPseudo($param['pseudo'])) === true)
				if(($res = self::checkEmail($param['email'])) === true)
					if(($res = self::checkPass($param['password'], $param['passwordConfirm'])) === true)
						if(($res = self::checkConditions($param['conditions'])) === true){
							$captcha = new Captcha();
							if(($res = $captcha->check($param['g-recaptcha-response'])) === true)
								return true;
						}
		}
		else
			return 'Tous les champs ne sont pas renseignés';
		return $res;
	}

	static public function checkEdit(&$param){
		if(!empty($param['email'])){
			if(($res = self::checkEmail($param['email'])) === true)
				return true;
		}
		elseif(!empty($param['passwordNow']) && !empty($param['passwordNew']) && !empty($param['passwordNewConfirm'])){
			if(($res = self::checkPassUser($param['passwordNow'])) === true)
				if(($res = self::checkPass($param['passwordNew'], $param['passwordNewConfirm'])) === true)
					return true;
		}
		else
			return 'Tous les champs ne sont pas renseignés';
		return $res;
	}

	static public function checkLostPass(&$param){
		if(!empty($param['passwordNew']) && !empty($param['passwordNewConfirm']) && !empty($param['g-recaptcha-response'])){
			if(($res = self::checkPass($param['passwordNew'], $param['passwordNewConfirm'])) === true){
				$captcha = new Captcha();
				if(($res = $captcha->check($param['g-recaptcha-response'])) === true)
					return true;
			}
		}
		else
			return 'Tous les champs ne sont pas renseignés';
		return $res;
	}

	static public function checkPassUser($pass){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($_SESSION['user']->pseudo, $pass) !== false)
			return true;
		return 'Le mot de passe actuel est incorrect';
	}

	static public function checkPseudo($pseudo){
		if(!empty($pseudo)){
			if(mb_strlen($pseudo) >= 3 && mb_strlen($pseudo) <= 31){
				if(preg_match('#[a-zA-Z0-9]+#', $pseudo)){
					return true;
				}
				return 'Le pseudo ne respecte pas les règles de composition (alphanumérique)';
			}
			return 'Le pseudo ne respecte pas les règles de longueur (3 à 31 caractères)';
		}
		return 'Le pseudo n\'est pas renseigné';
	}

	static public function checkEmail($email){
		if(!empty($email)){
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
				return true;
			return 'L\'email n\'est pas valide';
		}
		return 'L\'email n\'est pas renseigné';
	}

	static public function checkPass($pass, $passConfirm){
		if($pass == $passConfirm){
			if(mb_strlen($pass) >= 6 && mb_strlen($pass) <= 32){
				if(preg_match('#.*[a-zA-Z]+.*[0-9]+.*|.*[0-9]+.*[a-zA-Z]+.*#', $pass)){
					return true;
				}
				return 'Le mot de passe ne respecte pas les règles de composition (au moins un chiffre et une lettre)';
			}
			return 'Le mot de passe ne respecte pas les règles de longueur (6 à 32 caractères)';
		}
		return 'Le mot de passe et sa confirmation ne correspondent pas';
	}

	static public function checkConditions($conditions){
		if($conditions == 'on')
			return true;
		return 'Les conditions d\'utilisation ne sont pas acceptées';
	}

	public function lostPass(){
		$cle = hash('sha256', uniqid(rand(), true) . SALT_RESET_PASS);
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$membre = new membre(array(
			'id_membre' => $this->id_membre,
			'cle_reset_pass' => $cle
		));
		$membreDAO->save($membre);
		$param = array(
			'pseudo' => $this->pseudo,
			'cle' => $cle
		);
		$mail = new Mail($this->email, '[Technote.dev] Oubli de mot de passe', 'mail_lostPass.php', $param);
		return $mail->sendMail();
	}

}
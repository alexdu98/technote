<?php

class Membre extends TableObject{

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

	static public function checkContact(&$param){
		if((!$_SESSION['user'] && !empty($param['pseudo']) && !empty($param['g-recaptcha-response']) || $_SESSION['user']) && !empty($param['sujet']) && !empty($param['message'])){
			if(($res = self::checkSujet($param['sujet'])) === true)
				if(($res = self::checkMessage($param['message'])) === true)
					if(!$_SESSION['user']){
						if(($res = self::checkPseudo($param['pseudo'])) !== true)
							goto erreur;
						$captcha = new Captcha();
						if(($res = $captcha->check($param['g-recaptcha-response'])) === true)
							return true;
						else
							goto erreur;
					}
		}
		else
			return 'Tous les champs ne sont pas renseignés';
		erreur:
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

	static public function checkMessage($message){
		if(mb_strlen(strip_tags($message)) == mb_strlen($message)){
			if(mb_strlen($message) >= 8 && mb_strlen($message) <= 2047)
				return true;
			return 'Le message ne respecte pas les règles de longueur (8 à 2047 caractères)';
		}
		return 'Les balises HTML sont interdites dans le message (un espace est nécessaire après un <)';
	}

	static public function checkSujet($sujet){
		if(mb_strlen(strip_tags($sujet)) == mb_strlen($sujet)){
			if(mb_strlen($sujet) >= 3 && mb_strlen($sujet) <= 63)
				return true;
			return 'Le sujet ne respecte pas les règles de longueur (3 à 63 caractères)';
		}
		return 'Les balises HTML sont interdites dans le sujet (un espace est nécessaire après un <)';
	}

	static public function checkPassUser($pass){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($_SESSION['user']->pseudo, $pass) !== false)
			return true;
		return 'Le mot de passe actuel est incorrect';
	}

	static public function checkPseudo($pseudo){
		if(mb_strlen($pseudo) >= 3 && mb_strlen($pseudo) <= 31){
			if(preg_match('#[a-zA-Z0-9]+#', $pseudo)){
				return true;
			}
			return 'Le pseudo ne respecte pas les règles de composition (alphanumérique)';
		}
		return 'Le pseudo ne respecte pas les règles de longueur (3 à 31 caractères)';
	}

	static public function checkEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
		return 'L\'email n\'est pas valide';
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

	static public function contact($param){
		$pseudo = !$_SESSION['user'] ? $param['pseudo'] : $_SESSION['user']->pseudo;
		$param = array(
			'pseudo' => 'Admin',
			'pseudoExpediteur' => $pseudo,
			'sujet' => $param['sujet'],
			'message' => nl2br($param['message'])
		);
		$mail = new Mail(DESTINATAIRE_MAIL_CONTACT, '[Technote.dev] Contact', 'mail_contact.php', $param);
		return $mail->sendMail();
	}

}
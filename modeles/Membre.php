<?php

class Membre extends TableObject{

	static public function checkAdd($param){
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

	static public function checkEdit($param){
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
			return 'Le pseudo ne respecte pas les règles de composition';
		}
		return 'Le pseudo ne respecte pas les règles de longueur';
	}

	static public function checkEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
		return 'L\'email n\'est pas valide';
	}

	static public function checkPass($pass, $passConfirm){
		if($pass == $passConfirm){
			if(mb_strlen($pass) >= 6 && mb_strlen($pass) <= 32){
				if(preg_match('#.*[a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z]+.*#', $pass)){
					return true;
				}
				return 'Le mot de passe ne respecte pas les règles de composition';
			}
			return 'Le mot de passe ne respecte pas les règles de longueur';
		}
		return 'Le mot de passe et sa confirmation ne correspondent pas';
	}

	static public function checkConditions($conditions){
		if($conditions == 'on')
			return true;
		return 'Les conditions d\'utilisation ne sont pas acceptées';
	}

	public function lostPass(){
		$cle = hash('sha512', uniqid(rand(), true) . SALT_RESET_PASS);
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
		$mail = new Mail($this->email, 'Oubli de mot de passe', 'mail_lostPass.php', $param);
		return $mail->sendMail();
	}

}
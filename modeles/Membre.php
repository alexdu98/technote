<?php

class Membre extends TableObject{

	static public function checkAdd($param){
		if(($res = self::checkPseudo($param['pseudo'])) === true)
			if(($res = self::checkEmail($param['email'])) === true)
				if(($res = self::checkPass($param['password'], $param['passwordConfirm'])) === true)
					if(($res = self::checkConditions($param['conditions'])) === true){
						$captcha = new Captcha();
						if(($res = $captcha->check($param['g-recaptcha-response'])) === true)
							return true;
					}
		return $res;
	}

	static private function checkPseudo($pseudo){
		if(mb_strlen($pseudo) >= 3 && mb_strlen($pseudo) <= 31){
			if(preg_match('#[a-zA-Z0-9]+#', $pseudo)){
				return true;
			}
			return 'Le pseudo ne respecte pas les règles de composition';
		}
		return 'Le pseudo ne respecte pas les règles de longueur';
	}

	static private function checkEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
			return true;
		return 'L\'email n\'est pas valide';
	}

	static private function checkPass($pass, $passConfirm){
		if($pass == $passConfirm){
			if(mb_strlen($pass) >= 6 && mb_strlen($pass) <= 32){
				if(preg_match('#.*[a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z]+.*#', $pass)){
					return true;
				}
				return 'Le mot de passe ne respecte pas les règles de composition';
			}
			return 'Le mot de passe ne respecte pas les règles de longueur';
		}
		return 'Les mots de passe ne correspondent pas';
	}

	static private function checkConditions($conditions){
		if($conditions == 'on')
			return true;
		return 'Les conditions d\'utilisation ne sont pas acceptées';
	}

}
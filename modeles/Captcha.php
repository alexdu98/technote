<?php

class Captcha{

	static private $clePrivee = PRIVATE_KEY_RECAPTCHA;

	/**
	 * Vérifie si un captcha est valide
	 * @param $captcha
	 * @return bool|string Vrai si captcha valide, string contenant l'erreur sinon
	 */
	static public function check(&$captcha){
		if(!empty($captcha)){
			$res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . self::$clePrivee . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
			$res = json_decode($res);
			if($res->success === true)
				return $res->success;
			else
				return 'Le captcha n\'est pas valide';
		}
		else
			return 'Le captcha n\'est pas renseigné';
	}

}
<?php

class Captcha{

	static public $secret = PRIVATE_KEY_RECAPTCHA;

	public function check($captcha){
		$res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . self::$secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		$res = json_decode($res);
		if($res->success === true)
			return $res->success;
		else
			return 'Problème avec le captcha';
	}

}
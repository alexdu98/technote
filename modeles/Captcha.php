<?php

class Captcha{

	static public $secret = '6LdIRhgTAAAAAMKShVrZyBTvvJP08hHu2la0P_ks';

	public function check($captcha){
		$res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . self::$secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
		$res = json_decode($res);
		if($res->success === true)
			return $res->success;
		else
			return 'Problème avec le captcha';
	}

}
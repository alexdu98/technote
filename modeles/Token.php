<?php

class Token extends TableObject{

	static public function createToken(){
		$cle = hash('sha256', uniqid(rand(), true) . SALT_TOKEN);
		$token = new self(array(
			'id_token' => DAO::UNKNOWN_ID,
			'cle' => $cle,
			'ip' => $_SERVER['REMOTE_ADDR'],
			'id_membre' => $_SESSION['user']->id_membre
		));
		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$tokenDAO->save($token);
		setcookie('token', $cle, time() + DUREE_COOKIE_AUTOCONNECT_SEC);
	}

	public function affiche(){
		echo 'IP de création : ' . $this->ip . ' / Expire le ' . $this->date_expiration;
	}

}
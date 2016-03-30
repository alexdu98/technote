<?php

class Token extends TableObject{

	/**
	 * Créer le token pour rester connecté et le sauvegarde en BDD et en cookie client
	 * @static
	 */
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

}
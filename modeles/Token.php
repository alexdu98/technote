<?php

class Token extends TableObject{

	/**
	 * Créer le token pour rester connecté et le sauvegarde en BDD et l'enregistre en cookie chez le client
	 * @static
	 */
	static public function createToken(){
		$cle = hash('sha256', uniqid(rand(), true) . SALT_TOKEN);
		$token = new Token(array(
			'id_token' => DAO::UNKNOWN_ID,
			'cle' => $cle,
			'ip' => $_SERVER['REMOTE_ADDR'],
			'id_membre' => $_SESSION['user']->id_membre,
			'actif' => '1'
		));
		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$tokenDAO->save($token);
		setcookie('token', $cle, time() + DUREE_COOKIE_AUTOCONNECT_SEC);
	}

	/**
	 * Supprimer un Token
	 * @param $id_token L'identifiant du Token à supprimer
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static public function dropToken($id_token){
		$std = (object) array('success' => false, 'msg' => array());

		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$token = $tokenDAO->getOne($id_token);
		if($token->id_membre == $_SESSION['user']->id_membre || $_SESSION['user']->groupe == 'Administrateur'){
			if($tokenDAO->desactiver($id_token)){
				$std->msg[] = 'Token désactivé';
				$std->success = true;
				return $std;
			}
			else
				$std->msg[] = 'Erreur BDD';
		}
		else
			$std->msg[] = 'Vous n\'avez pas le droit de supprimer ce token';
		return $std;
	}

}
<?php

class MotCle extends TableObject{

	/**
	 * Vérifie si un mot clé existe
	 * @param int $id_mot_cle Le mot clé à vérifier
	 * @return bool|string True si le mot clé existe, un message sinon
	 * @static
	 */
	static public function checkExiste($id_mot_cle){
		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		if(($res = $motCleDAO->getOne($id_mot_cle)) !== false)
			return true;
		return 'Le mot clé '. $id_mot_cle .' n\'existe pas';
	}

}
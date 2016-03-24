<?php

class MotCle extends TableObject{

	static public function checkExiste($id_mot_cle){
		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		if(($res = $motCleDAO->getOne(array('id_mot_cle' => $id_mot_cle))) !== false)
			return true;
		return 'Le mot clé '. $id_mot_cle .' n\'existe pas';
	}

}
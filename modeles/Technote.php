<?php

class Technote extends TableObject{
	
	static public function addTechnote($param) {
		
		$res = (object) array('success' => false, 'msg' => array());
		
		$technote = new Technote(array(
				'id_technote' => DAO::UNKNOWN_ID,
				'titre' => $param['titre'],
				'contenu' => $param['contenu'],
				'id_auteur' => $_SESSION['user']->__get('id_membre'),
				'url_image' => $param['url_image']
		));
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		
		if(!empty($param['mots-cles']))
			$mot_cles = $param['mots-cles'];
		else $mot_cles = array();
		
		if(($resSave = $technoteDAO->saveTechnote($technote, $mot_cles)) !== false){
			$actionDAO = new ActionDAO(BDD::getInstancePDO());
			
			$res->success = true;
			$res->msg[] = 'Création de technote réussie';
		}
		else{
			$res->success = false;
			$res->msg[] = 'Erreur BDD';
		}				
		
		return $res;
	}
	
	
}
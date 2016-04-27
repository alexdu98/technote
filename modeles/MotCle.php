<?php

class MotCle extends TableObject{

	static public function getStat(){
		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		$arr['actifs'] = $motCleDAO->getCountActifs();
		$arr['attente'] = $motCleDAO->getCountNonActifs();
		return $arr;
	}

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

	static public function checkExisteByLabel($label){
		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		if(($res = $motCleDAO->checkExiste($label)) !== false)
			return true;
		return 'Le mot clé '. $label .' n\'existe pas';
	}

	static public function edit(&$param, $id){
		$std = (object) array('success' => false, 'msg' => array());

		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		$motCleOld = $motCleDAO->getOne($id);

		if($motCleOld->label != $param['label']){
			if(($res = MotCle::checkLabel($param['label'])) !== true)
				$std->msg[] = $res;
		}
		if($param['actif'] != 0 && $param['actif'] != 1)
			$std->msg[] = 'Le champ actif n\'est pas valide';

		if(!empty($std->msg))
			return $std;

		$motCle = new MotCle(array(
			'id_mot_cle' => $id,
			'label' => $param['label'],
			'actif' => $param['actif']
		));
		if(($std->success = $motCleDAO->save($motCle)) === true)
			$std->msg[] = 'Mot clé modifié avec succès';
		else
			$std->msg[] = 'Erreur BDD';

		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => "Modification d\'un mot clé (mot clé n°$id : $motCleOld->label)",
			'id_membre' => $_SESSION['user']->id_membre
		));
		$actionDAO->save($action);
		$std->success = true;

		return $std;
	}

	static public function delete($id){
		$std = (object) array('success' => false, 'msg' => array());

		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		$motCle = $motCleDAO->getOne($id);

		if(($std->success = $motCleDAO->delete($id)) === true)
			$std->msg[] = 'Mot clé supprimé avec succès';
		else
			$std->msg[] = 'Erreur BDD';

		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => "Suppression d\'un mot clé (mot clé n°$id : $motCle->label)",
			'id_membre' => $_SESSION['user']->id_membre
		));
		$actionDAO->save($action);

		return $std;
	}

	static public function add(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(($res = MotCle::checkLabel($param['label'])) !== true)
			$std->msg[] = $res;

		if(!empty($std->msg))
			return $std;

		$actif = $_SESSION['user']->groupe == 'Administrateur' || $_SESSION['user']->groupe == 'Modérateur' ? 1 : 0;

		$motCle = new MotCle(array(
			'id_mot_cle' => DAO::UNKNOWN_ID,
			'label' => $param['label'],
			'actif' => $actif
		));

		$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
		$resSave = $motCleDAO->save($motCle);
		if($resSave !== false)
			$std->msg[] = 'Mot clé créer avec succès';
		else
			$std->msg[] = 'Erreur BDD';

		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => "Création d\'un mot clé (mot clé n°$resSave->id_mot_cle : $resSave->label)",
			'id_membre' => $_SESSION['user']->id_membre
		));
		$actionDAO->save($action);
		$std->success = true;

		return $std;
	}

	static public function checkLabel(&$label){
		if(!empty($label)){
			if(MotCle::checkExisteByLabel($label) !== true){
				if(mb_strlen($label) >= 1 && mb_strlen($label) <= 31){
					return true;
				}
				return 'Le label ne respecte pas les règles de longueur (1 à 31 caractères)';
			}
			else
				return 'Le label est déjà utilisé';
		}
		return 'Le label n\'est pas renseigné';
	}

}
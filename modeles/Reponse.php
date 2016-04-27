<?php

class Reponse extends TableObject{

	static public function getStat(){
		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$arr['total'] = $reponseDAO->getCountTotal();
		return $arr;
	}

	static public function dropReponse(&$param, $id_reponse){
		$std = (object) array('success' => false, 'msg' => array());

		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$reponse = $reponseDAO->getOne($id_reponse);
		if($reponse->id_auteur == $_SESSION['user']->id_membre || $_SESSION['user']->groupe == 'Administrateur' || $_SESSION['user']->groupe == 'Modérateur'){
			if($reponseDAO->desactiver($id_reponse)){
				$std->msg[] = 'Réponse supprimé';
				$std->success = true;
				return $std;
			}
			else
				$std->msg[] = 'Erreur BDD';
		}
		else
			$std->msg[] = 'Vous n\'avez pas le droit de supprimer cette réponse';
		return $std;
	}

	static public function editReponse(&$param, $id_reponse){
		$resCheck = self::checkEdit($param, $id_reponse);
		$res = $resCheck;
		if($resCheck->success === true){
			$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
			$reponse = new Reponse(array(
				'id_reponse' => $id_reponse,
				'reponse' => $param['reponse'],
				'id_modificateur' => $_SESSION['user']->id_membre
			));
			if(($resSaveReponse = $reponseDAO->save($reponse)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Édition d\'une réponse (réponse n°$id_reponse)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Édition de la réponse réussie';
				$reponse = (object) array_merge($reponse->getFields(), array('modificateur' => $_SESSION['user']->pseudo, 'date_modification' => date('d/m/Y à H:i')));
				$res->edit['reponse'] = $reponse;
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	static public function addReponse(&$param){
		$resCheck = self::checkAdd($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
			$reponse = new Reponse(array(
				'id_reponse' => DAO::UNKNOWN_ID,
				'reponse' => $param['reponse'],
				'id_auteur' => $_SESSION['user']->id_membre,
				'id_question' => $param['id_question'],
				'id_reponse_parent' => $param['id_reponse_parent'],
				'visible' => '1'
			));
			if(($resSaveReponse = $reponseDAO->save($reponse)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'une réponse (réponse n°$resSaveReponse->id_reponse)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Ajout de la réponse réussie';
				$reponse = (object) array_merge($resSaveReponse->getFields(), array('auteur' => $_SESSION['user']->pseudo));
				$res->add['reponses'] = $reponse;
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	static private function checkAdd(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		if(($res = $questionDAO->getOne($param['id_question'])) !== false){
			if(($res = self::checkReponse($param['reponse'])) !== true)
				$std->msg[] = $res;
			if(($res = self::checkReponseParent($param['id_reponse_parent'], $param['id_question'])) !== true)
				$std->msg[] = $res;
		}
		else
			$std->msg[] = 'La question n\'existe pas';

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static private function checkEdit(&$param, $id_reponse){
		$std = (object) array('success' => false, 'msg' => array());

		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		if(($res = $reponseDAO->getOne($id_reponse)) === false)
			$std->msg[] = 'Le réponse n\'existe pas';
		if($_SESSION['user']->id_membre != $res->id_auteur && $_SESSION['user']->groupe != 'Administrateur' && $_SESSION['user']->groupe != 'Modérateur')
			$std->msg[] = 'Vous n\'avez pas le droit de modifier cette réponse';
		if(($res = self::checkReponse($param['reponse'])) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static private function checkReponse(&$reponse){
		if(!empty($reponse)){
			if(mb_strlen($reponse) >= 8 && mb_strlen($reponse) <= 2047)
				return true;
			return 'La réponse ne respecte pas les règles de longueur (8 à 2047 caractères)';
		}
		return 'La réponse n\'est pas renseigné';
	}

	static private function checkReponseParent(&$id_reponse_parent, $id_technote){
		if(!empty($id_reponse_parent)){
			$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
			if(($res = $reponseDAO->getOne($id_reponse_parent)) !== false){
				if($res->id_question == $id_technote)
					return true;
				else
					return 'La réponse parent n\'appartient pas à la même question';
			}
			else
				return 'La réponse parent n\'existe pas ou plus';
		}
		$id_reponse_parent = NULL;
		return true;
	}

}
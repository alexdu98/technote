<?php

class Commentaire extends TableObject{

	static public function addCommentaire(&$param){
		$resCheck = self::check($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
			$commentaire = new Commentaire(array(
				'id_commentaire' => DAO::UNKNOWN_ID,
				'commentaire' => nl2br($param['commentaire']),
				'id_auteur' => $_SESSION['user']->id_membre,
				'id_technote' => $param['id_technote'],
				'id_commentaire_parent' => $param['id_commentaire_parent']
			));
			if(($resSaveCommentaire = $commentaireDAO->save($commentaire)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'un commentaire (technote n°$param[id_technote])",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Ajout du commentaire réussie';
				$res->add['commentaires'] = $commentaireDAO->getOne($resSaveCommentaire->id_commentaire);
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	static private function check(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		if(($res = $technoteDAO->getOne($param['id_technote'])) === false)
			$std->msg[] = 'La technote n\'existe pas';
		if(($res = self::checkCommentaire($param['commentaire'])) !== true)
			$std->msg[] = $res;
		if(($res = self::checkCommentaireParent($param['id_commentaire_parent'])) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static private function checkCommentaire(&$commentaire){
		if(!empty($commentaire)){
			if(mb_strlen(strip_tags($commentaire)) == mb_strlen($commentaire)){
				if(mb_strlen($commentaire) >= 1 && mb_strlen($commentaire) <= 2047)
					return true;
				return 'Le commentaire ne respecte pas les règles de longueur (1 à 2047 caractères)';
			}
			return 'Les balises HTML sont interdites dans les commentaires (un espace est nécessaire après un \'<\')';
		}
		return 'Le commentaire n\'est pas renseigné';
	}

	static private function checkCommentaireParent(&$id_commentaire_parent){
		if(!empty($id_commentaire_parent)){
			$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
			if($commentaireDAO->getOne($id_commentaire_parent))
				return true;
			return 'Le commentaire parent n\'existe pas ou plus';
		}
		$id_commentaire_parent = NULL;
		return true;
	}

}
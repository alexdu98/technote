<?php

class Commentaire extends TableObject{

	static public function getStat(){
		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$arr['total'] = $commentaireDAO->getCountTotal();
		return $arr;
	}

	static public function dropCommentaire(&$param, $id_commentaire){
		$std = (object) array('success' => false, 'msg' => array());

		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$commentaire = $commentaireDAO->getOne($id_commentaire);
		if($commentaire->id_auteur == $_SESSION['user']->id_membre || $_SESSION['user']->groupe == 'Administrateur' || $_SESSION['user']->groupe == 'Modérateur'){
			if($commentaireDAO->desactiver($id_commentaire)){
				$std->msg[] = 'Commentaire supprimé';
				$std->success = true;
				return $std;
			}
			else
				$std->msg[] = 'Erreur BDD';
		}
		else
			$std->msg[] = 'Vous n\'avez pas le droit de supprimer ce commentaire';
		return $std;
	}

	static public function editCommentaire(&$param, $id_commentaire){
		$resCheck = self::checkEdit($param, $id_commentaire);
		$res = $resCheck;
		if($resCheck->success === true){
			$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
			$commentaire = new Commentaire(array(
				'id_commentaire' => $id_commentaire,
				'commentaire' => nl2br($param['commentaire']),
				'id_modificateur' => $_SESSION['user']->id_membre
			));
			if(($resSaveCommentaire = $commentaireDAO->save($commentaire)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Édition d\'un commentaire (commentaire n°$id_commentaire)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Édition du commentaire réussie';
				$commentaire = (object) array_merge($commentaire->getFields(), array('modificateur' => $_SESSION['user']->pseudo, 'date_modification' => date('d/m/Y à H:i')));
				$res->edit['commentaire'] = $commentaire;
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	static private function checkEdit(&$param, $id_commentaire){
		$std = (object) array('success' => false, 'msg' => array());

		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		if(($res = $commentaireDAO->getOne($id_commentaire)) === false)
			$std->msg[] = 'Le commentaire n\'existe pas';
		if($_SESSION['user']->id_membre != $res->id_auteur && $_SESSION['user']->groupe != 'Administrateur' && $_SESSION['user']->groupe != 'Modérateur')
			$std->msg[] = 'Vous n\'avez pas le droit de modifier ce commentaire';
		if(($res = self::checkCommentaire($param['commentaire'])) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static public function addCommentaire(&$param){
		$resCheck = self::checkAdd($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
			$commentaire = new Commentaire(array(
				'id_commentaire' => DAO::UNKNOWN_ID,
				'commentaire' => nl2br($param['commentaire']),
				'id_auteur' => $_SESSION['user']->id_membre,
				'id_technote' => $param['id_technote'],
				'id_commentaire_parent' => $param['id_commentaire_parent'],
				'visible' => '1'
			));
			if(($resSaveCommentaire = $commentaireDAO->save($commentaire)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'un commentaire (commentaire n°$resSaveCommentaire->id_commentaire)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Ajout du commentaire réussie';
				$commentaire = (object) array_merge($resSaveCommentaire->getFields(), array('auteur' => $_SESSION['user']->pseudo));
				$res->add['commentaires'] = $commentaire;
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

		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		if(($res = $technoteDAO->getOne($param['id_technote'])) !== false){
			if(($res = self::checkCommentaire($param['commentaire'])) !== true)
				$std->msg[] = $res;
			if(($res = self::checkCommentaireParent($param['id_commentaire_parent'], $param['id_technote'])) !== true)
				$std->msg[] = $res;
		}
		else
			$std->msg[] = 'La technote n\'existe pas';

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static private function checkCommentaire(&$commentaire){
		$commentaire = htmlentities($commentaire);
		if(!empty($commentaire)){
			if(mb_strlen($commentaire) >= 1 && mb_strlen($commentaire) <= 2047)
				return true;
			return 'Le commentaire ne respecte pas les règles de longueur (1 à 2047 caractères)';
		}
		return 'Le commentaire n\'est pas renseigné';
	}

	static private function checkCommentaireParent(&$id_commentaire_parent, $id_technote){
		if(!empty($id_commentaire_parent)){
			$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
			if(($res = $commentaireDAO->getOne($id_commentaire_parent)) !== false){
				if($res->id_technote == $id_technote)
					return true;
				else
					return 'Le commentaire parent n\'appartient pas à la même technote';
			}
			else
				return 'Le commentaire parent n\'existe pas ou plus';
		}
		$id_commentaire_parent = NULL;
		return true;
	}

}
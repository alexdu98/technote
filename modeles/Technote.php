<?php

class Technote extends TableObject{

	static public function dropTechnote($id_technote){
		$res = (object) array('success' => false, 'msg' => array());

		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		if($_SESSION['user']->groupe == 'Membre' || $_SESSION['user']->groupe == 'Modérateur'){

		}
		elseif($_SESSION['user']->groupe == 'Administrateur'){
			if($technoteDAO->delete($id_technote)){
				$res->success = true;
				$res->msg[] = 'La technote a bien été supprimée';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	static public function editTechnote(&$param, $id_technote){
		$resCheck = self::checkTechnote($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
			$technote = new Technote(array(
				'id_technote' => $id_technote,
				'titre' => $param['titre'],
				'contenu' => $param['contenu'],
				'id_modificateur' => $_SESSION['user']->id_membre,
				'url_image' => $param['url_image']
			));
			if(($resSaveTechnote = $technoteDAO->save($technote)) !== false){
				$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$decrire = new Decrire(array('id_technote' => $id_technote, 'id_mot_cle' => $id_mot_cle));
						$decrireDAO->save($decrire);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Modification d\'une technote (technote n°$id_technote)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Modification de la technote réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie et ajoute une technote
	 * @param array $param Les attributs de la technotes
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static public function addTechnote(&$param){
		$resCheck = self::checkTechnote($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
			$technote = new Technote(array(
				'id_technote' => DAO::UNKNOWN_ID,
				'titre' => $param['titre'],
				'contenu' => $param['contenu'],
				'id_auteur' => $_SESSION['user']->id_membre,
				'url_image' => $param['url_image']
			));
			if(($resSaveTechnote = $technoteDAO->save($technote)) !== false){
				$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$decrire = new Decrire(array('id_technote' => $resSaveTechnote->id_technote, 'id_mot_cle' => $id_mot_cle));
						$decrireDAO->save($decrire);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'une technote (technote n°$resSaveTechnote->id_technote)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->id_technote = $resSaveTechnote->id_technote;
				$res->msg[] = 'Ajout de la technote réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie les attributs d'une technote
	 * @param array $param Les attributs à vérifier
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static private function checkTechnote(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(($res = Technote::checkTitre($param['titre'])) !== true)
			$std->msg[] = $res;
		if(($res = Technote::checkContenu($param['contenu'])) !== true)
			$std->msg[] = $res;
		if(($res = Technote::checkURLImage($param['url_image'])) !== true)
			$std->msg[] = $res;
		if(!empty($param['id_mot_cle'])){
			foreach($param['id_mot_cle'] as $id_mot_cle){
				if(($res = MotCle::checkExiste($id_mot_cle)) !== true)
					$std->msg[] = $res;
			}
		}

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	/**
	 * Vérifie le titre d'une technote
	 * @param string $titre Le titre à vérifier
	 * @return bool|string True si le titre est valide, un message sinon
	 * @static
	 */
	static public function checkTitre(&$titre){
		if(!empty($titre)){
			if(mb_strlen(strip_tags($titre)) == mb_strlen($titre)){
				if(mb_strlen($titre) >= 3 && mb_strlen($titre) <= 63){
					return true;
				}
				return 'Le titre ne respecte pas les règles de longueur (3 à 63 caractères)';
			}
			return 'Les balises HTML sont interdites dans le titre (un espace est nécessaire après un \'<\')';
		}
		return 'Le titre n\'est pas renseigné';
	}

	/**
	 * Vérifie le contenu d'une technote
	 * @param string $contneu Le contenu à vérifier
	 * @return bool|string True si le contenu est valide, un message sinon
	 * @static
	 */
	static public function checkContenu(&$contenu){
		if(!empty($contenu)){
			if(mb_strlen($contenu) >= 15 && mb_strlen($contenu) <= 65535){
				return true;
			}
			return 'Le contenu ne respecte pas les règles de longueur (15 à 65535 caractères)';
		}
		return 'Le contenu n\'est pas renseigné';
	}

	/**
	 * Vérifie le lien de l'image d'une technote
	 * @param string $url L'URL de l'image à vérifier
	 * @return bool|string True si l'URL de l'image est valide, un message sinon
	 * @static
	 */
	static public function checkURLImage(&$url){
		if(!empty($url)){
			if(filter_var($url, FILTER_VALIDATE_URL))
				return true;
			return 'L\'URL de l\'image n\'est pas valide';
		}
		return 'L\'URL de l\'image n\'est pas renseigné';
	}

}
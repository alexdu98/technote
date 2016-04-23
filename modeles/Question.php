<?php

class Question extends TableObject{

	static public function addQuestion(&$param){
		$resCheck = self::check($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$questionDAO = new QuestionDAO(BDD::getInstancePDO());
			$question = new Question(array(
				'id_question' => DAO::UNKNOWN_ID,
				'titre' => $param['titre'],
				'question' => $param['question'],
				'id_auteur' => $_SESSION['user']->id_membre,
				'resolu' => '0',
				'visible' => '1'
			));
			if(($resSaveQuestion = $questionDAO->save($question)) !== false){
				$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$clarifier = new Decrire(array('id_question' => $resSaveQuestion->id_question, 'id_mot_cle' => $id_mot_cle));
						$clarifierDAO->save($clarifier);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'une question (question n°$resSaveQuestion->id_question)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->id_question = $resSaveQuestion->id_question;
				$res->msg[] = 'Ajout de la question réussie';
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

		if(($res = Question::checkTitre($param['titre'])) !== true)
			$std->msg[] = $res;
		if(($res = Question::checkQuestion($param['question'])) !== true)
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

	static public function editQuestion(&$param, $id_question){
		$resCheck = self::check($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$questionDAO = new QuestionDAO(BDD::getInstancePDO());
			$question = new Question(array(
				'id_question' => $id_question,
				'titre' => $param['titre'],
				'question' => $param['question'],
				'id_modificateur' => $_SESSION['user']->id_membre,
				'resolu' => $param['resolu']
			));
			if(($resSaveQuestion = $questionDAO->save($question)) !== false){
				$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$clarifier = new Clarifier(array('id_question' => $id_question, 'id_mot_cle' => $id_mot_cle));
						$clarifierDAO->save($clarifier);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Modification d\'une question (question n°$id_question)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Modification de la question réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

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

	static public function checkQuestion(&$question){
		if(!empty($question)){
			if(mb_strlen($question) >= 15 && mb_strlen($question) <= 65535){
				return true;
			}
			return 'La question ne respecte pas les règles de longueur (15 à 65535 caractères)';
		}
		return 'La question n\'est pas renseigné';
	}

	static public function dropQuestion($id_question){
		$res = (object) array('success' => false, 'msg' => array());

		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		if($_SESSION['user']->groupe == 'Membre' || $_SESSION['user']->groupe == 'Modérateur'){
			$res->success = $questionDAO->noVisible($id_question);
		}
		elseif($_SESSION['user']->groupe == 'Administrateur'){
			$res->success = $questionDAO->delete($id_question);
		}

		if($res->success)
			$res->msg[] = 'La technote a bien été supprimée';
		else
			$res->msg[] = 'Erreur BDD';

		return $res;
	}

	static public function recherche(&$param, $page){
		$std = (object) array('success' => false, 'msg' => array());
		$cond = array();
		$strPagination = '';

		if(!empty($param['titre'])){
			$cond['titre'] = $param['titre'];
			$strPagination .= '&titre=' . urlencode($param['titre']);
		}

		if(!empty($param['date_debut'])){
			if(($res = Date::verifierDate($param['date_debut'])) !== true)
				$std->msg[] = $res . ' (date de début)';
			else{
				$cond['date_debut'] = $param['date_debut'];
				$strPagination .= '&date_debut=' . $param['date_debut'];
			}
		}

		if(!empty($param['date_fin'])){
			if(($res = Date::verifierDate($param['date_fin'])) !== true)
				$std->msg[] = $res . ' (date de fin)';
			else{
				$cond['date_fin'] = $param['date_fin'];
				$strPagination .= '&date_fin=' . $param['date_fin'];
			}
		}

		if(!empty($param['resolu'])){
			if($param['resolu'] != 'oui' && $param['resolu'] != 'non')
				$std->msg[] = 'Valeur invalide pour le champ résolu';
			else{
				$cond['resolu'] = $param['resolu'];
				$strPagination .= '&resolu=' . $param['resolu'];
			}
		}

		if(!empty($param['mots_cles'])){
			$tabMC = explode(',', $param['mots_cles']);
			$tabMCClean = array();
			foreach($tabMC as $key => $value){
				$valueClean = trim($value);
				if($valueClean != ''){
					$tabMCClean[] = $valueClean;
					if($valueClean[0] == '+')
						$valueClean = substr($valueClean, 1);
					if(($res = MotCle::checkExisteByLabel($valueClean)) !== true)
						$std->msg[] = $res;
				}
			}
			$cond['mots_cles'] = $tabMCClean;
		}

		if(!empty($std->msg))
			return $std;

		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		// On récupère le nombre de questions qu'on a en résultat
		$count = $questionDAO->getQuestionsWithSearch(NB_QUESTIONS_PAGE, $cond, true);

		// On créé la pagination
		$std->pagination = new Pagination($page, $count, NB_QUESTIONS_PAGE, '/questions?recherche=' . $strPagination . '&page=');

		// On récupère les questions
		$std->questions = $questionDAO->getQuestionsWithSearch(NB_QUESTIONS_PAGE, $cond, false, $std->pagination->debut);

		if(empty($std->questions))
			$std->msg[] = 'Aucune question avec ces critères';
		else
			$std->success = true;
		return $std;
	}

}
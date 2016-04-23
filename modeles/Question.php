<?php

class Question extends TableObject{

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
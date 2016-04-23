<?php

/**
 * Classe pour l'accès à la table Question
 */
class QuestionDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('
								SELECT q.*, ma.pseudo auteur, mm.pseudo modificateur
								FROM question q
								INNER JOIN membre ma ON ma.id_membre=q.id_auteur
								LEFT JOIN membre mm ON mm.id_membre=q.id_modificateur
								WHERE id_question = :id_question');
		$req->execute(array(
			'id_question' => $id
		));
		if(($res = $req->fetch()) === false)
			return false;

		$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
		$res->motsCles = $clarifierDAO->getAllForOneQuestion($id);

		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$res->reponses = $reponseDAO->getTreeForOneQuestion($id, NULL);

		return new Question(get_object_vars($res));
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM question');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Question(get_object_vars($ligne));
		return $res;
	}

	public function save($question){
		$fields = $question->getFields();
		if($question->id_question == DAO::UNKNOWN_ID){
			unset($fields['id_question']);
			$champs = $valeurs = '';
			foreach($question as $nomChamp => $valeur){
				if($nomChamp == 'id_question') continue;
				$champs .= $nomChamp . ', ';
				if($valeur === NULL){
					$valeurs .= 'NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$valeurs .= ":$nomChamp, ";
				}
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = $this->pdo->prepare("INSERT INTO question($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$question->id_question = $this->pdo->lastInsertId();
				return $question;
			}
			return false;
		}
		else{
			unset($question->id_question);
			$newValeurs = '';
			foreach($question as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE question SET $newValeurs WHERE id_question = :id_question");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM question WHERE id_question = :id_question');
		return $req->execute(array(
			'id_question' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	public function noVisible($id){
		$req = $this->pdo->prepare('UPDATE question SET visible = 0 WHERE id_question = :id_question');
		return $req->execute(array(
			'id_question' => $id
		));
	}

	/**
	 * Récupère le nombre de questions d'un membre
	 * @param int $id_auteur L'identifiant du membre
	 * @return int Le nombre de questions du membre
	 */
	public function getNbRedige($id_auteur){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige FROM question WHERE id_auteur = :id_auteur');
		$req->execute(array(
			'id_auteur' => $id_auteur
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

	public function getCount(){
		$req = $this->pdo->prepare('SELECT COUNT(*) AS nbQuestions
									FROM question');
		$req->execute();
		$res = $req->fetch();

		return $res->nbQuestions;
	}

	public function getLastNQuestions($max, $debut = 0){
		$res = array();

		$req = $this->pdo->prepare('SELECT q.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM question q
									INNER JOIN membre ma ON ma.id_membre=q.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=q.id_modificateur
									ORDER BY date_question DESC
									LIMIT :max OFFSET :debut');

		$req->bindParam(':debut', $debut, PDO::PARAM_INT);
		$req->bindParam(':max', $max, PDO::PARAM_INT);

		$req->execute();

		foreach($req->fetchAll() as $ligne){
			// On recupere le nombre de réponses
			$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
			$ligne->nbReponses = $reponseDAO->getCountForOneQuestion($ligne->id_question);
			$ligne->lastReponse = $reponseDAO->getLastForOneQuestion($ligne->id_question);

			// Recuperation des mot-cles correspondant a la question
			$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $clarifierDAO->getAllForOneQuestion($ligne->id_question);

			$res[] = new Question(get_object_vars($ligne));
		}
		return $res;
	}

	public function getQuestionsWithSearch($max, $conditions, $count = false, $debut = 0){
		$res = array();

		$where = '';
		$join = '';
		$param = array();

		// Partie titre technote
		if(!empty($conditions['titre'])){
			$param['titre'] = '%' . $conditions['titre'] . '%';
			$where .= " AND q.titre LIKE :titre";
		}

		// Partie date
		if(!empty($conditions['date_debut']) && !empty($conditions['date_fin'])){
			$conditions['date_debut'] .= ' 00:00:00';
			$conditions['date_fin'] .= ' 23:59:59';
			$param['date_debut'] = $conditions['date_debut'];
			$param['date_fin'] = $conditions['date_fin'];
			$where .= " AND date_question BETWEEN :date_debut AND :date_fin";
		}
		elseif(!empty($conditions['date_debut'])){
			$conditions['date_debut'] .= ' 00:00:00';
			$param['date_debut'] = $conditions['date_debut'];
			$where .= " AND date_question BETWEEN :date_debut AND NOW()";
		}
		elseif(!empty($conditions['date_fin'])){
			$conditions['date_fin'] .= ' 23:59:59';
			$param['date_fin'] = $conditions['date_fin'];
			$where .= " AND date_question < :date_fin";
		}

		// Partie auteur
		if(!empty($conditions['resolu'])){
			$param['resolu'] = $conditions['resolu'] == 'oui' ? '1' : '0';
			$where .= " AND resolu = :resolu";
		}

		// Partie mots clés
		if(!empty($conditions['mots_cles'])){
			$sqlMCObligatoire = '';
			$sqlMCNonObligatoire = '';
			foreach($conditions['mots_cles'] as $mc){
				if($mc[0] == '+'){
					$sqlMCObligatoire .= '\'' . substr($mc, 1) . '\', '; // On enlee le + pour la requete
				}
				else{
					$sqlMCNonObligatoire .= '\'' . $mc . '\', ';
				}
			}
			$sqlMCObligatoire = substr($sqlMCObligatoire, 0, -2);
			$sqlMCNonObligatoire = substr($sqlMCNonObligatoire, 0, -2);
			if(!empty($sqlMCObligatoire)){
				$where .= " AND NOT EXISTS(SELECT id_mot_cle FROM mot_cle mc WHERE label IN ($sqlMCObligatoire) AND NOT EXISTS(SELECT * FROM clarifier c WHERE mc.id_mot_cle=c.id_mot_cle AND c.id_question=q.id_question))";
			}
			else{
				$join .= ' LEFT JOIN clarifier c ON c.id_question=q.id_question';
				$where .= " AND c.id_mot_cle IN(SELECT id_mot_cle FROM mot_cle WHERE label IN($sqlMCNonObligatoire))";
			}
		}

		if($count){
			$sql = 'SELECT COUNT(DISTINCT q.id_question) nbRes
									FROM question q
									INNER JOIN membre ma ON ma.id_membre=q.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=q.id_modificateur
									' . $join . '
									WHERE 1 = 1
									' . $where;
			$req = $this->pdo->prepare($sql);
			$req->execute($param);
			$res = $req->fetch();
			return $res->nbRes;
		}

		$sql = 'SELECT DISTINCT q.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM question q
									INNER JOIN membre ma ON ma.id_membre=q.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=q.id_modificateur
									' . $join . '
									WHERE 1 = 1
									' . $where . '
									ORDER BY date_question DESC
									LIMIT ' . $debut . ', ' . $max; // Ne peut pas etre preparé car échapé (LIMIT '10', '0' => FAIL)

		$req = $this->pdo->prepare($sql);

		$req->execute($param);

		foreach($req->fetchAll() as $ligne){
			// On recupere le nombre de réponses
			$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
			$ligne->nbReponses = $reponseDAO->getCountForOneQuestion($ligne->id_question);
			$ligne->lastReponse = $reponseDAO->getLastForOneQuestion($ligne->id_question);

			// Recuperation des mot-cles correspondant a la question
			$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $clarifierDAO->getAllForOneQuestion($ligne->id_question);

			$res[] = new Question(get_object_vars($ligne));
		}
		return $res;
	}

	public function getAllTitreComposedOf($exp){
		$req = $this->pdo->prepare('SELECT titre FROM question WHERE titre LIKE :exp');
		$req->execute(array(
			'exp' => '%' . $exp . '%'
		));
		return $req->fetchAll();
	}

}
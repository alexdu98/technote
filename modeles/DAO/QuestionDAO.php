<?php

/**
 * Classe pour l'accès à la table Question
 */
class QuestionDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM question WHERE id_question = :id_question');
		$req->execute(array(
			'id_question' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Question(get_object_vars($res));
		return false;
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

			// Recuperation des mot-cles correspondant a la technote
			$clarifierDAO = new ClarifierDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $clarifierDAO->getAllForOneQuestion($ligne->id_question);

			$res[] = new Question(get_object_vars($ligne));
		}
		return $res;
	}

}
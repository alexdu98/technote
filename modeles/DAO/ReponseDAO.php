<?php

/**
 * Classe pour l'accès à la table Reponse
 */
class ReponseDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM reponse WHERE id_reponse = :id_reponse');
		$req->execute(array(
			'id_reponse' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Reponse(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM reponse');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Reponse(get_object_vars($ligne));
		return $res;
	}

	public function save($reponse){
		$fields = $reponse->getFields();
		if($reponse->id_reponse == DAO::UNKNOWN_ID){
			unset($fields['id_reponse']);
			$champs = $valeurs = '';
			foreach($reponse as $nomChamp => $valeur){
				if($nomChamp == 'id_reponse') continue;
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
			$req = $this->pdo->prepare("INSERT INTO reponse($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$reponse->id_reponse = $this->pdo->lastInsertId();
				return $reponse;
			}
			return false;
		}
		else{
			unset($reponse->id_reponse);
			$newValeurs = '';
			foreach($reponse as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE reponse SET $newValeurs WHERE id_reponse = :id_reponse");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM reponse WHERE id_reponse = :id_reponse');
		return $req->execute(array(
			'id_reponse' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère le nombre de réponses d'un membre
	 * @param int $id_auteur L'identifiant du membre
	 * @return int Le nombre de réponses du membre
	 */
	public function getNbRedige($id_auteur){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige FROM reponse WHERE id_auteur = :id_auteur');
		$req->execute(array(
			'id_auteur' => $id_auteur
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

	public function getTreeForOneQuestion($id_question, $id_reponse_parent){
		$res = array();
		$op = empty($id_reponse_parent) ? 'IS' : '=';
		$req = $this->pdo->prepare('SELECT r.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM reponse r
									INNER JOIN membre ma ON ma.id_membre=r.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=r.id_modificateur
									WHERE id_question = :id_question
										AND id_reponse_parent ' . $op . ' :id_reponse_parent');
		$req->execute(array(
			'id_question' => $id_question,
			'id_reponse_parent' => $id_reponse_parent
		));
		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		foreach($req->fetchAll() as $ligne){
			$ligne->reponses = $reponseDAO->getTreeForOneQuestion($id_question, $ligne->id_reponse);
			$res[] = new Reponse(get_object_vars($ligne));
		}
		return $res;
	}

	public function getCountForOneQuestion($id_question){
		$req = $this->pdo->prepare('SELECT COUNT(*) AS nbReponses
									FROM reponse
									WHERE id_question = :id_question');
		$req->execute(array(
			'id_question' => $id_question
		));
		$res = $req->fetch();

		return $res->nbReponses;
	}

	public function getLastForOneQuestion($id_question){
		$req = $this->pdo->prepare('SELECT r.*, m.pseudo auteur
									FROM reponse r
									INNER JOIN membre m ON r.id_auteur=m.id_membre
									WHERE id_question = :id_question
									ORDER BY date_reponse DESC
									LIMIT 1');
		$req->execute(array(
			'id_question' => $id_question
		));
		if(($res = $req->fetch()) !== false)
			return new Reponse(get_object_vars($res));
		return false;
	}

	public function desactiver($id){
		$req = $this->pdo->prepare('UPDATE reponse SET visible = 0 WHERE id_reponse = :id_reponse');
		return $req->execute(array(
			'id_reponse' => $id
		));
	}

}
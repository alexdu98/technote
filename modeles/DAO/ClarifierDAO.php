<?php

/**
 * Classe pour l'accès à la table Clarifier
 */
class ClarifierDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM clarifier WHERE id_question = :id_question AND id_mot_cle = :id_mot_cle');
		$req->execute(array(
			'id_question' => $id['id_question'],
			'id_mot_cle' => $id['id_mot_cle']
		));
		if(($res = $req->fetch()) !== false)
			return new Clarifier(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM clarifier');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Clarifier(get_object_vars($ligne));
		return $res;
	}

	public function save($clarifier){
		$fields = $clarifier->getFields();
		$champs = $valeurs = '';
		foreach($clarifier as $nomChamp => $valeur){
			$champs .= $nomChamp . ', ';
			$valeurs .= ":$nomChamp, ";
		}
		$champs = substr($champs, 0, -2);
		$valeurs = substr($valeurs, 0, -2);
		$req = $this->pdo->prepare("INSERT INTO clarifier($champs) VALUES($valeurs)");
		if($req->execute($fields)){
			return $clarifier;
		}
		return false;
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM clarifier WHERE id_question = :id_question AND id_mot_cle = :id_mot_cle');
		return $req->execute(array(
			'id_question' => $id['id_question'],
			'id_mot_cle' => $id['id_mot_cle']
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	public function getAllForOneQuestion($id_question){
		$res = array();
		$req = $this->pdo->prepare('SELECT c.id_mot_cle, label FROM clarifier c INNER JOIN mot_cle mc ON c.id_mot_cle=mc.id_mot_cle WHERE c.id_question = :id_question');
		$req->execute(array(
			'id_question' => $id_question
		));
		foreach($req->fetchAll() as $ligne)
			$res[] = new Clarifier(get_object_vars($ligne));
		return $res;
	}

	public function deleteAllForOneQuestion($id_question){
		$req = $this->pdo->prepare('DELETE FROM clarifier WHERE id_question = :id_question');
		return $req->execute(array(
			'id_question' => $id_question
		));
	}
}
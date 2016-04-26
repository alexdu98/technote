<?php

/**
 * Classe pour l'accès à la table MotCle
 */
class MotCleDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM mot_cle WHERE id_mot_cle = :id_mot_cle');
		$req->execute(array(
			'id_mot_cle' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new MotCle(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM mot_cle');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new MotCle(get_object_vars($ligne));
		return $res;
	}

	public function save($motCle){
		$fields = $motCle->getFields();
		if($motCle->id_mot_cle == DAO::UNKNOWN_ID){
			unset($fields['id_mot_cle']);
			$champs = $valeurs = '';
			foreach($motCle as $nomChamp => $valeur){
				if($nomChamp == 'id_mot_cle') continue;
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
			$req = $this->pdo->prepare("INSERT INTO mot_cle($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$motCle->id_mot_cle = $this->pdo->lastInsertId();
				return $motCle;
			}
			return false;
		}
		else{
			unset($motCle->id_mot_cle);
			$newValeurs = '';
			foreach($motCle as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE mot_cle SET $newValeurs WHERE id_mot_cle = :id_mot_cle");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM mot_cle WHERE id_mot_cle = :id_mot_cle');
		return $req->execute(array(
			'id_mot_cle' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	public function getAllComposedOf($exp){
		$req = $this->pdo->prepare('SELECT label FROM mot_cle WHERE actif = 1 AND label LIKE :exp');
		$req->execute(array(
			'exp' => '%' . $exp . '%'
		));
		return $req->fetchAll();
	}

	public function checkExiste($motCle){
		$req = $this->pdo->prepare('SELECT * FROM mot_cle WHERE actif = 1 AND label = :motcle');
		$req->execute(array(
			'motcle' => $motCle
		));
		if(($res = $req->fetch()) !== false)
			return true;
		return false;
	}

	public function getAllForTable(){
		$res = array();
		$req = $this->pdo->prepare('SELECT id_mot_cle id, label mot, actif FROM mot_cle');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new MotCle(get_object_vars($ligne));
		return $res;
	}

	public function getAllActif(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM mot_cle WHERE actif = 1');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new MotCle(get_object_vars($ligne));
		return $res;
	}

}
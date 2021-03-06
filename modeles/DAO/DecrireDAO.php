<?php

/**
 * Classe pour l'accès à la table Decrire
 */
class DecrireDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM decrire WHERE id_technote = :id_technote AND id_mot_cle = :id_mot_cle');
		$req->execute(array(
			'id_technote' => $id['id_technote'],
			'id_mot_cle' => $id['id_mot_cle']
		));
		if(($res = $req->fetch()) !== false)
			return new Decrire(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM decrire');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Decrire(get_object_vars($ligne));
		return $res;
	}

	public function save($decrire){
		$fields = $decrire->getFields();
		$champs = $valeurs = '';
		foreach($decrire as $nomChamp => $valeur){
			$champs .= $nomChamp . ', ';
			$valeurs .= ":$nomChamp, ";
		}
		$champs = substr($champs, 0, -2);
		$valeurs = substr($valeurs, 0, -2);
		$req = $this->pdo->prepare("INSERT INTO decrire($champs) VALUES($valeurs)");
		if($req->execute($fields)){
			return $decrire;
		}
		return false;
	}

	public function delete($id){
		try{
			$req = $this->pdo->prepare('DELETE FROM decrire WHERE id_technote = :id_technote AND id_mot_cle = :id_mot_cle');
			return $req->execute(array(
				'id_technote' => $id['id_technote'],
				'id_mot_cle' => $id['id_mot_cle']
			));
		}
		catch(PDOException $e){
			return false;
		}
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	public function getAllForOneTechnote($id_technote){
		$res = array();
		$req = $this->pdo->prepare('SELECT d.id_mot_cle, label FROM decrire d INNER JOIN mot_cle mc ON d.id_mot_cle=mc.id_mot_cle WHERE mc.actif = 1 AND d.id_technote = :id_technote');
		$req->execute(array(
			'id_technote' => $id_technote
		));
		foreach($req->fetchAll() as $ligne)
			$res[] = new Decrire(get_object_vars($ligne));
		return $res;
	}

	public function deleteAllForOneTechnote($id_technote){
		try{
			$req = $this->pdo->prepare('DELETE FROM decrire WHERE id_technote = :id_technote');
			return $req->execute(array(
				'id_technote' => $id_technote
			));
		}
		catch(PDOException $e){
			return false;
		}
	}
}
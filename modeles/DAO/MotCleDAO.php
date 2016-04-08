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
		if($motCle->id_mot_cle == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($motCle as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO mot_cle(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$motCle->id_mot_cle = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_mot_cle = $motCle->id_mot_cle;
			unset($motCle->id_mot_cle);
			$newValeurs = '';
			foreach($motCle as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE mot_cle SET $newValeurs WHERE id_mot_cle = '$id_mot_cle'";
			return $this->pdo->exec($req);
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

}
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
		$champs = $valeurs = '';
		foreach($decrire as $nomChamp => $valeur){
			$champs .= $nomChamp . ', ';
			$valeurs .= "'$valeur', ";
		}
		$champs = substr($champs, 0, -2);
		$valeurs = substr($valeurs, 0, -2);
		$req = 'INSERT INTO decrire(' . $champs .') VALUES(' . $valeurs .')';
		$res = $this->pdo->exec($req);
		return $res;
	}

	public function delete($decrire){
		return $this->pdo->exec("DELETE FROM decrire WHERE id_technote = '$decrire->id_technote' AND id_mot_cle = '$decrire->id_mot_cle'");
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################
	

}
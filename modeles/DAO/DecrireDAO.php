<?php

/**
 * Classe pour l'accès à la table Decrire
 */
class DecrireDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM decrire WHERE id_technote = :id_technote AND id_mot_cle = :id_mot_cle');
		$req->execute(array(
			'id_technote' => $id['id_technote'],
			'id_mot_cle' => $id['id_mot_cle']
		));
		$res = $req->fetch();
		return new Decrire($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM decrire');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Decrire($ligne);
		}
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
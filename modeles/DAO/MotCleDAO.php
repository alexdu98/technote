<?php

/**
 * Classe pour l'accès à la table MotCle
 */
class MotCleDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM mot_cle WHERE id_mot_cle = :id_mot_cle');
		$req->execute(array(
			'id_mot_cle' => $id['id_mot_cle']
		));
		$res = $req->fetch();
		return new MotCle($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM mot_cle');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new MotCle($ligne);
		}
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

	public function delete($motCle){
		return $this->pdo->exec("DELETE FROM mot_cle WHERE id_mot_cle = '$motCle->id_mot_cle'");
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

}
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
		if($reponse->id_reponse == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($reponse as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO reponse(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$reponse->id_reponse = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_reponse = $reponse->id_reponse;
			unset($reponse->id_reponse);
			$newValeurs = '';
			foreach($reponse as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE reponse SET $newValeurs WHERE id_reponse = '$id_reponse'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($reponse){
		return $this->pdo->exec("DELETE FROM reponse WHERE id_reponse = '$reponse->id_reponse'");
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

}
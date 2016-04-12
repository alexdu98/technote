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

}
<?php

/**
 * Classe pour l'accès à la table Action
 */
class ActionDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM action WHERE id_action = :id_action');
		$req->execute(array(
			'id_action' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Action(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM action');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Action(get_object_vars($ligne));
		return $res;
	}

	public function save($action){
		if($action->id_action == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($action as $nomChamp => $valeur){
				if($nomChamp != 'id_action'){
					$champs .= $nomChamp . ', ';
					$valeurs .= "'$valeur', ";
				}
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO action(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$action->id_action = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_question = $action->id_action;
			unset($action->id_action);
			$newValeurs = '';
			foreach($action as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE action SET $newValeurs WHERE id_action = '$id_question'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($id){
		try{
			$req = $this->pdo->prepare('DELETE FROM action WHERE id_action = :id_action');
			return $req->execute(array(
				'id_action' => $id
			));
		}
		catch(PDOException $e){
			return false;
		}
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère les dernières actions d'un membre
	 * @param int $id_membre L'identifiant du membre
	 * @return array Le tableau des dernières actions du membre
	 */
	public function getLast($id_membre){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM action WHERE id_membre = :id_membre ORDER BY date_action DESC LIMIT 10');
		$req->execute(array(
			'id_membre' => $id_membre
		));
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Action($ligne);
		}
		return $res;
	}

}
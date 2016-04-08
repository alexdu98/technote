<?php

/**
 * Classe pour l'accès à la table Visite
 */
class VisiteDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM visite WHERE id_visite = :id_visite');
		$req->execute(array(
			'id_visite' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Visite(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM visite');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Visite(get_object_vars($ligne));
		return $res;
	}

	public function save($visite){
		if($visite->id_visite == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($visite as $nomChamp => $valeur){
				if($nomChamp != "id_visite"){
					// on doit pas ajouter le champ id_visite
					// car c'est un AUTOINCREMENT
					$champs .= $nomChamp . ', ';
					$valeurs .= "'$valeur', ";
				}
			}
			
			// substr pour enlever le dernier espace et virgule
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO visite(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$visite->id_visite = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_visite = $visite->id_visite;
			unset($visite->id_visite);
			$newValeurs = '';
			foreach($visite as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE visite SET $newValeurs WHERE id_visite = '$id_visite'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM visite WHERE id_visite = :id_visite');
		return $req->execute(array(
			'id_visite' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère la dernière visite d'une IP
	 * @param string $ip L'IP
	 * @return bool|Visite False si première visite, la dernière Visite sinon
	 */
	public function getLastVisite($ip){
		$req = $this->pdo->prepare('SELECT * FROM visite WHERE ip = :ip ORDER BY date_visite DESC LIMIT 1');
		$req->execute(array(
			'ip' => $ip
		));
		if(($res = $req->fetch()) === false){
			return false;
		}
		else{
			return new Visite(get_object_vars($res));
		}
	}

}
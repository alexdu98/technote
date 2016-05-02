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
		$fields = $visite->getFields();
		if($visite->id_visite == DAO::UNKNOWN_ID){
			unset($fields['id_visite']);
			$champs = $valeurs = '';
			foreach($visite as $nomChamp => $valeur){
				if($nomChamp == 'id_visite') continue;
				$champs .= $nomChamp . ', ';
				if($valeur === NULL){
					$valeurs .= 'NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$valeurs .= ":$nomChamp, ";
				}
			}
			
			// substr pour enlever le dernier espace et virgule
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = $this->pdo->prepare("INSERT INTO visite($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$visite->id_visite = $this->pdo->lastInsertId();
				return $visite;
			}
			return false;
		}
		else{
			unset($visite->id_visite);
			$newValeurs = '';
			foreach($visite as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE visite SET $newValeurs WHERE id_visite = :id_visite");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		try{
			$req = $this->pdo->prepare('DELETE FROM visite WHERE id_visite = :id_visite');
			return $req->execute(array(
				'id_visite' => $id
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

	public function getCount(){
		$req = $this->pdo->prepare('SELECT COUNT(*) total
									FROM visite');

		$req->execute();
		$res = $req->fetch();
		return $res->total;
	}

	public function getCountToday(){
		$req = $this->pdo->prepare('SELECT COUNT(*) today
									FROM visite
									WHERE date_visite > :today');

		$req->execute(array('today' => date('Y-m-d')));
		$res = $req->fetch();
		return $res->today;
	}

	public function getCountNow(){
		$req = $this->pdo->prepare('SELECT COUNT(*) now
									FROM visite
									WHERE date_visite > :now');

		$req->execute(array('now' => date('Y-m-d H:i', time() - (NB_SEC_ENTRE_2_VISITES))));
		$res = $req->fetch();
		return $res->now;
	}

}
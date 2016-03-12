<?php

/**
 * Classe pour l'accès à la table Visite
 */
class VisiteDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM visite WHERE id_visite = :id_visite');
		$req->execute(array(
			'id_visite' => $id['id_visite']
		));
		$res = $req->fetch();
		return new Visite($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM visite');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Visite($ligne);
		}
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

	public function delete($visite){
		return $this->pdo->exec("DELETE FROM visite WHERE id_visite = '$visite->id_visite'");
	}



	public function checkVisite($visite){
		/*
		 * @param : Un objet de la classe Visite.
		 * 
		 * @action : Sauvegarde la visite dans la BDD, si
		 * celle-ci remonte a plus d'une heure.
		 */
		$lastVisite = $this->getLastVisite($visite->ip);
		$timeStamp1Heure = time() - NB_SEC_ENTRE_2_VISITES;
		
		if($lastVisite === false){
			// Si c'est la premiere fois que le client vient sur le site
			$lastVisite = new stdClass();
			$lastVisite->date_visite = 1;
		}
		if(strtotime($lastVisite->date_visite) <= $timeStamp1Heure){
			$this->save($visite);
		}
	}

	private function getLastVisite($ip){
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
<?php

/**
 * Classe VisiteDAO
 * @author Alexandre CULTY
 * @version 1.0
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
			$res[] = new Visite(array(
				'id_visite' => $obj->id_visite,
				'ip' => $obj->ip,
				'date_visite' => $obj->date_visite
			));
		}
		return $res;
	}

	public function save($visite){
		if($visite->id_visite == DAO::UNKNOWN_ID){
			$res = $this->pdo->exec("INSERT INTO visite(ip, date_visite) VALUES('$visite->ip', NOW())");
			$visite->id_visite = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			return $this->pdo->exec("UPDATE visite set ip = '$visite->ip', date_visite = NOW() WHERE id_visite = '$visite->id_visite'");
		}
	}

	public function delete($visite){
		return $this->pdo->exec("DELETE FROM visite WHERE id_visite = '$visite->id_visite'");
	}

	public function connectWithCookie(){
		if(!empty($_COOKIE[NOM_COOKIE_CONNEXION])){
			$req = $this->pdo->prepare('SELECT M.id_membre, pseudo, email, bloquer, G.libelle FROM token T JOIN membre M ON M.id_membre=T.id_membre JOIN groupe G ON G.id_groupe=M.id_groupe WHERE cle = :token');
			$req->execute(array(
				'token' => $_COOKIE[NOM_COOKIE_CONNEXION]
			));
			if($res = $req->fetch()){
				if($res->bloquer === false){
					$_SESSION[NOM_SESSION_CONNEXION] = $res;
				}
			}
		}
		$_SESSION[NOM_SESSION_CONNEXION] = false;
		setcookie(NOM_COOKIE_CONNEXION,'', time());
	}

	public function checkVisite($visite){
		$lastVisite = $this->getLastVisite($visite->ip);
		$timeStamp1Heure = time() - NB_SEC_ENTRE_2_VISITES;
		if($lastVisite === false){
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
		if(($res = $req->fetch(PDO::FETCH_ASSOC)) === false){
			return false;
		}
		else{
			return new Visite($res);
		}
	}

}
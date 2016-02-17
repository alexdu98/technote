<?php

/**
 * Classe pour l'accès à la table Membre
 */
class MembreDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM membre WHERE id_membre = :id_membre');
		$req->execute(array(
			'id_membre' => $id['id_membre']
		));
		$res = $req->fetch();
		return new Membre($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM membre');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Membre($ligne);
		}
		return $res;
	}

	public function save($membre){
		if($membre->id_membre == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($membre as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO membre(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$membre->id_membre = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_membre = $membre->id_membre;
			unset($membre->id_membre);
			$newValeurs = '';
			foreach($membre as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE membre SET $newValeurs WHERE id_membre = '$id_membre'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($membre){
		return $this->pdo->exec("DELETE FROM membre WHERE id_membre = '$membre->id_membre'");
	}

	public function checkUser($pseudo, $pass){
		$req = $this->pdo->prepare('SELECT * FROM membre WHERE pseudo = :pseudo');
		$req->execute(array(
			'pseudo' => $pseudo
		));
		if(($res = $req->fetch())){
			if(password_verify($pass, $res->password)){
				unset($res->password, $res->cle_reset_pass);
				return new Membre(get_object_vars($res));
			}
		}
		return false;
	}

}
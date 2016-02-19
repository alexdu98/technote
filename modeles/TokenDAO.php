<?php

/**
 * Classe pour l'accès à la table Token
 */
class TokenDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM token WHERE id_token = :id_token');
		$req->execute(array(
			'id_token' => $id['id_token']
		));
		$res = $req->fetch();
		return new Token($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM token');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Token($ligne);
		}
		return $res;
	}

	public function save($token){
		if($token->id_token == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($token as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO token(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$token->id_token = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_token = $token->id_token;
			unset($token->id_token);
			$newValeurs = '';
			foreach($token as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE token SET $newValeurs WHERE id_token = '$id_token'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($token){
		return $this->pdo->exec("DELETE FROM token WHERE id_token = '$token->id_token'");
	}

	public function checkToken(){
		if(!empty($_COOKIE['token'])){
			$req = $this->pdo->prepare('SELECT M.id_membre, pseudo, email, bloquer, G.libelle FROM token T JOIN membre M ON M.id_membre=T.id_membre JOIN groupe G ON G.id_groupe=M.id_groupe WHERE cle = :token');
			$req->execute(array(
				'token' => $_COOKIE['token']
			));
			if($res = $req->fetch()){
				$_SESSION['connecte'] = true;
				$_SESSION['user'] = $res;
				return true;
			}
		}
		setcookie('token','', time());
		return false;
	}

}
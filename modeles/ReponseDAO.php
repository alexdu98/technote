<?php

/**
 * Classe pour l'accès à la table Reponse
 */
class ReponseDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM reponse WHERE id_reponse = :id_reponse');
		$req->execute(array(
			'id_reponse' => $id['id_reponse']
		));
		$res = $req->fetch();
		return new Reponse($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM reponse');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Reponse($ligne);
		}
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

}
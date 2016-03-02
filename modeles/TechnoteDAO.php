<?php

/**
 * Classe pour l'accès à la table Technote
 */
class TechnoteDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM technote WHERE id_technote = :id_technote');
		$req->execute(array(
			'id_technote' => $id['id_technote']
		));
		$res = $req->fetch();
		return new Technote($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM technote');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Technote($ligne);
		}
		return $res;
	}
	
	public function getNTechnotes($offset, $limit){
		$res = array();
		
		$req = $this->pdo->prepare('SELECT * FROM technote t LIMIT :limit OFFSET :offset');
		$req->bindValue(':limit', $limit, PDO::PARAM_INT);
		$req->bindValue(':offset', $offset, PDO::PARAM_INT);
		$req->execute();

		
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			$req = $this->pdo->prepare('SELECT label FROM mot_cle mc INNER JOIN decrire d ON d.id_mot_cle=mc.id_mot_cle WHERE d.id_technote = :id_technote');
			$req->execute(array(
				'id_technote' => $obj->id_technote
			));
			$res_mc = $req->fetchAll();
			$ligne['mot_cle'] = $res_mc;
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Technote($ligne);
		}
		return $res;
		
	}

	public function save($technote){
		if($technote->id_technote == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($technote as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO technote(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$technote->id_technote = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_technote = $technote->id_technote;
			unset($technote->id_technote);
			$newValeurs = '';
			foreach($technote as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE technote SET $newValeurs WHERE id_technote = '$id_technote'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($technote){
		return $this->pdo->exec("DELETE FROM technote WHERE id_technote = '$technote->id_technote'");
	}

	public function getNbRedige($id_auteur){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige FROM technote WHERE id_auteur = :id_auteur');
		$req->execute(array(
			'id_auteur' => $id_auteur
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

}
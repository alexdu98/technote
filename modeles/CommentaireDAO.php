<?php

/**
 * Classe pour l'accès à la table Commentaire
 */
class CommentaireDAO extends DAO{

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire');
		$req->execute(array(
			'id_commentaire' => $id['id_commentaire']
		));
		$res = $req->fetch();
		return new Commentaire($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM commentaire');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Commentaire($ligne);
		}
		return $res;
	}

	public function save($commentaire){
		if($commentaire->id_commentaire == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO commentaire(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$commentaire->id_technote = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_commentaire = $commentaire->id_commentaire;
			unset($commentaire->id_commentaire);
			$newValeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE commentaire SET $newValeurs WHERE id_commentaire = '$id_commentaire'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($commentaire){
		return $this->pdo->exec("DELETE FROM commentaire WHERE id_commentaire = '$commentaire->id_commentaire'");
	}

}
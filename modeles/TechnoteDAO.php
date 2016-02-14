<?php

/**
 * Classe TechnoteDAO
 * @author Alexandre CULTY
 * @version 1.0
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
			$res[] = new Technote(array(
				'id_technote' => $obj->id_technote,
				'titre' => $obj->titre,
				'date_creation' => $obj->date_creation,
				'contenu' => $obj->contenu,
				'id_auteur' => $obj->id_auteur,
				'date_modification' => $obj->date_modification,
				'id_modificateur' => $obj->id_modificateur
			));
		}
		return $res;
	}

	public function save($technote){
		if($technote->id_technote == DAO::UNKNOWN_ID){
			$res = $this->pdo->exec("INSERT INTO technote(titre, date_creation, contenu, id_auteur) VALUES(
				'$technote->titre',
				NOW(),
				'$technote->contenu',
				'$technote->id_auteur'
			)");
			$technote->id_technote = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			return $this->pdo->exec("UPDATE technote set
				titre = '$technote->titre',
				contenu = '$technote->contenu',
				date_modification = NOW(),
				id_modificateur = '$technote->id_modificateur'
			WHERE id_technote = '$technote->id_technote'");
		}
	}

	public function delete($technote){
		return $this->pdo->exec("DELETE FROM technote WHERE id_technote = '$technote->id_technote'");
	}

}
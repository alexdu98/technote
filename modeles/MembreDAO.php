<?php

/**
 * Classe MembreDAO
 * @author Alexandre CULTY
 * @version 1.0
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
			$res[] = new Membre(array(
				'id_membre' => $obj->id_membre,
				'pseudo' => $obj->pseudo,
				'email' => $obj->email,
				'password' => $obj->password,
				'date_inscription' => $obj->date_inscription,
				'date_connexion' => $obj->date_connexion,
				'id_groupe' => $obj->id_groupe,
				'cle_reset_pass' => $obj->cle_reset_pass,
				'bloquer' => $obj->bloquer
			));
		}
		return $res;
	}

	public function save($membre){
		if($membre->id_membre == DAO::UNKNOWN_ID){
			$res = $this->pdo->exec("INSERT INTO membre(pseudo, email, password, date_inscription, id_groupe, bloquer) VALUES(
				'$membre->pseudo',
				'$membre->email',
				'$membre->password',
				NOW(),
				'$membre->id_groupe',
				'$membre->bloquer'
			)");
			$membre->id_membre = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			return $this->pdo->exec("UPDATE membre set
				pseudo = '$membre->pseudo',
				email = '$membre->email',
				password = '$membre->password',
				id_groupe = '$membre->id_groupe',
				cle_reset_pass = '$membre->ce_reset_pass',
				bloquer = '$membre->bloquer',
			WHERE id_membre = '$membre->id_membre'");
		}
	}

	public function delete($membre){
		return $this->pdo->exec("DELETE FROM membre WHERE id_membre = '$membre->id_membre'");
	}

}
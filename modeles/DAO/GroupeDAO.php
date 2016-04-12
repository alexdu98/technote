<?php

/**
 * Classe pour l'accès à la table Groupe
 */
class GroupeDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM groupe WHERE id_groupe = :id_groupe');
		$req->execute(array(
			'id_groupe' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Groupe(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM groupe');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Groupe(get_object_vars($ligne));
		return $res;
	}

	public function save($groupe){
		$fields = $groupe->getFields();
		if($groupe->id_groupe == DAO::UNKNOWN_ID){
			unset($fields['id_groupe']);
			$champs = $valeurs = '';
			foreach($groupe as $nomChamp => $valeur){
				if($nomChamp == 'id_groupe') continue;
				$champs .= $nomChamp . ', ';
				if($valeur === NULL){
					$valeurs .= 'NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$valeurs .= ":$nomChamp, ";
				}
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = $this->pdo->prepare("INSERT INTO groupe($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$groupe->id_groupe = $this->pdo->lastInsertId();
				return $groupe;
			}
			return false;
		}
		else{
			unset($groupe->id_groupe);
			$newValeurs = '';
			foreach($groupe as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE groupe SET $newValeurs WHERE id_groupe = :id_groupe");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM groupe WHERE id_groupe = :id_groupe');
		return $req->execute(array(
			'id_groupe' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère un Groupe
	 * @param string $libelle Le libellé du groupe
	 * @return Groupe Le Groupe
	 */
	public function getOneByLibelle($libelle){
		$req = $this->pdo->prepare('SELECT * FROM groupe WHERE libelle = :libelle');
		$req->execute(array(
			'libelle' => $libelle
		));
		$res = $req->fetch(PDO::FETCH_ASSOC);
		return new Groupe($res);
	}

}
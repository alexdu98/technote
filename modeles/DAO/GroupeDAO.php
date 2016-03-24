<?php

/**
 * Classe pour l'accès à la table Groupe
 */
class GroupeDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne(array $id){
		$req = $this->pdo->prepare('SELECT * FROM groupe WHERE id_groupe = :id_groupe');
		$req->execute(array(
			'id_groupe' => $id['id_groupe']
		));
		$res = $req->fetch();
		return new Groupe($res);
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM groupe');
		$req->execute();
		foreach($req->fetchAll() as $obj){
			$ligne = array();
			foreach($obj as $nomChamp => $valeur){
				$ligne[$nomChamp] = $valeur;
			}
			$res[] = new Groupe($ligne);
		}
		return $res;
	}

	public function save($groupe){
		if($groupe->id_groupe == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($groupe as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO groupe(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$groupe->id_groupe = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_groupe = $groupe->id_groupe;
			unset($groupe->id_groupe);
			$newValeurs = '';
			foreach($groupe as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE groupe SET $newValeurs WHERE id_groupe = '$id_groupe'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($groupe){
		return $this->pdo->exec("DELETE FROM groupe WHERE id_groupe = '$groupe->id_groupe'");
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
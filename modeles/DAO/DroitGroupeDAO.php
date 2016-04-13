<?php

/**
 * Classe pour l'accès à la table DroitGroupe
 */
class DroitGroupeDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM droit_groupe WHERE id_groupe = :id_groupe AND type = :type AND cible = :cible');
		$req->execute(array(
			'id_groupe' => $id['id_groupe'],
			'type' => $id['type'],
			'cible' => $id['cible']
		));
		if(($res = $req->fetch()) !== false)
			return new DroitGroupe(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM droit_groupe');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new DroitGroupe(get_object_vars($ligne));
		return $res;
	}

	public function save($droitGroupe){
		$fields = $droitGroupe->getFields();
		if($droitGroupe->id_groupe == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($droitGroupe as $nomChamp => $valeur){
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
			$req = $this->pdo->prepare("INSERT INTO droit_groupe($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				return $droitGroupe;
			}
			return false;
		}
		else{
			unset($droitGroupe->type, $droitGroupe->cible, $droitGroupe->id_groupe);
			$newValeurs = '';
			foreach($droitGroupe as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE droit_groupe SET $newValeurs WHERE id_groupe = :id_groupe");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM droit_groupe WHERE id_groupe = :id_groupe AND type = :type AND cible = :cible');
		return $req->execute(array(
			'id_groupe' => $id['id_groupe'],
			'type' => $id['type'],
			'cible' => $id['cible']
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

}
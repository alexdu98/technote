<?php

/**
 * Classe pour l'accès à la table DroitMembre
 */
class DroitMembreDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM droit_membre WHERE id_membre = :id_membre AND type = :type AND cible = :cible');
		$req->execute(array(
			'id_membre' => $id['id_membre'],
			'type' => $id['type'],
			'cible' => $id['cible']
		));
		if(($res = $req->fetch()) !== false)
			return new DroitMembre(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM droit_membre');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new DroitMembre(get_object_vars($ligne));
		return $res;
	}

	public function save($droitMembre){
		$fields = $droitMembre->getFields();
		if($droitMembre->id_membre == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($droitMembre as $nomChamp => $valeur){
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
			$req = $this->pdo->prepare("INSERT INTO droit_membre($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				return $droitMembre;
			}
			return false;
		}
		else{
			unset($droitMembre->type, $droitMembre->cible, $droitMembre->id_membre);
			$newValeurs = '';
			foreach($droitMembre as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE droit_membre SET $newValeurs WHERE id_membre = :id_membre");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM droit_membre WHERE id_membre = :id_membre AND type = :type AND cible = :cible');
		return $req->execute(array(
			'id_membre' => $id['id_membre'],
			'type' => $id['type'],
			'cible' => $id['cible']
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

}
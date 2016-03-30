<?php

/**
 * Classe pour l'accès à la table Technote
 */
class TechnoteDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM technote WHERE id_technote = :id_technote');
		$req->execute(array(
			'id_technote' => $id
		));
		if(($res = $req->fetch()) === false)
			return false;

		$req = $this->pdo->prepare('SELECT label FROM mot_cle mc INNER JOIN decrire d ON d.id_mot_cle=mc.id_mot_cle WHERE d.id_technote = :id_technote');
		$req->execute(array(
			'id_technote' => $res->id_technote
		));
		$motsCles = array();
		foreach($req->fetchAll() as $ligne)
			$motsCles[] = new MotCle(get_object_vars($ligne));
		$res->motsCles = $motsCles;
		return new Technote(get_object_vars($res));
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM technote');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Technote(get_object_vars($ligne));
		return $res;
	}

	public function save($technote){
		if($technote->id_technote == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($technote as $nomChamp => $valeur){
				if($nomChamp != 'id_technote'){
					$champs .= $nomChamp . ', ';
					$valeurs .= "'$valeur', ";
				}
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO technote(' . $champs .') VALUES(' . $valeurs .')';
			if(($res = $this->pdo->exec($req)) !== false){
				$technote->id_technote = $this->pdo->lastInsertId();
				return $technote;
			}
			else
				return false;
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
		return $this->pdo->exec("DELETE FROM technote 
								WHERE id_technote = '$technote->id_technote'");
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère le nombre de technotes d'un membre
	 * @param int $id_auteur L'identifiant du membre
	 * @return int Le nombre de technotes du membre
	 */
	public function getNbRedige($id_auteur){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige 
									FROM technote 
									WHERE id_auteur = :id_auteur');
		
		$req->execute(array(
			'id_auteur' => $id_auteur
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

	/**
	 * Récupère les $limit dernières technotes
	 * @param int $limit Le nombre de technotes à récupérer
	 * @return array Le tableau des $limit dernières Technote
	 */
	public function getLastNTechnotes($limit, $offset = 0){
		$res = array();

		$req = $this->pdo->prepare('SELECT *
									FROM technote t
									ORDER BY date_creation DESC
									LIMIT :limit OFFSET :offset');

		$req->bindValue(':limit', $limit, PDO::PARAM_INT);
		$req->bindValue(':offset', $offset, PDO::PARAM_INT);
		$req->execute();


		foreach($req->fetchAll() as $obj){
			$ligne = array();
			$req = $this->pdo->prepare('SELECT mc.id_mot_cle, label
										FROM mot_cle mc
										INNER JOIN decrire d ON d.id_mot_cle=mc.id_mot_cle
										WHERE d.id_technote = :id_technote');

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

	/**
	 * Récupère le nombre de technotes total
	 * @return int Le nombre de technotes total
	 */
	public function getCount(){
		$req = $this->pdo->prepare('SELECT COUNT(*) AS nbTechnotes
									FROM technote');
		$req->execute();
		$res = $req->fetch();

		return $res->nbTechnotes;
	}

}
<?php

/**
 * Classe pour l'accès à la table Technote
 */
class TechnoteDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('
			SELECT t.*, ma.pseudo auteur, mm.pseudo modificateur
			FROM technote t
			INNER JOIN membre ma ON ma.id_membre=t.id_auteur
			LEFT JOIN membre mm ON mm.id_membre=t.id_modificateur
			WHERE id_technote = :id_technote
		');

		$req->execute(array(
			'id_technote' => $id
		));
		if(($res = $req->fetch()) === false)
			return false;

		$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
		$res->motsCles = $decrireDAO->getAllForOneTechnote($id);

		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$res->commentaires = $commentaireDAO->getTreeForOneTechnote($id, NULL);

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

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM technote WHERE id_technote = :id_technote');
		return $req->execute(array(
			'id_technote' => $id
		));
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
	public function getLastNTechnotes($max, $debut = 0){
		$res = array();

		$req = $this->pdo->prepare('SELECT t.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM technote t
									INNER JOIN membre ma ON ma.id_membre=t.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=t.id_modificateur
									ORDER BY date_creation DESC
									LIMIT :max OFFSET :debut');

		$req->bindParam(':debut', $debut, PDO::PARAM_INT);
		$req->bindParam(':max', $max, PDO::PARAM_INT);

		$req->execute();

		foreach($req->fetchAll() as $ligne){
			// Recuperation des mot-cles correspondant a la technote
			$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $decrireDAO->getAllForOneTechnote($ligne->id_technote);

			$res[] = new Technote(get_object_vars($ligne));
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

	
	/**
	 * Récupère les $limit dernières technotes
	 * @param string $author Le nom de l'auteur pour lequel on veut récupérer
	 * les technotes
	 * @return array Le tableau des technotes écries par $author
	 */
	public function getTechnotesByAuthor($author) {
		$res = array();

		$req = $this->pdo->prepare('SELECT t.*, m.pseudo auteur
									FROM technote t
									JOIN membre m ON m.id_membre = t.id_auteur
									WHERE m.pseudo = :authorName');
		
		$req->execute(array(
				'authorName' => $author
		));
		
		foreach($req->fetchAll() as $ligne){

			// Recuperation des mot-cles correspondant a la technote
			$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $decrireDAO->getAllForOneTechnote($ligne->id_technote);

			$res[] = new Technote(get_object_vars($ligne));
		}
		return $res;
	}
	
	public function getTechnotesByKeyWord($keyWord) {
		$res = array();
		$req = $this->pdo->prepare('SELECT t.*, m.pseudo auteur
									FROM technote t
									JOIN decrire d ON t.id_technote = d.id_technote
									JOIN mot_cle mc ON mc.id_mot_cle = d.id_mot_cle
									INNER JOIN membre m ON m.id_membre=t.id_auteur
									WHERE mc.label = :keyWord');
	
		$req->execute(array(
				'keyWord' => $keyWord
		));
	
		foreach($req->fetchAll() as $ligne){

			// Recuperation des mot-cles correspondant a la technote
			$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
			$ligne->motsCles  = $decrireDAO->getAllForOneTechnote($ligne->id_technote);

			$res[] = new Technote(get_object_vars($ligne));
		}
	
		return $res;
	
	}
}
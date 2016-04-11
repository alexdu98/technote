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
		$fields = $technote->getFields();
		if($technote->id_technote == DAO::UNKNOWN_ID){
			unset($fields['id_technote']);
			$champs = $valeurs = '';
			foreach($technote as $nomChamp => $valeur){
				if($nomChamp == 'id_technote') continue;
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
			$req = $this->pdo->prepare("INSERT INTO technote($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$technote->id_technote = $this->pdo->lastInsertId();
				return $technote;
			}
			return false;
		}
		else{
			unset($technote->id_technote);
			$newValeurs = '';
			foreach($technote as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
			$decrireDAO->deleteAllForOneTechnote($fields['id_technote']);
			$req = $this->pdo->prepare("UPDATE technote SET $newValeurs WHERE id_technote = :id_technote");
			return $req->execute($fields);
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
	public function getNbRedige($id_auteur, $publie = 1){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige 
									FROM technote 
									WHERE id_auteur = :id_auteur AND publie = :publie');
		
		$req->execute(array(
			'id_auteur' => $id_auteur,
			'publie' => $publie
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

	/**
	 * Récupère les $limit dernières technotes
	 * @param int $limit Le nombre de technotes à récupérer
	 * @return array Le tableau des $limit dernières Technote
	 */
	public function getLastNTechnotes($max, $debut = 0, $publie = 1){
		$res = array();

		$req = $this->pdo->prepare('SELECT t.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM technote t
									INNER JOIN membre ma ON ma.id_membre=t.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=t.id_modificateur
									WHERE publie = :publie
									ORDER BY date_creation DESC
									LIMIT :max OFFSET :debut');

		$req->bindParam(':debut', $debut, PDO::PARAM_INT);
		$req->bindParam(':max', $max, PDO::PARAM_INT);
		$req->bindParam(':publie', $publie, PDO::PARAM_INT);

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
	public function getCount($publie = 1){
		$req = $this->pdo->prepare('SELECT COUNT(*) AS nbTechnotes
									FROM technote
									WHERE publie = :publie');
		$req->execute(array(
			'publie' => $publie
		));
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
	
	public function getTechnotesRecherchees($vars) {
		$res = array();
		
		$les_mots_cles = "(";
		$les_auteurs = "(";
		
		if(!empty($vars['id_mot_cle'])){
			foreach ($vars['id_mot_cle'] as $id_mot_cle){
				$les_mots_cles += $id_mot_cle.',';
			}
			
		}
		$les_mots_cles += ')';
		
		if(!empty($vars['id_auteurs'])){
			foreach ($vars['id_auteurs'] as $id_auteur){
				$les_auteurs += $id_auteur.',';
			}
				
		}
		$les_auteurs += ')';
		
		$req = $this->pdo->prepare('SELECT t.*
									FROM technote t
									JOIN decrire d ON t.id_technote = d.id_technote
									JOIN mot_cle mc ON mc.id_mot_cle = d.id_mot_cle
									WHERE mc.id_mot_cle IN :les_mot_cles 
										AND t.id_auteur IN :les_auteurs');
	
		$req->execute(array(
				'les_mots_cles' => $les_mots_cles,
				'les_auteurs' => $les_auteurs
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
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
									WHERE id_auteur = :id_auteur AND publie = :publie AND visible = 1');
		
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
									WHERE publie = :publie AND visible = 1
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
	 * Effectue une recherche de Technote, ou compte le nombre de résultats pour cette recherche
	 * @param      $max Le nombre de technotes par page
	 * @param      $conditions Le tableau contenant les parametres de recherche
	 * @param bool $count True si c'est pour avoir le nombre de résultat (pagination), false si c'est pour avoir les technotes
	 * @param int  $debut La première technote à récupérer
	 * @return array|mixed Les technotes correspondant à la recherche
	 */
	public function getTechnotesWithSearch($max, $conditions, $count = false, $debut = 0){
		$res = array();

		$where = '';
		$join = '';
		$param = array();

		// Partie titre technote
		if(!empty($conditions['titre'])){
			$param['titre'] = '%' . $conditions['titre'] . '%';
			$where .= " AND t.titre LIKE :titre";
		}

		// Partie date
		if(!empty($conditions['date_debut']) && !empty($conditions['date_fin'])){
			$conditions['date_debut'] .= ' 00:00:00';
			$conditions['date_fin'] .= ' 23:59:59';
			$param['date_debut'] = $conditions['date_debut'];
			$param['date_fin'] = $conditions['date_fin'];
			$where .= " AND date_creation BETWEEN :date_debut AND :date_fin";
		}
		elseif(!empty($conditions['date_debut'])){
			$conditions['date_debut'] .= ' 00:00:00';
			$param['date_debut'] = $conditions['date_debut'];
			$where .= " AND date_creation BETWEEN :date_debut AND NOW()";
		}
		elseif(!empty($conditions['date_fin'])){
			$conditions['date_fin'] .= ' 23:59:59';
			$param['date_fin'] = $conditions['date_fin'];
			$where .= " AND date_creation < :date_fin";
		}

		// Partie auteur
		if(!empty($conditions['auteur'])){
			$param['auteur'] = $conditions['auteur'];
			$where .= " AND ma.pseudo = :auteur";
		}

		// Partie mots clés
		if(!empty($conditions['mots_cles'])){
			$sqlMCObligatoire = '';
			$sqlMCNonObligatoire = '';
			foreach($conditions['mots_cles'] as $mc){
				if($mc[0] == '+'){
					$sqlMCObligatoire .= '\'' . substr($mc, 1) . '\', '; // On enleve le + pour la requete
				}
				else{
					$sqlMCNonObligatoire .= '\'' . $mc . '\', ';
				}
			}
			$sqlMCObligatoire = substr($sqlMCObligatoire, 0, -2);
			$sqlMCNonObligatoire = substr($sqlMCNonObligatoire, 0, -2);
			if(!empty($sqlMCObligatoire)){
				$where .= " AND NOT EXISTS(SELECT id_mot_cle FROM mot_cle mc WHERE label IN ($sqlMCObligatoire) AND NOT EXISTS(SELECT * FROM decrire d WHERE mc.id_mot_cle=d.id_mot_cle AND d.id_technote=t.id_technote))";
			}
			else{
				$join .= ' LEFT JOIN decrire d ON d.id_technote=t.id_technote';
				$where .= " AND d.id_mot_cle IN(SELECT id_mot_cle FROM mot_cle WHERE label IN($sqlMCNonObligatoire))";
			}
		}

		// Si c'est pour savoir le nombre de résultats (pagination)
		if($count){
			$sql = 'SELECT COUNT(DISTINCT t.id_technote) nbRes
									FROM technote t
									INNER JOIN membre ma ON ma.id_membre=t.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=t.id_modificateur
									' . $join . '
									WHERE publie = 1 AND visible = 1
									' . $where;
			$req = $this->pdo->prepare($sql);
			$req->execute($param);
			$res = $req->fetch();
			return $res->nbRes;
		}

		$sql = 'SELECT DISTINCT t.*, ma.pseudo auteur, mm.pseudo modificateur
									FROM technote t
									INNER JOIN membre ma ON ma.id_membre=t.id_auteur
									LEFT JOIN membre mm ON mm.id_membre=t.id_modificateur
									' . $join . '
									WHERE publie = 1 AND visible = 1
									' . $where . '
									ORDER BY date_creation DESC
									LIMIT ' . $debut . ', ' . $max; // Ne peut pas etre preparé car échapé (LIMIT '9', '0' => FAIL)

		$req = $this->pdo->prepare($sql);

		$req->execute($param);

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
									WHERE publie = :publie AND visible = 1');
		$req->execute(array(
			'publie' => $publie
		));
		$res = $req->fetch();

		return $res->nbTechnotes;
	}

	public function getCountPublie(){
		$req = $this->pdo->prepare('SELECT COUNT(*) publie
									FROM technote
									WHERE publie = 1');

		$req->execute();
		$res = $req->fetch();
		return $res->publie;
	}

	public function getCountNonPublie(){
		$req = $this->pdo->prepare('SELECT COUNT(*) nonPublie
									FROM technote
									WHERE publie = 0');

		$req->execute();
		$res = $req->fetch();
		return $res->nonPublie;
	}

	public function getAllTitreComposedOf($exp){
		$req = $this->pdo->prepare('SELECT titre FROM technote WHERE publie = 1 AND visible = 1 AND titre LIKE :exp');
		$req->execute(array(
			'exp' => '%' . $exp . '%'
		));
		return $req->fetchAll();
	}

	public function noVisible($id){
		$req = $this->pdo->prepare('UPDATE technote SET visible = 0 WHERE id_technote = :id_technote');
		return $req->execute(array(
			'id_technote' => $id
		));
	}

}
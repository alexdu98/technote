<?php

/**
 * Classe pour l'accès à la table Commentaire
 */
class CommentaireDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT c.*, ma.pseudo auteur, mm.pseudo modificateur FROM commentaire c INNER JOIN membre ma ON ma.id_membre=c.id_auteur LEFT JOIN membre mm ON mm.id_membre=c.id_modificateur WHERE id_commentaire = :id_commentaire');
		$req->execute(array(
			'id_commentaire' => $id
		));
		if(($res = $req->fetch()) !== false)
			return new Commentaire(get_object_vars($res));
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM commentaire');
		$req->execute();
		foreach($req->fetchAll() as $ligne)
			$res[] = new Commentaire(get_object_vars($ligne));
		return $res;
	}

	public function save($commentaire){
		$fields = $commentaire->getFields();
		if($commentaire->id_commentaire == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
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
			$req = $this->pdo->prepare("INSERT INTO commentaire($champs) VALUES($valeurs)");
			if($req->execute($fields)){
				$commentaire->id_commentaire = $this->pdo->lastInsertId();
				return $commentaire;
			}
			return false;
		}
		else{
			unset($commentaire->id_commentaire);
			$newValeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
				if($valeur === NULL){
					$newValeurs .= $nomChamp . ' = NULL, ';
					unset($fields[$nomChamp]);
				}
				else{
					$newValeurs .= "$nomChamp = :$nomChamp, ";
				}
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = $this->pdo->prepare("UPDATE commentaire SET $newValeurs WHERE id_commentaire = :id_commentaire");
			return $req->execute($fields);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM commentaire WHERE id_commentaire = :id_commentaire');
		return $req->execute(array(
			'id_commentaire' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère le nombre de commentaires d'un membre
	 * @param int $id_auteur L'identifiant du membre
	 * @return int Le nombre de commentaires du membre
	 */
	public function getNbRedige($id_auteur){
		$req = $this->pdo->prepare('SELECT COUNT(*) nbRedige FROM commentaire WHERE id_auteur = :id_auteur');
		$req->execute(array(
			'id_auteur' => $id_auteur
		));
		$res = $req->fetch();
		return $res->nbRedige;
	}

	public function getTreeForOneTechnote($id_technote, $id_commentaire_parent){
		$res = array();
		$op = empty($id_commentaire_parent) ? 'IS' : '=';
		$req = $this->pdo->prepare('SELECT c.*, ma.pseudo auteur, mm.pseudo modificateur FROM commentaire c INNER JOIN membre ma ON ma.id_membre=c.id_auteur LEFT JOIN membre mm ON mm.id_membre=c.id_modificateur WHERE id_technote = :id_technote AND id_commentaire_parent ' . $op . ' :id_commentaire_parent');
		$req->execute(array(
			'id_technote' => $id_technote,
			'id_commentaire_parent' => $id_commentaire_parent
		));
		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		foreach($req->fetchAll() as $ligne){
			$ligne->commentaires = $commentaireDAO->getTreeForOneTechnote($id_technote, $ligne->id_commentaire);
			$res[] = new Commentaire(get_object_vars($ligne));
		}
		return $res;
	}

}
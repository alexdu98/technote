<?php

/**
 * Classe pour l'accès à la table Commentaire
 */
class CommentaireDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire');
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
		if($commentaire->id_commentaire == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
				$champs .= $nomChamp . ', ';
				$valeurs .= "'$valeur', ";
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO commentaire(' . $champs .') VALUES(' . $valeurs .')';
			$res = $this->pdo->exec($req);
			$commentaire->id_technote = $this->pdo->lastInsertId();
			return $res;
		}
		else{
			$id_commentaire = $commentaire->id_commentaire;
			unset($commentaire->id_commentaire);
			$newValeurs = '';
			foreach($commentaire as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE commentaire SET $newValeurs WHERE id_commentaire = '$id_commentaire'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($commentaire){
		return $this->pdo->exec("DELETE FROM commentaire WHERE id_commentaire = '$commentaire->id_commentaire'");
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

}
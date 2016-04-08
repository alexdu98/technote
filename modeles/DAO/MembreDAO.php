<?php

/**
 * Classe pour l'accès à la table Membre
 */
class MembreDAO extends DAO{

	// #######################################
	// ########## MÉTHODES HÉRITÉES ##########
	// #######################################

	public function getOne($id){
		$req = $this->pdo->prepare('SELECT * FROM membre WHERE id_membre = :id_membre');
		$req->execute(array(
			'id_membre' => $id
		));
		if(($res = $req->fetch()) !== false){
			unset($res->password, $res->cle_reset_pass);
			return new Membre(get_object_vars($res));
		}
		return false;
	}

	public function getAll(){
		$res = array();
		$req = $this->pdo->prepare('SELECT * FROM membre');
		$req->execute();
		foreach($req->fetchAll() as $ligne){
			unset($ligne->password, $ligne->cle_reset_pass);
			$res[] = new Membre(get_object_vars($ligne));
		}
		return $res;
	}

	public function save($membre){
		if($membre->id_membre == DAO::UNKNOWN_ID){
			$champs = $valeurs = '';
			foreach($membre as $nomChamp => $valeur){
				if($nomChamp !== 'id_membre') {
					$champs .= $nomChamp . ', ';
					$valeurs .= "'$valeur', ";
				}
			}
			$champs = substr($champs, 0, -2);
			$valeurs = substr($valeurs, 0, -2);
			$req = 'INSERT INTO membre(' . $champs .') VALUES(' . $valeurs .')';
			if(($res = $this->pdo->exec($req)) !== false){
				$membre->id_membre = $this->pdo->lastInsertId();
				return $membre;
			}
			return $res;
		}
		else{
			$id_membre = $membre->id_membre;
			unset($membre->id_membre);
			$newValeurs = '';
			foreach($membre as $nomChamp => $valeur){
				$newValeurs .= $nomChamp . " = '" . $valeur . "', ";
			}
			$newValeurs = substr($newValeurs, 0, -2);
			$req = "UPDATE membre SET $newValeurs WHERE id_membre = '$id_membre'";
			return $this->pdo->exec($req);
		}
	}

	public function delete($id){
		$req = $this->pdo->prepare('DELETE FROM membre WHERE id_membre = :id_membre');
		return $req->execute(array(
			'id_membre' => $id
		));
	}

	// #######################################
	// ######## MÉTHODES PERSONNELLES ########
	// #######################################

	/**
	 * Récupère un Membre grâce à son pseudo
	 * @param string $pseudo Le pseudo du membre à récupérer
	 * @return bool|\Membre False si aucun membre avec ce pseudo, Membre sinon
	 */
	public function getOneByPseudo($pseudo){
		$req = $this->pdo->prepare('SELECT m.*, g.libelle groupe FROM membre m INNER JOIN groupe g ON g.id_groupe=m.id_groupe WHERE pseudo = :pseudo');
		$req->execute(array(
			'pseudo' => $pseudo
		));
		if(($res = $req->fetch()) !== false)
			return new Membre(get_object_vars($res));
		return false;
	}

	/**
	 * Vérifie le mot de passe d'un membre
	 * @param string $pseudo Le pseudo du membre
	 * @param string $pass Le mot de passe du membre
	 * @return bool False si le mot de passe ne correspond pas, True sinon
	 */
	public function checkUserPass($pseudo, $pass){
		$req = $this->pdo->prepare('SELECT password FROM membre WHERE pseudo = :pseudo');
		$req->execute(array(
			'pseudo' => $pseudo
		));
		if(($res = $req->fetch()))
			return password_verify($pass, $res->password);
		return false;
	}

	/**
	 * Modifie la date de dernière connexion d'un membre
	 * @param string $pseudo Le pseudo du membre que l'on doit mettre à jour
	 * @return bool|Membre False si aucun membre avec ce pseudo, Membre sinon
	 */
	public function connexion($pseudo){
		$this->pdo->exec("UPDATE membre SET date_connexion = NOW() WHERE pseudo = '$pseudo'");
		return $this->getOneByPseudo($pseudo);
	}

	/**
	 * Vérifie qu'un pseudo ou email existe
	 * @param string $pseudoEmail Un pseudo ou un email
	 * @return bool|\Membre False si aucun membre avec ce pseudo ou email, Membre sinon
	 */
	public function checkMembreExiste($pseudoEmail){
		$req = $this->pdo->prepare('SELECT id_membre, pseudo, email FROM membre WHERE pseudo = :pseudoEmail OR email = :pseudoEmail');
		$req->execute(array(
			'pseudoEmail' => $pseudoEmail
		));
		if(($res = $req->fetch()) !== false)
			return new Membre(get_object_vars($res));
		else
			return false;
	}

	/**
	 * Vérifie la clé de réinitialisation du mot de passe
	 * @param string $cle La clé de réinitialisation
	 * @return bool|\Membre False si aucun membre avec cette clé, le Membre de la clé sinon
	 */
	public function checkCleResetPass($cle){
		$req = $this->pdo->prepare('SELECT id_membre FROM membre WHERE cle_reset_pass = :cle_reset_pass');
		$req->execute(array(
			'cle_reset_pass' => $cle
		));
		if(($res = $req->fetch()))
			return new Membre(get_object_vars($res));
		else
			return false;
	}

}
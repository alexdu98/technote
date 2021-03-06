<?php

class Membre extends TableObject{

	static public function getStat(){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$arr['total'] = $membreDAO->getCount();
		$arr['bloque'] = $membreDAO->getCountBloque();
		return $arr;
	}

	static public function edit(&$param, $id){
		$std = (object) array('success' => false, 'msg' => array());

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$membreOld = $membreDAO->getOne($id);

		if($membreOld->pseudo != $param['pseudo']){
			if(($res = Membre::checkPseudo($param['pseudo'])) !== true)
				$std->msg[] = $res;
		}
		if($membreOld->email != $param['email']){
			if(($res = Membre::checkEmail($param['email'])) !== true)
				$std->msg[] = $res;
		}
		$groupeDAO = new GroupeDAO(BDD::getInstancePDO());
		if(($res = $groupeDAO->getone($param['groupe'])) === false)
			$std->msg[] = 'Ce groupe n\'existe pas';
		if($param['bloquer'] != 0 && $param['bloquer'] != 1)
			$std->msg[] = 'Le champ bloquer n\'est pas valide';

		if(!empty($std->msg))
			return $std;

		$membre = new Membre(array(
			'id_membre' => $id,
			'pseudo' => $param['pseudo'],
			'email' => $param['email'],
			'id_groupe' => $param['groupe'],
			'bloquer' => $param['bloquer']
		));
		if(($std->success = $membreDAO->save($membre)) === true)
			$std->msg[] = 'Membre modifié avec succès';
		else
			$std->msg[] = 'Erreur BDD';

		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => "Modification d\'un membre (membre n°$id : $membreOld->pseudo)",
			'id_membre' => $_SESSION['user']->id_membre
		));
		$actionDAO->save($action);

		return $std;
	}

	static public function delete($id){
		$std = (object) array('success' => false, 'msg' => array());

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$membre = $membreDAO->getOne($id);

		if(($std->success = $membreDAO->delete($id)) === true)
			$std->msg[] = 'Membre supprimé avec succès';
		else
			$std->msg[] = 'Erreur BDD';

		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => "Suppression d\'un membre (membre n°$id : $membre->pseudo)",
			'id_membre' => $_SESSION['user']->id_membre
		));
		$actionDAO->save($action);

		return $std;
	}

	/**
	 * @return \stdClass Objet Contient les informations du profil d'un membre
	 */
	public function getProfil(){
		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$res = new stdClass();
		$res->nbTokenActif = $tokenDAO->getNbActif($this->id_membre);
		$res->tokenActif = $tokenDAO->getActif($this->id_membre);
		$res->nbTechnoteRedige = $technoteDAO->getNbRedige($this->id_membre);
		$res->nbCommentaireRedige = $commentaireDAO->getNbRedige($this->id_membre);
		$res->nbQuestionRedige = $questionDAO->getNbRedige($this->id_membre);
		$res->nbReponseRedige = $reponseDAO->getNbRedige($this->id_membre);
		$res->actions = $actionDAO->getLast($this->id_membre);
		return $res;
	}

	public function rechargerProfil(){
		// Recupère les variables utilisateurs
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$_SESSION['user'] = $membreDAO->getOne($this->id_membre);

		// Récupère les doits du groupe du membre
		$droitGroupeDAO = new DroitGroupeDAO(BDD::getInstancePDO());
		$_SESSION['droits']['groupe'] = $droitGroupeDAO->getAllForOneGroupeTree($_SESSION['user']->id_groupe);

		// Récupère les doits du membre
		$droitMembreDAO = new DroitMembreDAO(BDD::getInstancePDO());
		$_SESSION['droits']['membre'] = $droitMembreDAO->getAllForOneMembre($_SESSION['user']->id_membre);
	}

	/**
	 * Connecte un membre
	 * @param array $param Les attributs pour se connecter
	 * @return object 2 attributs, bool success et string msg
	 * @static
	 */
	static public function connexion(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(empty($param['pseudo'])){
			$std->msg[] = 'Le pseudo n\'est pas renseigné';
			return $std;
		}
		elseif(empty($param['password'])){
			$std->msg[] = 'Le mot de passe n\'est pas renseigné';
			return $std;
		}

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($param['pseudo'], $param['password']) === true){
			if(($res = $membreDAO->connexion($param['pseudo'])) !== false){
				if(!$res->bloquer){
					$_SESSION['user'] = $res;

					// Récupère les doits du groupe du membre
					$droitGroupeDAO = new DroitGroupeDAO(BDD::getInstancePDO());
					$_SESSION['droits']['groupe'] = $droitGroupeDAO->getAllForOneGroupeTree($_SESSION['user']->id_groupe);

					// Récupère les doits du membre
					$droitMembreDAO = new DroitMembreDAO(BDD::getInstancePDO());
					$_SESSION['droits']['membre'] = $droitMembreDAO->getAllForOneMembre($_SESSION['user']->id_membre);

					$jeton = '';
					if(isset($param['autoConnexion']) && $param['autoConnexion'] == 'on'){
						Token::createToken();
						$jeton = ' avec jeton';
					}
					$actionDAO = new ActionDAO(BDD::getInstancePDO());
					$action = new Action(array(
						'id_action' => DAO::UNKNOWN_ID,
						'libelle' => "Connexion$jeton ($_SERVER[REMOTE_ADDR])",
						'id_membre' => $_SESSION['user']->id_membre
					));
					$actionDAO->save($action);
					$std->success = true;
					return $std;
				}
				else
					$std->msg[] = 'Votre compte a été bloqué';
			}
			else
				$std->msg[] = 'Erreur BDD';
		}
		else
			$std->msg[] = 'Couple login / mot de passe incorrect';
		return $std;
	}

	static public function connexionAdmin(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(empty($param['mdp'])){
			$std->msg[] = 'Le mot de passe n\'est pas renseigné';
			return $std;
		}

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($_SESSION['user']->pseudo, $param['mdp']) === true){
			$actionDAO = new ActionDAO(BDD::getInstancePDO());
			$action = new Action(array(
				'id_action' => DAO::UNKNOWN_ID,
				'libelle' => "Connexion à l\'administration ($_SERVER[REMOTE_ADDR])",
				'id_membre' => $_SESSION['user']->id_membre
			));
			$actionDAO->save($action);
			$std->success = true;
			$_SESSION['admin'] = true;
			return $std;
		}
		else
			$std->msg[] = 'Mot de passe incorrect';
		return $std;
	}

	/**
	 * Vérifie et inscrit un membre
	 * @param array $param Les attributs de l'inscription d'un membre
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static public function inscription(&$param){
		// Verification sur les champs du formulaire
		$resCheck = self::checkInscription($param);
		$res = $resCheck;
		
		// Si le formulaire a bien ete rempli 
		if($resCheck->success === true){
			
			// Creation de l'objet Membre
			$groupeDAO = new GroupeDAO(BDD::getInstancePDO());
			$groupe = $groupeDAO->getOneByLibelle('membre');
			$membre = new Membre(array(
				'id_membre' => DAO::UNKNOWN_ID,
				'pseudo' => $param['pseudo'],
				'email' => $param['email'],
				'password' => Membre::cryptMDP($param['password']),
				'id_groupe' => $groupe->id_groupe,
				'bloquer' => 0
			));
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			
			// Sauvegarde de l'objet Membre dans la BDD
			if(($resSave = $membreDAO->save($membre)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => 'Inscription',
					'id_membre' => $resSave->id_membre
				));
				$actionDAO->save($action);
				$params = array(
					'pseudo' => $param['pseudo'],
					'sujet' => 'Inscription'
				);
				$mail = new Mail($param['email'], '[Technote] Inscription', 'mail_inscription.twig', $params);
				$mail->sendMail();
				$res->success = true;
				$res->msg[] = 'Inscription réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie les attributs de l'inscription
	 * @param array $param Les attributs à vérifier
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static private function checkInscription(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		$captcha = new Captcha();
		if(($res = $captcha->check($param['g-recaptcha-response'])) === true){
			if(($res = Membre::checkPseudo($param['pseudo'])) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkEmail($param['email'])) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkPass($param['password'], $param['passwordConfirm'])) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkConditions($param['conditions'])) !== true)
				$std->msg[] = $res;
		}
		else
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	/**
	 * Édite le profil d'un membre
	 * @param array $param Les attributs de l'édition de profil
	 * @return object 2 attributs, bool success et array string msg
	 */
	public function editProfil(&$param){
		$resCheck = $this->checkEdit($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$array = array('id_membre' => $_SESSION['user']->id_membre);
			if(!empty($param['email']))
				$array['email'] = $param['email'];
			elseif(!empty($param['passwordNew']))
				$array['password'] = Membre::cryptMDP($param['passwordNew']);
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			$membre = new Membre($array);
			if(($resSave = $membreDAO->save($membre)) !== false){
				$_SESSION['user'] = $membreDAO->getOneByPseudo($_SESSION['user']->pseudo);
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => 'Mise à jour du profil',
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Mise à jour réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie les attributs de l'édition d'un membre
	 * @param array $param Les attributs à vérifier
	 * @return object 2 attributs, bool success et array string msg
	 */
	private function checkEdit(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(!empty($param['updateEmail'])){
			if(($res = Membre::checkEmail($param['email'])) !== true)
				$std->msg[] = $res;
		}
		elseif(!empty($param['updateMDP'])){
			if(($res = Membre::checkPassUser($param['passwordNow'])) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkPass($param['passwordNew'], $param['passwordNewConfirm'])) !== true)
				$std->msg[] = $res;
		}
		else{
			$std->msg[] = 'Aucun formulaire rempli';
		}

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	/**
	 * Vérifie et réinitialise un mot de passe perdu
	 * @param array $param Les attributs de la réinitialisation du mot de passe
	 * @return object 2 attributs, bool success et array string msg
	 */
	public function resetLostPass(&$param){
		$resCheck = $this->checkResetPassword($param);
		$res = $resCheck;
		if($resCheck->success === true){
			$membre = new Membre(array(
				'id_membre' => $this->id_membre,
				'password' => Membre::cryptMDP($param['passwordNew']),
				'cle_reset_pass' => ''
			));
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if(($resSave = $membreDAO->save($membre)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => 'Oubli de mot de passe (modification du mot de passe)',
					'id_membre' => $this->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Mise à jour du mot de passe réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie la demande de réinitialisation du mot de passe
	 * @param array $param  Les attributs de la demande de réinitialisation du mot de passe
	 * @return object 2 attributs, bool success et array string msg
	 */
	private function checkResetPassword(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		$captcha = new Captcha();
		if(($res = $captcha->check($param['g-recaptcha-response'])) === true){
			if(($res = Membre::checkPass($param['passwordNew'], $param['passwordNewConfirm'])) !== true)
				$std->msg[] = $res;
		}
		else
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}


	/**
	 * Vérifie la validité du mot de passe d'un membre
	 * @param string $pass Le mot de passe à vérifier
	 * @return bool|string  True si le mot de passe correspond au membre, un message sinon
	 * @static
	 */
	static public function checkPassUser(&$pass){
		if(!empty($pass)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if($membreDAO->checkUserPass($_SESSION['user']->pseudo, $pass) !== false)
				return true;
			return 'Le mot de passe actuel est incorrect';
		}
		else
			return 'Le mot de passe actuel n\'est pas renseigné';
	}

	/**
	 * Vérifie la validité d'un pseudo
	 * @param string $pseudo Le pseudo à vérifier
	 * @return bool|string  True si le pseudo est valide, un message sinon
	 * @static
	 */
	static public function checkPseudo(&$pseudo){
		if(!empty($pseudo)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if($membreDAO->checkMembreExiste($pseudo) === false){
				if(mb_strlen($pseudo) >= 3 && mb_strlen($pseudo) <= 31){
					if(preg_match('#[a-zA-Z0-9]+#', $pseudo)){
						return true;
					}
					return 'Le pseudo ne respecte pas les règles de composition (alphanumérique)';
				}
				return 'Le pseudo ne respecte pas les règles de longueur (3 à 31 caractères)';
			}
			else
				return 'Le pseudo est déjà utilisé';
		}
		return 'Le pseudo n\'est pas renseigné';
	}

	/**
	 * Vérifie la validité d'un email
	 * @param string $email L'email à vérifier
	 * @return bool|string  True si l'email est valide, un message sinon
	 * @static
	 */
	static public function checkEmail(&$email){
		if(!empty($email)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if($membreDAO->checkMembreExiste($email) === false){
				if(filter_var($email, FILTER_VALIDATE_EMAIL))
					return true;
				return 'L\'email n\'est pas valide';
			}
			else
				return 'L\'email est déjà utilisé';
		}
		return 'L\'email n\'est pas renseigné';
	}

	/**
	 * Vérifie un mot de passe et sa confirmation
	 * @param string $pass Le mot de passe à vérifier
	 * @param string $passConfirm La confirmation du mot de passe à vérifier
	 * @return bool|string True si le mot de passe est valide, un message sinon
	 * @static
	 */
	static public function checkPass(&$pass, &$passConfirm){
		if(!empty($pass) && !empty($passConfirm)){
			if($pass == $passConfirm){
				if(mb_strlen($pass) >= 6 && mb_strlen($pass) <= 32){
					if(preg_match('#.*[a-zA-Z]+.*[0-9]+.*|.*[0-9]+.*[a-zA-Z]+.*#', $pass)){
						return true;
					}
					return 'Le mot de passe ne respecte pas les règles de composition (au moins un chiffre et une lettre)';
				}
				return 'Le mot de passe ne respecte pas les règles de longueur (6 à 32 caractères)';
			}
			return 'Le mot de passe et sa confirmation ne correspondent pas';
		}
		return 'Le mot de passe et/ou sa confirmation n\'est pas renseigné';
	}

	/**
	 * Hashe un mot de passe
	 * @param string $pass Le mot de passe à hashé
	 * @return bool|string False si erreur de hashage, le mot de passe hashé sinon
	 * @static
	 */
	static public function cryptMDP($pass){
		return password_hash($pass, PASSWORD_BCRYPT, array('cost' => 12));
	}

	/**
	 * Vérifie que les conditions d'utilisation soient acceptées
	 * @param string $conditions Les conditions à vérifier
	 * @return bool|string True si les conditions sont acceptées, un message sinon
	 * @static
	 */
	static public function checkConditions(&$conditions){
		if(!empty($conditions) && $conditions == 'on')
			return true;
		return 'Les conditions d\'utilisation ne sont pas acceptées';
	}

	/**
	 * Vérifie que l'email d'oubli de mot de passe peut etre envoyé
	 * @param array $param Les attributs de la demande d'envoi d'email
	 * @return object True si l'email peut etre envoyé, un message sinon
	 * @static
	 */
	static public function checkSendMailLostPass(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		$captcha = new Captcha();
		if(($res = $captcha->check($param['g-recaptcha-response'])) === true){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if(empty($param['pseudoEmail'])){
				$std->msg[] = 'Le pseudo ou l\'email n\'est pas renseigné';
				return $std;
			}
			if(($res = $membreDAO->checkMembreExiste($param['pseudoEmail'])) === false)
				$std->msg[] = 'Le pseudo ou l\'email n\'existe pas';
			else
				return $res;
		}
		else
			$std->msg[] = $res;

		return $std;
	}

	/**
	 * Vérifie que le mot de passe peut etre modifié par oublie
	 * @param array $param Les attributs de la demande de réinitialisation du mot de passe
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static public function sendMailLostPass(&$param){
		$resCheck = self::checkSendMailLostPass($param);
		$res = $resCheck;
		if(!isset($resCheck->success)){
			$membreRes = $resCheck;
			$cle = hash('sha256', uniqid(rand(), true) . SALT_RESET_PASS);
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			$membre = new membre(array(
				'id_membre' => $membreRes->id_membre,
				'cle_reset_pass' => $cle
			));
			if(($resSave = $membreDAO->save($membre)) !== false){
				$param = array(
					'pseudo' => $membreRes->pseudo,
					'sujet' => 'Oubli de mot de passe',
					'cle' => $cle
				);
				$mail = new Mail($membreRes->email, '[Technote] Oubli de mot de passe', 'mail_lostPass.twig', $param);
				$resMail = $mail->sendMail();
				$res = $resMail;
				if($resMail->success === true){
					$actionDAO = new ActionDAO(BDD::getInstancePDO());
					$action = new Action(array(
						'id_action' => DAO::UNKNOWN_ID,
						'libelle' => 'Oubli de mot de passe (création de la clé)',
						'id_membre' => $membreRes->id_membre
					));
					$actionDAO->save($action);
					$res->success = true;
					$res->msg[0] = 'Un email vous a été envoyé, merci de suivre les instructions';
				}
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

}
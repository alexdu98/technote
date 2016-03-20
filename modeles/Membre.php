<?php

class Membre extends TableObject{

	public function getProfil(){
		$tokenDAO = new TokenDAO(BDD::getInstancePDO());
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
		$questionDAO = new QuestionDAO(BDD::getInstancePDO());
		$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$res['nbTokenActif'] = $tokenDAO->getNbActif($this->id_membre);
		$res['tokenActif'] = $tokenDAO->getActif($this->id_membre);
		$res['nbTechnoteRedige'] = $technoteDAO->getNbRedige($this->id_membre);
		$res['nbCommentaireRedige'] = $commentaireDAO->getNbRedige($this->id_membre);
		$res['nbQuestionRedige'] = $questionDAO->getNbRedige($this->id_membre);
		$res['nbReponseRedige'] = $reponseDAO->getNbRedige($this->id_membre);
		$res['actions'] = $actionDAO->getLast($this->id_membre);
		return $res;
	}

	static public function connexion(&$param){
		$std = (object) array('success' => false, 'message' => '');

		if(empty($param['pseudo'])){
			$std->message = 'Le pseudo n\'est pas renseigné';
			return $std;
		}
		elseif(empty($param['password'])){
			$std->message = 'Le mot de passe n\'est pas renseigné';
			return $std;
		}

		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($param['pseudo'], $param['password']) === true){
			if(($res = $membreDAO->connexion($param['pseudo'])) !== false){
				if(!$res->bloquer){
					$_SESSION['user'] = $res;
					$jeton = '';
					if($param['autoConnexion'] == 'on'){
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
				$std->message = 'Votre compte a été bloqué';
			}
			$std->message = 'Erreur BDD';
		}
		$std->message = 'Couple login / mot de passe incorrect';
	}

	static public function inscription(&$param){
		$resCheck = self::checkInscription($param);
		$res = $resCheck;
		if($resCheck->success === true){
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
			if(($resSave = $membreDAO->save($membre)) !== false){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => 'Inscription',
					'id_membre' => $resSave->id_membre
				));
				$actionDAO->save($action);
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

	static private function checkInscription(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(($res = Membre::checkPseudo($param['pseudo'])) !== true)
			$std->msg[] = $res;
		if(($res = Membre::checkEmail($param['email'])) !== true)
			$std->msg[] = $res;
		if(($res = Membre::checkPass($param['password'], $param['passwordConfirm'])) !== true)
			$std->msg[] = $res;
		if(($res = Membre::checkConditions($param['conditions'])) !== true)
			$std->msg[] = $res;
		$captcha = new Captcha();
		if(($res = $captcha->check($param['g-recaptcha-response'])) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

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

	private function checkEdit(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(!empty($param['email']) && ($res = Membre::checkEmail($param['email'])) !== true)
			$std->msg[] = $res;
		elseif(!empty($param['passwordNow']) || !empty($param['password']) || !empty($param['passwordConfirm'])){
			if(($res = Membre::checkPassUser($param['passwordNow'])) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkPass($param['password'], $param['passwordConfirm'])) !== true)
				$std->msg[] = $res;
		}
		if(empty($param['email']) && empty($param['passwordNow']) && empty($param['password']) && empty($param['passwordConfirm'])){
			$std->msg[] = 'Aucun formulaire rempli';
			return $std;
		}

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

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

	private function checkResetPassword(&$param){
		$std = (object) array('success' => false, 'msg' => array());

		if(($res = Membre::checkPass($param['passwordNew'], $param['passwordNewConfirm'])) !== true)
			$std->msg[] = $res;
		$captcha = new Captcha();
		if(($res = $captcha->check($param['g-recaptcha-response'])) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static public function checkPassUser($pass){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		if($membreDAO->checkUserPass($_SESSION['user']->pseudo, $pass) !== false)
			return true;
		return 'Le mot de passe actuel est incorrect';
	}

	static public function checkPseudo($pseudo){
		if(!empty($pseudo)){
			if(mb_strlen($pseudo) >= 3 && mb_strlen($pseudo) <= 31){
				if(preg_match('#[a-zA-Z0-9]+#', $pseudo)){
					return true;
				}
				return 'Le pseudo ne respecte pas les règles de composition (alphanumérique)';
			}
			return 'Le pseudo ne respecte pas les règles de longueur (3 à 31 caractères)';
		}
		return 'Le pseudo n\'est pas renseigné';
	}

	static public function checkEmail($email){
		if(!empty($email)){
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
				return true;
			return 'L\'email n\'est pas valide';
		}
		return 'L\'email n\'est pas renseigné';
	}

	static public function checkPass($pass, $passConfirm){
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

	static public function cryptMDP($pass){
		return password_hash($pass, PASSWORD_BCRYPT, array('cost' => 12));
	}

	static public function checkConditions($conditions){
		if(!empty($conditions) && $conditions == 'on')
			return true;
		return 'Les conditions d\'utilisation ne sont pas acceptées';
	}

	public function lostPass(){
		$cle = hash('sha256', uniqid(rand(), true) . SALT_RESET_PASS);
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		$membre = new membre(array(
			'id_membre' => $this->id_membre,
			'cle_reset_pass' => $cle
		));
		$membreDAO->save($membre);
		$param = array(
			'pseudo' => $this->pseudo,
			'cle' => $cle
		);
		$mail = new Mail($this->email, '[Technote.dev] Oubli de mot de passe', 'mail_lostPass.twig', $param);
		return $mail->sendMail();
	}

}
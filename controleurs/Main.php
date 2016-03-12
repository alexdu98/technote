<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $param, $vars = array()){
		$vars["accueil"] = 1; // Pour rendre actif l'onglet de la barre de menu 
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['tn'] = $technoteDAO->getNTechnotes(0, 3);
				$this->vue->chargerVue('accueil_' . $action, $vars);
				break;
			case 'add':
				//break;
			case 'edit':
				//break;
			case 'drop':
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function membre($action, $param){
		$vars = array();
		$vars["profile"] = 1; // Pour rendre actif l'onglet de la barre de menu
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				if($_SESSION['user']){
					$tokenDAO = new TokenDAO(BDD::getInstancePDO());
					$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
					$commentaireDAO = new CommentaireDAO(BDD::getInstancePDO());
					$questionDAO = new QuestionDAO(BDD::getInstancePDO());
					$reponseDAO = new ReponseDAO(BDD::getInstancePDO());
					$actionDAO = new ActionDAO(BDD::getInstancePDO());
					$vars['nbTokenActif'] = $tokenDAO->getNbActif($_SESSION['user']->id_membre);
					$vars['tokenActif'] = $tokenDAO->getActif($_SESSION['user']->id_membre);
					$vars['nbTechnoteRedige'] = $technoteDAO->getNbRedige($_SESSION['user']->id_membre);
					$vars['nbCommentaireRedige'] = $commentaireDAO->getNbRedige($_SESSION['user']->id_membre);
					$vars['nbQuestionRedige'] = $questionDAO->getNbRedige($_SESSION['user']->id_membre);
					$vars['nbReponseRedige'] = $reponseDAO->getNbRedige($_SESSION['user']->id_membre);
					$vars['actions'] = $actionDAO->getLast($_SESSION['user']->id_membre);
					$this->vue->chargerVue('membre_' . $action, $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'add':
				if(!$_SESSION['user']){
					if(!empty($_POST)){
						if(($res = Membre::checkAdd($_POST)) === true){
							$groupeDAO = new GroupeDAO(BDD::getInstancePDO());
							$groupe = $groupeDAO->getOneByLibelle('membre');
							$membre = new Membre(array(
								'id_membre' => DAO::UNKNOWN_ID,
								'pseudo' => $_POST['pseudo'],
								'email' => $_POST['email'],
								'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 12)),
								'id_groupe' => $groupe->id_groupe,
								'bloquer' => 0
							));
							if($membreDAO->save($membre)){
								$this->action('Inscription');
								$vars['res'] = array('success' => true, 'msg' => 'Inscription réussie');
								unset($_POST);
							}
							else
								$vars['res'] = array('success' => false, 'msg' => 'Erreur BDD');
						}
						else
							$vars['res'] = array('success' => false, 'msg' => $res);
					}
					$this->vue->chargerVue('membre_' . $action, $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'edit':
				if($_SESSION['user']){
					if(!empty($_POST)){
						if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
							if(($res = Membre::checkEdit($_POST)) === true){
								$array = array('id_membre' => $_SESSION['user']->id_membre);
								if(!empty($_POST['email']))
									$array['email'] = $_POST['email'];
								if(!empty($_POST['passwordNew']))
									$array['password'] = password_hash($_POST['passwordNew'], PASSWORD_BCRYPT, array('cost' => 12));
								$membre = new Membre($array);
								if($membreDAO->save($membre)){
									$_SESSION['user'] = $membreDAO->getOneByPseudo($_SESSION['user']->pseudo);
									$this->action('Mise à jour du profil');
									$vars['res'] = array('success' => true, 'msg' => 'Mise à jour réussie');
								}else
									$vars['res'] = array('success' => false, 'msg' => 'Erreur BDD');
							}else
								$vars['res'] = array('success' => false, 'msg' => $res);
						}
					}
					$this->vue->chargerVue('membre_' . $action, $vars);
				}
				elseif($param['mdp']){
					if(!empty($param['cle']) && ($membre = $membreDAO->checkCleResetPass($param['cle']))){
						if(!empty($_POST)){
							if(($res = Membre::checkLostPass($_POST))){
								$membre = new Membre(array(
									'id_membre' => $membre->id_membre,
									'password' => password_hash($_POST['passwordNew'], PASSWORD_BCRYPT, array('cost' => 12)),
									'cle_reset_pass' => ''
								));
								$id_membre = $membre->id_membre;
								if($membreDAO->save($membre)){
									$this->action('Oubli de mot de passe (modification du mot de passe)', $id_membre);
									$vars['res'] = array('success' => true, 'msg' => 'Mise à jour du mot de passe réussie');
								}else
									$vars['res'] = array('success' => false, 'msg' => 'Erreur BDD');
							}
							else
								$vars['res'] = array('success' => false, 'msg' => $res);
						}
						else{
							$vars['etape'] = 'formMDP';
						}
					}
					elseif(!empty($_POST)){
						$captcha = new Captcha();
						if(($res = $captcha->check($_POST['g-recaptcha-response'])) === true){
							if(($res = $membreDAO->checkMembreExiste($_POST['pseudoEmail'])) !== false){
								$membre = $res;
								if(($res = $membre->lostPass()) === true){
									$this->action('Oubli de mot de passe (création de la clé)', $membre->id_membre);
									$vars['res'] = array('success' => true, 'msg' => 'Un email vous a été envoyé, merci de suivre les instructions');
								}
								else
									$vars['res'] = array('success' => false, 'msg' => $res);
							}
							else
								$vars['res'] = array('success' => false, 'msg' => 'Le pseudo ou l\'email n\'existe pas');
						}
						else
							$vars['res'] = array('success' => false, 'msg' => $res);
					}
					$this->vue->chargerVue('membre_lostMDP', $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'drop':
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	private function action($libelle, $id_membre = NULL){
		$id_membre = empty($id_membre) ? $_SESSION['user']->id_membre : $id_membre;
		$actionDAO = new ActionDAO(BDD::getInstancePDO());
		$action = new Action(array(
			'id_action' => DAO::UNKNOWN_ID,
			'libelle' => $libelle,
			'id_membre' => $id_membre
		));
		$actionDAO->save($action);
	}
	
	public function technotes($action, $param) {
		$vars = array();
		$vars["technotes"] = 1; // Pour rendre actif l'onglet de la barre de menu
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());		
		
		switch($action){
			case 'get':
				// Si on veut consulter une technote en particulier
				if(isset($_GET['id_technote'])){
					$tn = $technoteDAO->getOne(array('id_technote' => $_GET['id_technote']));
					$vars['tn'] = $tn;
					$this->vue->chargerVue('technotes_' . $action . '_one', $vars);
				}
				else {
					// Le nombre de technotes est arbitraire
					$nbTechnotes = 6;
					
					// Recuperation du numero de la page courante
					$nav = isset($_GET["nav"]) ? intval($_GET["nav"]) : 1;
					
					// Recuperation des technotes a afficher
					$debut = ($nav - 1) * 6;
					$tn = $technoteDAO->getNTechnotes($debut, $nbTechnotes);
					
					// Pour le nb de pages de la navigation
					$count = intval($technoteDAO->getCount());
					$nbPages = $count / 6;
					if ($count % 6 != 0) $nbPages++;
					$fin = $debut + 6 > $count ? 1 : 0;
					
					$vars['nbPages'] = $nbPages;
					$vars['fin'] = $fin;
					$vars['nav'] = $nav;
					$vars['tn'] = $tn;
					$this->vue->chargerVue('technotes_' . $action, $vars);
				}
				break;
			case 'add':
				break;
			case 'edit':
				break;
			case 'del':
				break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
		
	}

	public function connexion($action, $param){
		$vars = array();
		if(!empty($_POST)){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if($membreDAO->checkUserPass($_POST['pseudo'], $_POST['password'])){
				$membreDAO->connexion($_POST['pseudo']);
				if(!$_SESSION['user']->bloquer){
					if(!empty($_POST['autoConnexion']) && $_POST['autoConnexion'] == 'on'){
						$cle = Token::createToken();
						$token = new Token(array(
							'id_token' => DAO::UNKNOWN_ID,
							'cle' => $cle,
							'ip' => $_SERVER['REMOTE_ADDR'],
							'id_membre' => $_SESSION['user']->id_membre
						));
						$tokenDAO = new TokenDAO(BDD::getInstancePDO());
						$tokenDAO->save($token);
						setcookie('token', $cle, time() + DUREE_COOKIE_AUTOCONNECT_SEC);
					}
					$this->action("Connexion ($_SERVER[REMOTE_ADDR])");
					header('Location: /membre');
					exit();
				}
				else{
					$_SESSION['user'] = false;
					$vars['connect'] = array('success' => false, 'msg' => 'Votre compte a été bloqué');
				}
			}
			else
				$vars['connect'] = array('success' => false, 'msg' => 'Couple login / mot de passe invalide');
			$this->accueil('get', NULL, array('connect' => $vars['connect']));
			exit();
		}
		else{
			header('Location: /');
			exit();
		}
	}

	public function contact($action, $param){
		$vars = array();
		$vars["contact"] = 1;
		if(!empty($_POST)){
			if(!$_SESSION['user'] || ($_SESSION['user'] && !empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF'])){
				if(($res = Membre::checkContact($_POST)) === true){
					if(($res = Membre::contact($_POST)) === true){
						if($_SESSION['user'])
							$this->action('Contact par formulaire', $_SESSION['user']->id_membre);
						$vars['res'] = array('success' => true, 'msg' => 'L\'email nous a été envoyé, nous y répondrons dès que possible');
						unset($_POST);
					}
					else
						$vars['res'] = array('success' => false, 'msg' => $res);
				}
				else
					$vars['res'] = array('success' => false, 'msg' => $res);
			}
		}
		$this->vue->chargerVue('contact', $vars);
	}

	public function conditions($action, $param){
		$vars = array();
		$this->vue->chargerVue('conditions', $vars);
	}

	public function mentions($action, $param){
		$vars = array();
		$this->vue->chargerVue('mentions', $vars);
	}

	public function deconnexion($action, $param){
		session_destroy();
		setcookie('token', '', time() - 10);
		header('Location: /');
		exit();
	}

}
<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $id, $vars){
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['accueil'] = 1;
				$vars['tn'] = $technoteDAO->getLastNTechnotes(NB_TN_ACCUEIL);
				$this->vue->chargerVue('accueil_get', $vars);
				break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function membre($action, $id, $vars){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['profile'] = 1;
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
					$this->vue->chargerVue('membre_get', $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'add':
				$vars['profile'] = 1;
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
					$this->vue->chargerVue('membre_add', $vars);
				}
				else{
					header('Location: /');
					exit();
				}
				break;
			case 'edit':
				$vars['profile'] = 1;
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
					$this->vue->chargerVue('membre_edit', $vars);
				}
				elseif($_GET['mdp']){
					if(!empty($_GET['cle']) && ($membre = $membreDAO->checkCleResetPass($_GET['cle']))){
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
				$vars['profile'] = 1;
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}
	
	public function technotes($action, $id, $vars) {
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['technotes'] = 1;
				// Si on veut consulter une technote en particulier
				if(!empty($id)){
					$vars['technote'] = $technoteDAO->getOne(array('id_technote' => $id));
					if($vars['technote'] !== false)
						$this->vue->chargerVue('technotes_get_one', $vars);
					else
						$this->vue->chargerVue('404', $vars);
				}
				else{
					$vars['technotes_all'] = 1;

					// Recuperation du numero de la page courante
					$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;

					// Recuperation des technotes a afficher
					$debut = ($page - 1) * NB_TN_PAGE;
					$vars['technotes'] = $technoteDAO->getNTechnotes($debut, NB_TN_PAGE);
					
					// Pour le nb de pages de la navigation
					$count = intval($technoteDAO->getCount());
					$nbPages = $count / NB_TN_PAGE;
					if ($count % NB_TN_PAGE != 0) $nbPages++;
					$fin = $debut + NB_TN_PAGE > $count ? 1 : 0;
					
					$vars['nbPages'] = $nbPages;
					$vars['fin'] = $fin;
					$vars['page'] = $page;
					$this->vue->chargerVue('technotes_get', $vars);
				}
				break;
			case 'add':
				$vars['technotes'] = 1;
				$vars['technotes_add'] = 1;
				if($_SESSION['user']){
					if(!empty($_POST)){
						var_dump($_POST);
						die;
					}
					else{
						$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
						$motsCles = $motCleDAO->getAll();
						$vars['motsCles'] = $motsCles;
						$this->vue->chargerVue('technotes_add', $vars);
					}
				}
				else
					$this->technotes('403', $vars);
				break;
			case 'edit':
				$vars['technotes'] = 1;
				//break;
			case 'del':
				$vars['technotes'] = 1;
				//break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function connexion($action, $id, $vars){
		if(!$_SESSION['user']){
			switch($action){
				case 'get':
					if(!empty($_POST)){
						$res = Membre::connexion($_POST);
						if($res['success'] === true){
							header('Location: /membre');
							exit();
						}
						$vars['connexion'] = $res;
						$this->accueil('get', array('connexion' => $vars['connexion']));
						break;
					}
					$this->vue->chargerVue('403', $vars);
					break;
				default:
					$this->vue->chargerVue('404', $vars);
			}
		}
		$this->vue->chargerVue('403', $vars);
	}

	public function contact($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['contact'] = 1;
				if(!empty($_POST)){
					if(!$_SESSION['user'] || ($_SESSION['user'] && !empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF'])){
						$contact = new Contact($_POST);
						$res = $contact->sendMail();
						if($_SESSION['user'] && $res['success'] === true){
							$res['messages'] .= ', nous vous répondrons dès que possible';
							unset($_POST);
						}
						$vars['res'] = $res;
					}
				}
				$this->vue->chargerVue('contact', $vars);
				break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function conditions($action, $id, $vars){
		switch($action){
			case 'get':
				$this->vue->chargerVue('conditions', $vars);
				break;
			default:
				$this->vue->chargerVue('404', $vars);
		}
	}

	public function mentions($action, $id, $vars){
		switch($action){
			case 'get':
				$this->vue->chargerVue('mentions', $vars);
				break;
			default:
				$this->vue->chargerVue('404', $vars);
		}

	}

	public function deconnexion($action, $id, $vars){
		session_destroy();
		setcookie('token', '', time() - 10);
		header('Location: /');
		exit();
	}

}
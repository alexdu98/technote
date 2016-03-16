<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Les dernières technotes';
				$vars['active_accueil'] = 1;
				$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
				$vars['technotes'] = $technoteDAO->getLastNTechnotes(NB_TECHNOTE_ACCUEIL);
				$this->vue->display('accueil.twig', $vars);
				exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function membre($action, $id, $vars){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Profil';
				$vars['active_profile'] = 1;
				if($_SESSION['user']){
					$vars['profil'] = $_SESSION['user']->getProfile();
					$this->vue->display('membre_get.twig', $vars);
					exit();
				}
				else{
					header('Location: /');
					exit();
				}
			case 'add':
				$vars['titrePage'] = 'Inscription';
				$vars['active_profile'] = 1;
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
								//$this->action('Inscription');
								$vars['res'] = array('success' => true, 'messages' => 'Inscription réussie');
							}
							else
								$vars['res'] = array('success' => false, 'messages' => array('Erreur BDD'));
						}
						else
							$vars['res'] = array('success' => false, 'messages' => array($res));
					}
					$this->vue->display('membre_add.twig', $vars);
					exit();
				}
				else{
					header('Location: /');
					exit();
				}
				exit();
			case 'edit':
				$vars['active_profile'] = 1;
				if($_SESSION['user']){
					$vars['titrePage'] = 'Modification du profil';
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
									//$this->action('Mise à jour du profil');
									$vars['res'] = array('success' => true, 'messages' => 'Mise à jour réussie');
								}else
									$vars['res'] = array('success' => false, 'messages' => array('Erreur BDD'));
							}else
								$vars['res'] = array('success' => false, 'messages' => array($res));
						}
					}
					$this->vue->display('membre_edit.twig', $vars);
					exit();
				}
				elseif($_GET['mdp']){
					$vars['titrePage'] = 'Mot de passe oublié';
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
									//$this->action('Oubli de mot de passe (modification du mot de passe)', $id_membre);
									$vars['res'] = array('success' => true, 'messages' => 'Mise à jour du mot de passe réussie');
								}else
									$vars['res'] = array('success' => false, 'messages' => array('Erreur BDD'));
							}
							else
								$vars['res'] = array('success' => false, 'messages' => array($res));
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
									//$this->action('Oubli de mot de passe (création de la clé)', $membre->id_membre);
									$vars['res'] = array('success' => true, 'messages' => 'Un email vous a été envoyé, merci de suivre les instructions');
								}
								else
									$vars['res'] = array('success' => false, 'messages' => array($res));
							}
							else
								$vars['res'] = array('success' => false, 'messages' => array('Le pseudo ou l\'email n\'existe pas'));
						}
						else
							$vars['res'] = array('success' => false, 'messages' => array($res));
					}
					$this->vue->display('membre_lostMDP.twig', $vars);
					exit();
				}
				else{
					header('Location: /');
					exit();
				}
				exit();
			case 'drop':
				$vars['active_profile'] = 1;
				//exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}
	
	public function technotes($action, $id, $vars) {
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			case 'get':
				$vars['active_technotes'] = 1;
				// Si on veut consulter une technote en particulier
				if(isset($id)){
					$vars['technote'] = $technoteDAO->getOne(array('id_technote' => $id));
					if($vars['technote'] !== false){
						$vars['titrePage'] = $vars['technote']->titre;
						$this->vue->display('technote.twig', $vars);
					}
					else
						$this->vue->display('404.twig', $vars);
					exit();
				}
				else{
					$vars['titrePage'] = 'Toutes les technotes';
					$vars['active_technotes_all'] = 1;
					$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
					$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
					$count = intval($technoteDAO->getCount());
					$vars['pagination'] = new Pagination($page, $count, '/technotes/get?page=');

					$vars['technotes'] = $technoteDAO->getNTechnotes($vars['pagination']->debut, NB_TECHNOTE_PAGE);
					$this->vue->display('technotes.twig', $vars);
					exit();
				}
			case 'add':
				$vars['active_technotes'] = 1;
				$vars['active_technotes_add'] = 1;
				if($_SESSION['user']){
					if(!empty($_POST)){
						var_dump($_POST);
						die;
					}
					else{
						$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
						$motsCles = $motCleDAO->getAll();
						$vars['motsCles'] = $motsCles;
						$this->vue->display('technotes_add.twig', $vars);
						exit();
					}
				}
				else
					$this->technotes('403.twig', NULL, $vars);
				exit();
			case 'edit':
				$vars['active_technotes'] = 1;
				//exit();
			case 'del':
				$vars['active_technotes'] = 1;
				//exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
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
						$this->accueil('get', NULL, array('msgCo' => $res));
						exit();
					}
					$this->vue->display('403.twig', $vars);
					exit();
				default:
					$this->vue->display('404.twig', $vars);
					exit();
			}
		}
		$this->vue->display('403.twig', $vars);
		exit();
	}

	public function contact($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Contact';
				$vars['active_contact'] = 1;
				if(!empty($_POST)){
					if(!$_SESSION['user'] || ($_SESSION['user'] && !empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF'])){
						$contact = new Contact($_POST);
						$res = $contact->sendMail();
						if($_SESSION['user'] && $res['success'] === true){
							$res['messages'] .= ', nous vous répondrons dès que possible';
						}
						$vars['res'] = $res;
					}
				}
				$this->vue->display('contact.twig', $vars);
				exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function conditions($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Conditions d\'utilisation';
				$this->vue->display('conditions.twig', $vars);
				exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function mentions($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Mentions légales';
				$this->vue->display('mentions.twig', $vars);
				exit();
			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function deconnexion($action, $id, $vars){
		session_destroy();
		setcookie('token', '', time() - 10);
		header('Location: /');
		exit();
	}

}
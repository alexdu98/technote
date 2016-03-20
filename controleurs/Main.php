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
					$vars['profil'] = $_SESSION['user']->getProfil();
					$this->vue->display('membre_get.twig', $vars);
					exit();
				}
				header('Location: /');
				exit();
				
			case 'add':
				$vars['titrePage'] = 'Inscription';
				$vars['active_profile'] = 1;
				if(!$_SESSION['user']){
					if(!empty($_POST)){
						$vars['res'] = Membre::inscription($_POST);
						if($vars['res']->success === true){
							$_POST = NULL;
							$this->vue->addGlobal('post', $_POST);
						}
					}
					$this->vue->display('membre_add.twig', $vars);
					exit();
				}
				header('Location: /');
				exit();
				
			case 'edit':
				$vars['active_profile'] = 1;
				if($_SESSION['user']){
					$vars['titrePage'] = 'Modification du profil';
					if(!empty($_POST))
						if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
							$vars['res'] = $_SESSION['user']->editProfil($_POST);
							if($vars['res']->success === true)
								$this->vue->addGlobal('session', $_SESSION);
						}
					$this->vue->display('membre_edit.twig', $vars);
					exit();
				}
				elseif($_GET['mdp']){
					$vars['titrePage'] = 'Mot de passe oublié';
					if(!empty($_GET['cle']) && ($membre = $membreDAO->checkCleResetPass($_GET['cle'])) !== false){
						// Réinitialisation du mot de passe
						if(!empty($_POST)){
							$vars['res'] = $membre->resetLostPass($_POST);
							if($vars['res']->success === true){
								$this->accueil('get', NULL, $vars);
								exit();
							}
						}
						$vars['etape'] = 'formMDP';
						$this->vue->display('membre_lostMDP.twig', $vars);
						exit();
					} // TODO verif les captchas
					elseif(!empty($_GET['cle'])){
						$this->vue->display('membre_lostMDP.twig', $vars);
						exit();
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
				if(!empty($id)){
					$vars['technote'] = $technoteDAO->getOne(array('id_technote' => $id));
					if($vars['technote'] !== false){
						$vars['titrePage'] = $vars['technote']->titre;
						$this->vue->display('technote.twig', $vars);
					}
					else
						$this->vue->display('404.twig', $vars);
				}
				else{
					$vars['titrePage'] = 'Toutes les technotes';
					$vars['active_technotes_all'] = 1;
					$page = !empty($_GET['page']) ? $_GET['page'] : 1;
					$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
					$count = $technoteDAO->getCount();
					$vars['pagination'] = new Pagination($page, $count, '/technotes/get?page=');
					$vars['technotes'] = $technoteDAO->getNTechnotes($vars['pagination']->debut, NB_TECHNOTE_PAGE);
					$this->vue->display('technotes.twig', $vars);
				}
				exit();
				
			case 'add':
				$vars['active_technotes'] = 1;
				$vars['active_technotes_add'] = 1;
				
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAll();
				
				if($_SESSION['user']){
					if(!empty($_POST)){
						$vars['res'] = Technote::addTechnote($_POST);
						if($vars['res']->success === true){
							$_POST = NULL;
							$this->vue->display('technotes_add.twig', $vars);
						}
					}
					else $this->vue->display('technotes_add.twig', $vars);
					exit();
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
						if($res->success === true){
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
						if($res->success === true){
							$res->msg[0] .= ', nous vous répondrons dès que possible';
							$_POST = NULL;
							$this->vue->addGlobal('post', $_POST);
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
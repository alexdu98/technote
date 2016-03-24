<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{

	public function accueil($action, $id, $vars){
		switch($action){

			case 'get':
				$vars['titrePage'] = 'Les dernières technotes'; // <h1> de la page
				$vars['active_accueil'] = 1; // Active le style dans le menu accueil

				// Récupération des dernières technotes
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
				$vars['titrePage'] = 'Profil'; // <h1> de la page
				$vars['active_profil'] = 1; // Active le style dans le menu profil

				// Si l'utilisateur est connecté
				if($_SESSION['user']){
					// On récupère son profil
					$vars['profil'] = $_SESSION['user']->getProfil();

					$this->vue->display('membre_get.twig', $vars);
					exit();
				}

				header('Location: /');
				exit();

			case 'add':
				$vars['titrePage'] = 'Inscription'; // <h1> de la page
				$vars['active_profile'] = 1; // Active le style dans le menu profil

				// Si l'utilisateur n'est pas connecté
				if(!$_SESSION['user']){
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// On essaye d'inscrire l'utilisateur
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
				$vars['active_profile'] = 1; // Active le style dans le menu profil

				// Si l'utilisateur est connecté alors édition de profil
				if($_SESSION['user']){
					$vars['titrePage'] = 'Modification du profil'; // <h1> de la page
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// Si le formulaire est valide au niveau faille CSRF
						if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
							// On essaye de faire les modifications
							$vars['res'] = $_SESSION['user']->editProfil($_POST);
							if($vars['res']->success === true)
								$this->vue->addGlobal('session', $_SESSION);
						}
					}
					$this->vue->display('membre_edit.twig', $vars);
				}
				// Si l'utilisateur est déconnecté alors oubli du mot de passe
				else{
					$vars['titrePage'] = 'Mot de passe oublié'; // <h1> de la page

					// Si la clé de réinitialisation n'est pas vide et est correcte alors formulaire de changement du mot de passe
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
					}
					// Sinon si un formulaire a été envoyé alors envoi du mail avec le lien de réinitialisation du mot de passe
					elseif(!empty($_POST)){
						// On essaye d'envoyé le mail avec le lien de réinitialisation du mot de passe
						$vars['res'] = Membre::sendMailLostPass($_POST);
					}
					$this->vue->display('membre_lostMDP.twig', $vars);
				}
				exit();

			case 'drop':
				$vars['active_profile'] = 1; // Active le style dans le menu profil
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}
	
	public function technotes($action, $id, $vars) {
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){

			case 'get':
				$vars['active_technotes'] = 1; // Active le style dans le menu technotes

				// Si on veut voir une technote précise
				if(!empty($id)){
					// On récupère la technote
					$vars['technote'] = $technoteDAO->getOne(array('id_technote' => $id));
					// Si la technote existe
					if($vars['technote'] !== false){
						$vars['titrePage'] = $vars['technote']->titre; // <h1> de la page
						$this->vue->display('technote.twig', $vars);
					}
					// Si la technote n'existe pas
					else
						$this->vue->display('404.twig', $vars);
				}
				// si on veut voir toutes les technotes
				else{
					$vars['titrePage'] = 'Toutes les technotes'; // <h1> de la page
					$vars['active_technotes_all'] = 1; // Active le style dans le sous menu toutes les technotes

					// On récupère la page
					$page = !empty($_GET['page']) ? $_GET['page'] : 1;
					$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
					// On récupère le nombre total de technotes
					$count = $technoteDAO->getCount();
					// On créé la pagination
					$vars['pagination'] = new Pagination($page, $count, '/technotes/get?page=');
					// On récupère les technotes
					$vars['technotes'] = $technoteDAO->getLastNTechnotes(NB_TECHNOTE_PAGE, $vars['pagination']->debut);

					$this->vue->display('technotes.twig', $vars);
				}
				exit();
				
			case 'add':
				$vars['active_technotes'] = 1; // Active le style dans le menu technotes
				$vars['active_technotes_add'] = 1; // Active le style dans le sous menu ajout de technote
				$vars['titrePage'] = 'Ajouter une technote'; // <h1> de la page

				// On récupère tous les mots clés
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAll();

				// Si l'utilisateur est connecté
				if($_SESSION['user']){
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// On essaye d'enregistrer la technote
						$vars['res'] = Technote::addTechnote($_POST);
						if($vars['res']->success === true){
							$_POST = NULL;
							$this->vue->addGlobal('post', $_POST);
						}
					}
					$this->vue->display('technotes_add.twig', $vars);
					exit();
				}
				else
					$this->technotes('403.twig', NULL, $vars);
				exit();
				
			case 'edit':
				$vars['active_technotes'] = 1;
				exit();

			case 'drop':
				$vars['active_technotes'] = 1;
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function connexion($action, $id, $vars){
		// Si l'utilisateur n'est pas connecté
		if(!$_SESSION['user']){
			switch($action){

				case 'get':
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// On essaye de se connecter
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
				$vars['titrePage'] = 'Contact'; // <h1> de la page
				$vars['active_contact'] = 1; // Active le style dans le menu contact

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si l'utilisateur n'est pas connecté, ou qu'il est connecté et que le formulaire soit valide au niveau faille CSRF
					if(!$_SESSION['user'] || ($_SESSION['user'] && !empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF'])){
						// On créé un contact
						$contact = new Contact($_POST);
						// On essaye d'envoyé le mail
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
				$vars['titrePage'] = 'Conditions d\'utilisation'; // <h1> de la page
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
				$vars['titrePage'] = 'Mentions légales'; // <h1> de la page
				$this->vue->display('mentions.twig', $vars);
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	public function deconnexion($action, $id, $vars){
		session_destroy(); // Détruit la session
		setcookie('token', '', time() - 10); // Détruit le cookie de connexion
		header('Location: /');
		exit();
	}

}
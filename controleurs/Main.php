<?php

/**
 * Classe du controleur principal
 */
class Main extends Controleur{
	
	/*------------------------
			ACCUEIL
	--------------------------*/
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

	/*------------------------
	 		MEMBRE
	 --------------------------*/
	public function membre($action, $id, $vars){
		$membreDAO = new MembreDAO(BDD::getInstancePDO());
		switch($action){

			/**** GET ****/
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

			/**** ADD ****/
			case 'add':
				$vars['titrePage'] = 'Inscription'; // <h1> de la page
				$vars['active_profile'] = 1; // Active le style dans le menu profil

				// Si l'utilisateur n'est pas connecté
				if(!$_SESSION['user']){
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// On essaye d'inscrire l'utilisateur
						echo json_encode(Membre::inscription($_POST));
						exit();
					}
					$this->vue->display('membre_add.twig', $vars);
					exit();
				}

				header('Location: /');
				exit();
				
			/**** EDIT ****/
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
							$res = $_SESSION['user']->editProfil($_POST);
							if(!empty($_POST['updateEmail']) && $res->success)
								$res->update['email'] = $_SESSION['user']->email;
							echo json_encode($res);
							exit();
						}
						echo 'wtf';
						var_dump($_POST['jetonCSRF'], $_SESSION['jetonCSRF']);
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
							$res = $membre->resetLostPass($_POST);
							if($res->success)
								$res->redirect = '/accueil';
							echo json_encode($res);
							exit();
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

			/**** DROP ****/
			case 'drop':
				$vars['active_profile'] = 1; // Active le style dans le menu profil
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}
	
	/*------------------------
	 		TECHNOTES
	 --------------------------*/
	public function technotes($action, $id, $vars) {
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		switch($action){
			
			/**** GET ****/
			case 'get':
				$vars['active_technotes'] = 1; // Active le style dans le menu technotes

				// Si on veut voir une technote précise
				if(!empty($id)){
					// On récupère la technote
					$vars['technote'] = $technoteDAO->getOne($id);
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
					$vars['pagination'] = new Pagination($page, $count, NB_TECHNOTE_PAGE,'/technotes/get?page=');
					// On récupère les technotes
					$vars['technotes'] = $technoteDAO->getLastNTechnotes(NB_TECHNOTE_PAGE, $vars['pagination']->debut);

					$this->vue->display('technotes.twig', $vars);
				}
				exit();
			
			/**** ADD ****/
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
						echo json_encode(Technote::addTechnote($_POST));
						exit();
					}
					$this->vue->display('technotes_add.twig', $vars);
					exit();
				}
				else
					$this->technotes('403.twig', NULL, $vars);
				exit();
			
			/**** EDIT ****/
			case 'edit':
				$vars['active_technotes'] = 1;
				exit();

			/**** DROP ****/
			case 'drop':
				$vars['active_technotes'] = 1;
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
	 		COMMENTAIRE
	 --------------------------*/
	public function commentaires($action, $id, $vars){
		switch($action){
			case 'add':
				if(!empty($_POST)){
					// On essaye d'enregistrer le commentaire
					$res = Commentaire::addCommentaire($_POST);
					if($res->success){
						$res->add['commentaire'] = $this->vue->render('templates/commentaire.twig', array('commentaires' => $res->add));
					}
					echo json_encode($res);
					exit();
				}
		}
	}

	/*------------------------
	 		CONNEXION
	 --------------------------*/
	public function connexion($action, $id, $vars){
		// Si l'utilisateur n'est pas connecté
		if(!$_SESSION['user']){
			switch($action){

				case 'get':
					// Si un formulaire a été envoyé
					if(!empty($_POST)){
						// On essaye de se connecter
						$res = Membre::connexion($_POST);
						if($res->success)
							$res->redirect = "/membre";
						echo json_encode($res);
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

	/*------------------------
	 		CONTACT
	 --------------------------*/
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
						if($res->success)
							$res->msg[0] .= ', nous vous répondrons dès que possible';
						echo json_encode($res);
						exit();
					}
				}

				$this->vue->display('contact.twig', $vars);
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
	 		CONDITIONS
	 --------------------------*/
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

	/*------------------------
	 		MENTIONS
	 --------------------------*/
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

	/*------------------------
	 		DECONNEXION
	 --------------------------*/
	public function deconnexion($action, $id, $vars){
		session_destroy(); // Détruit la session
		setcookie('token', '', time() - 10); // Détruit le cookie de connexion
		header('Location: /');
		exit();
	}

}
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

				// On met à jour les variables de profil et les droits du membre
				$_SESSION['user']->rechargerProfil();

				// On récupère son profil
				$vars['profil'] = $_SESSION['user']->getProfil();

				$this->vue->display('membre_get.twig', $vars);
				exit();

			/**** ADD ****/
			case 'add':
				$vars['titrePage'] = 'Inscription'; // <h1> de la page
				$vars['active_profile'] = 1; // Active le style dans le menu profil

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// On essaye d'inscrire l'utilisateur
					echo json_encode(Membre::inscription($_POST));
					exit();
				}
				$this->vue->display('membre_add.twig', $vars);
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
						echo json_encode(Membre::sendMailLostPass($_POST));
						exit();
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
	public function technotes($action, $id, $vars){
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
					if($vars['technote'] !== false && $vars['technote']->visible && ($vars['technote']->publie || $vars['technote']->id_auteur == $_SESSION['user']->id_membre || $_SESSION['user']->groupe == 'Administrateur' || $_SESSION['user']->groupe == 'Modérateur')){
						$vars['titrePage'] = $vars['technote']->titre; // <h1> de la page
						$this->vue->display('technotes_get_one.twig', $vars);
					}
					// Si la technote n'existe pas
					else
						$this->vue->display('404.twig', $vars);
				}
				// si on veut voir toutes les technotes
				else{
					// On récupère la page
					$page = !empty($_GET['page']) ? $_GET['page'] : 1;
					$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());

					// Si on veut faire une recherche de technotes
					if(isset($_GET['recherche'])){
						$vars['titrePage'] = 'Chercher une technote'; // <h1> de la page

						// on recupère la page
						$page = !empty($_GET['page']) ? $_GET['page'] : 1;
						// On essaye de récupèrer les technotes avec les critères de recherche
						$res = Technote::recherche($_GET, $page);
						if($res->success){
							$vars['pagination'] = $res->pagination;
							$vars['technotes'] = $res->technotes;
						}
						else{
							$vars['res'] = $res;
						}
					}
					// Si on veut que les technotes non publié de l'utilisateur
					elseif(isset($_GET['nonpublie'])){
						$vars['titrePage'] = 'Mes technotes non publié'; // <h1> de la page
						$vars['active_technotes_non_publie'] = 1; // Active le style dans le sous menu toutes les technotes

						// On récupère le nombre total de technotes non publié par l'
						$count = $technoteDAO->getNbRedige($_SESSION['user']->id_membre, 0);
						
						// On créé la pagination
						$vars['pagination'] = new Pagination($page, $count, NB_TECHNOTES_PAGE, '/technotes/get?nonpublie&page=');
						// On récupère les technotes
						$vars['technotes'] = $technoteDAO->getLastNTechnotes(NB_TECHNOTES_PAGE, $vars['pagination']->debut, 0);
					}
					else{
						$vars['titrePage'] = 'Toutes les technotes'; // <h1> de la page
						$vars['active_technotes_all'] = 1; // Active le style dans le sous menu toutes les technotes

						// On récupère le nombre total de technotes
						$count = $technoteDAO->getCount();
						// On créé la pagination
						$vars['pagination'] = new Pagination($page, $count, NB_TECHNOTES_PAGE, '/technotes/get?page=');
						// On récupère les technotes
						$vars['technotes'] = $technoteDAO->getLastNTechnotes(NB_TECHNOTES_PAGE, $vars['pagination']->debut);
					}
					$this->vue->display('technotes_get_all.twig', $vars);
				}
				exit();
			
			/**** ADD ****/
			case 'add':
				$vars['active_technotes'] = 1; // Active le style dans le menu technotes
				$vars['active_technotes_add'] = 1; // Active le style dans le sous menu ajout de technote
				$vars['titrePage'] = 'Ajouter une technote'; // <h1> de la page

				// On récupère tous les mots clés
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAllActif();

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer la technote
						$res = Technote::addTechnote($_POST, $_FILES);
						if($res->success)
							$res->redirect = "/technotes/get/$res->id_technote";
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('technotes_add.twig', $vars);
				exit();

			/**** EDIT ****/
			case 'edit':
				$vars['active_technotes'] = 1; // Active le style dans le menu technotes
				$vars['titrePage'] = 'Modifier une technote'; // <h1> de la page

				$vars['technote'] = $technoteDAO->getOne($id);

				// On récupère tous les mots clés
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAllActif();

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer la technote
						$res = Technote::editTechnote($_POST, $_FILES, $id);
						if($res->success)
							$res->redirect = "/technotes/get/$id";
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('technotes_edit.twig', $vars);
				exit();

			/**** DROP ****/
			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Technote::dropTechnote($id);
						if($res->success)
							$res->redirect = "/technotes";
						echo json_encode($res);
					}
				}
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
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Commentaire::addCommentaire($_POST);
						if($res->success){
							$res->add['commentaire'] = $this->vue->render('templates/commentaire.twig', array('commentaires' => $res->add));
						}
						echo json_encode($res);
					}
				}
				exit();

			case 'edit':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Commentaire::editCommentaire($_POST, $id);
						echo json_encode($res);
					}
				}
				exit();

			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Commentaire::dropCommentaire($_POST, $id);
						echo json_encode($res);
					}
				}
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
	 		QUESTIONS
	 --------------------------*/
	public function questions($action, $id, $vars){
		switch($action){
			case 'get':

				$vars['active_questions'] = 1; // Active le style dans le menu questions
				$questionDAO = new QuestionDAO(BDD::getInstancePDO());

				// Si on veut voir une question précise
				if(!empty($id)){
					// On récupère la technote
					$vars['question'] = $questionDAO->getOne($id);
					// Si la question existe
					if($vars['question'] !== false){
						$vars['titrePage'] = $vars['question']->titre; // <h1> de la page
						$this->vue->display('questions_get_one.twig', $vars);
					}
					// Si la question n'existe pas
					else
						$this->vue->display('404.twig', $vars);
				}
				// si on veut voir toutes les questions
				else{

					// Si on veut faire une recherche de question
					if(isset($_GET['recherche'])){
						$vars['titrePage'] = 'Chercher une question'; // <h1> de la page

						// on recupère la page
						$page = !empty($_GET['page']) ? $_GET['page'] : 1;
						// On essaye de récupèrer les questions avec les critères de recherche
						$res = Question::recherche($_GET, $page);
						if($res->success){
							$vars['pagination'] = $res->pagination;
							$vars['questions'] = $res->questions;
						}
						else{
							$vars['res'] = $res;
						}
					}
					else{
						$vars['titrePage'] = 'Les dernières questions'; // <h1> de la page

						// On récupère la page
						$page = !empty($_GET['page']) ? $_GET['page'] : 1;

						$vars['active_questions_all'] = 1; // Active le style dans le sous menu toutes les questions

						// On récupère le nombre total de questions
						$count = $questionDAO->getCount();
						// On créé la pagination
						$vars['pagination'] = new Pagination($page, $count, NB_QUESTIONS_PAGE, '/questions/get?page=');
						// On récupère les questions
						$vars['questions'] = $questionDAO->getLastNQuestions(NB_QUESTIONS_PAGE, $vars['pagination']->debut);
					}

					$this->vue->display('questions_get_all.twig', $vars);
				}
				exit();

			/**** ADD ****/
			case 'add':
				$vars['active_questions'] = 1; // Active le style dans le menu questions
				$vars['active_questions_add'] = 1; // Active le style dans le sous menu ajout de questions
				$vars['titrePage'] = 'Poser une question'; // <h1> de la page

				// On récupère tous les mots clés
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAllActif();

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer la technote
						$res = Question::addQuestion($_POST);
						if($res->success)
							$res->redirect = "/questions/get/$res->id_question";
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('questions_add.twig', $vars);
				exit();

			/**** EDIT ****/
			case 'edit':
				$vars['active_questions'] = 1; // Active le style dans le menu questions
				$vars['titrePage'] = 'Modifier une question'; // <h1> de la page
				$questionDAO = new QuestionDAO(BDD::getInstancePDO());
				$vars['question'] = $questionDAO->getOne($id);

				// On récupère tous les mots clés
				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAllActif();

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer la technote
						$res = Question::editQuestion($_POST, $id);
						if($res->success)
							$res->redirect = "/questions/get/$id";
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('questions_edit.twig', $vars);
				exit();

			/**** DROP ****/
			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Question::dropQuestion($id);
						if($res->success)
							$res->redirect = "/questions";
						echo json_encode($res);
					}
				}
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
	 		REPONSES
	 --------------------------*/
	public function reponses($action, $id, $vars){
		switch($action){
			case 'add':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer la réponse
						$res = Reponse::addReponse($_POST);
						if($res->success){
							$res->add['reponse'] = $this->vue->render('templates/reponse.twig', array('reponses' => $res->add));
						}
						echo json_encode($res);
					}
				}
				exit();

			case 'edit':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Reponse::editReponse($_POST, $id);
						echo json_encode($res);
					}
				}
				exit();

			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Reponse::dropReponse($_POST, $id);
						echo json_encode($res);
					}
				}
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
	 		MOTS CLES
	 --------------------------*/
	public function mots_cles($action, $id, $vars){
		switch($action){
			case 'add':
				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// On essaye de se connecter
					$res = MotCle::add($_POST);
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

	/*------------------------
	 		CONNEXION
	 --------------------------*/
	public function connexion($action, $id, $vars){
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
	 		AUTOCOMPLETE
	 --------------------------*/
	public function autocomplete($action, $id, $vars){
		switch($action){
			case 'get':
				if(!empty($_GET['type']) && !empty($_GET['term'])){
					$res = NULL;
					if($_GET['type'] == 'motcle'){
						$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
						$res = $motCleDAO->getAllComposedOf($_GET['term']);
					}
					elseif($_GET['type'] == 'membre'){
						$membreDAO = new MembreDAO(BDD::getInstancePDO());
						$res = $membreDAO->getAllComposedOf($_GET['term']);
					}
					elseif($_GET['type'] == 'titreTechnote'){
						$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
						$res = $technoteDAO->getAllTitreComposedOf($_GET['term']);
					}
					elseif($_GET['type'] == 'titreQuestion'){
						$questionDAO = new QuestionDAO(BDD::getInstancePDO());
						$res = $questionDAO->getAllTitreComposedOf($_GET['term']);
					}
					echo json_encode($res);
					exit();
				}
				$this->vue->display('404.twig', $vars);
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
	 		TOKEN
	 --------------------------*/
	public function token($action, $id, $vars){
		switch($action){
			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye d'enregistrer le commentaire
						$res = Token::dropToken($_POST, $id);
						echo json_encode($res);
					}
				}
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
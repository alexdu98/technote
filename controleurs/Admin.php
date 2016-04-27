<?php

/**
 * Classe du controleur de l'administration
 */
class Admin extends Controleur{

	/*------------------------
	 		CONNEXION
	 --------------------------*/
	public function connexion($action, $id, $vars){
		switch($action){
			case 'get':
				$vars['titrePage'] = 'Connexion à l\'administration'; // <h1> de la page

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// On essaye de se connecter
					$res = Membre::connexionAdmin($_POST);
					if($res->success)
						$res->redirect = "/admin";
					echo json_encode($res);
					exit();
				}

				$this->vue->display('admin/connexion.twig', $vars);
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
			ACCUEIL
	--------------------------*/
	public function accueil($action, $id, $vars){
		switch($action){

			case 'get':
				$vars['titrePage'] = 'Administration'; // <h1> de la page

				$this->vue->display('admin/accueil.twig', $vars);
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
			MEMBRES
	--------------------------*/
	public function membres($action, $id, $vars){
		switch($action){

			case 'get':
				$vars['titrePage'] = 'Les membres'; // <h1> de la page

				$membreDAO = new MembreDAO(BDD::getInstancePDO());
				$vars['membres'] = $membreDAO->getAllForTable();

				$this->vue->display('admin/membres_get_all.twig', $vars);
				exit();

			/**** EDIT ****/
			case 'edit':
				$vars['titrePage'] = 'Modification d\'un membre'; // <h1> de la page

				$membreDAO = new MembreDAO(BDD::getInstancePDO());
				$vars['membre'] = $membreDAO->getOne($id);

				$groupeDAO = new GroupeDAO(BDD::getInstancePDO());
				$vars['groupes'] = $groupeDAO->getAll();

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye de faire les modifications
						$res = Membre::edit($_POST, $id);
						if($res->success)
							$res->redirect = '/admin/membres';
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('admin/membre_edit.twig', $vars);

				exit();

			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						echo json_encode(Membre::delete($id));
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

			case 'get':
				$vars['titrePage'] = 'Les mots clés'; // <h1> de la page

				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motsCles'] = $motCleDAO->getAllForTable();

				$this->vue->display('admin/motsCles_get_all.twig', $vars);
				exit();

			/**** EDIT ****/
			case 'edit':
				$vars['titrePage'] = 'Modification d\'un mot clé'; // <h1> de la page

				$motCleDAO = new MotCleDAO(BDD::getInstancePDO());
				$vars['motCle'] = $motCleDAO->getOne($id);

				// Si un formulaire a été envoyé
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						// On essaye de faire les modifications
						$res = MotCle::edit($_POST, $id);
						if($res->success)
							$res->redirect = '/admin/mots_cles';
						echo json_encode($res);
						exit();
					}
				}
				$this->vue->display('admin/motCle_edit.twig', $vars);

				exit();

			case 'drop':
				if(!empty($_POST)){
					// Si le formulaire est valide au niveau faille CSRF
					if(!empty($_POST['jetonCSRF']) && $_POST['jetonCSRF'] == $_SESSION['jetonCSRF']){
						echo json_encode(MotCle::delete($id));
					}
				}
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

	/*------------------------
			STATISTIQUES
	--------------------------*/
	public function statistiques($action, $id, $vars){
		switch($action){

			case 'get':
				$vars['titrePage'] = 'Statistiques'; // <h1> de la page

				$vars['visites'] = Visite::getStat();
				$vars['membres'] = Membre::getStat();
				$vars['technotes'] = Technote::getStat();
				$vars['commentaires'] = Commentaire::getStat();
				$vars['questions'] = Question::getStat();
				$vars['reponses'] = Reponse::getStat();
				$vars['motsCles'] = MotCle::getStat();

				$this->vue->display('admin/statistiques.twig', $vars);
				exit();

			default:
				$this->vue->display('404.twig', $vars);
				exit();
		}
	}

}
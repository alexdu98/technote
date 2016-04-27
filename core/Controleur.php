<?php

class Controleur{

	/**
	 * @var \Twig_Environment La vue Twig
	 */
	protected $vue;

	/**
	 * Constructeur de Controleur
	 * Charge une vue Twig
	 */
	public function __construct(){
		$twig = new Vue();
		$this->vue = $twig->get();
	}

	/**
	 * Charge le controleur principal de la page demandé
	 * @param Admin|Main L'instance du controleur
	 * @param string $page
	 * @param string $action
	 * @param array $param
	 */
	public function chargerControleurPage($controleur, $page, $action, $id){
		$vueCentrale = '';
		if(method_exists($controleur, $page)){
			// Si c'est sur l'administration
			if(get_class($controleur) == 'Admin'){
				// On vérifie que le membre soit admin ou modo
				if($_SESSION['user']->groupe == 'Administrateur' || $_SESSION['user']->groupe == 'Modérateur'){
					// S'il n'a pas déjà était sur l'administration avec cette session, on le redirige sur la page de connexion de l'administration
					if(empty($_SESSION['admin'])){
						$page = 'connexion';
					}
				}
				else{
					$vueCentrale = '403.twig';
					$this->vue->display($vueCentrale, array());
					return;
				}
			}
			// On vérifie que le membre ait les droits sur cette page et cette action
			if($this->checkDroit($page, $action)){
				$controleur->$page($action, $id, array());
				return;
			}
			else
				$vueCentrale = '403.twig';
		}
		elseif($page == '_403'){
			$vueCentrale = '403.twig';
		}
		else{
			$vueCentrale = '404.twig';
		}
		$this->vue->display($vueCentrale, array());
	}

	public function checkDroit($page, $action){
		// Si $page == add ou edit ou drop = False, sinon (get et autres) = True
		$autoriser = $action == 'add' || $action == 'edit' || $action == 'drop' ? false : true;

		// Vérifie les droits du groupe
		if(($res = $this->groupe($page, $action, $_SESSION['droits']['groupe'])) !== NULL)
			$autoriser = $res;

		// Les droits du membre sont prioritaires sur celui du groupe, autoriser ou non !
		foreach($_SESSION['droits']['membre'] as $droitMembre){
			$tab = $droitMembre->getFields();

			// Si le client à un droit défini pour cette action sur cette page
			if(in_array($page, $tab) && in_array($action, $tab))
				$autoriser = $droitMembre->autoriser == 1;
		}
		return $autoriser;
	}

	public function groupe($page, $action, $tableau){
		// Pour tous les droits du groupe
		foreach($tableau['droits'] as $droitGroupe){
			// On récupère les droits
			$tab = $droitGroupe->getFields();

			// Si le groupe à un droit défini pour cette action sur cette page, on retourne sa valeur
			if(in_array($page, $tab) && in_array($action, $tab))
				return $droitGroupe->autoriser == 1;
		}
		// Si on arrive là, c'est que le groupe n'a pas de droit précisé pour cette action sur cette page
		// donc on remonte sur le groupe parent
		if(!empty($tableau['groupe_parent'])){
			return $this->groupe($page, $action, $tableau['groupe_parent']);
		}
		// Aucun droit n'est défini pour cette action sur cette page
		return NULL;
	}

}
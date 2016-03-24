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
		if(method_exists($controleur, $page)){
			$controleur->$page($action, $id, array());
			return;
		}
		elseif($page == '_403'){
			$vueCentrale = '403.twig';
		}
		else{
			$vueCentrale = '404.twig';
		}
		$this->vue->display($vueCentrale, array());
	}

}
<?php

class Controleur{

	protected $vue;

	public function __construct(){
		$this->vue = new MainVue();
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
			$vueCentrale = '403';
		}
		else{
			$vueCentrale = '404';
		}
		$this->vue->afficher($vueCentrale, array());
	}

}
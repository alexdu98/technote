<?php

class Controleur{

	protected $vue;
	protected $model;

	public function __construct(){
		$this->vue = new Vue();
		$this->model = new Modele();
	}

	/**
	 * Charge le controleur de la page demandé
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
		$vue = new Vue();
		$vue->chargerVue($vueCentrale, array());
	}

}
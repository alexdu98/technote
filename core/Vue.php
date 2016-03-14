<?php

class Vue{

	protected $params = array();

	public function __construct($vars = NULL){
		$this->params = $vars;
	}

	public function afficher($vue, $vars){
		$this->params = $vars;
		extract($this->params, EXTR_PREFIX_ALL, 'v'); // Toutes les variables $var pour la vue deviennent $v_var
		include '/vues/html/header.php';
		include '/vues/html/' . $vue . '.php';
		include '/vues/html/footer.php';
	}

}
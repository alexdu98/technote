<?php

class Vue{

	protected $twig;

	public function __construct(){
		// Défini le dossier des templates pour Twig
		$loader = new Twig_Loader_Filesystem('vues');
		$this->twig = new Twig_Environment($loader, array('debug' => true));
		$this->twig->addExtension(new Twig_Extension_Debug());
		$this->twig->addGlobal('server', $_SERVER);
		$this->twig->addGlobal('session', $_SESSION);
		$this->twig->addGlobal('post', $_POST);
		$this->twig->addGlobal('get', $_GET);
	}

	public function get(){
		return $this->twig;
	}

}
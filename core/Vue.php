<?php

class Vue{

	/**
	 * @var \Twig_Environment La vue Twig
	 */
	protected $twig;

	/**
	 * Constructeur de Vue
	 * Charge la vue Twig, et rempli les variables server, session, post, get
	 */
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

	/**
	 * @return \Twig_Environment La vue Twig
	 */
	public function get(){
		return $this->twig;
	}

}
<?php

// Démarre une session
session_start();

// Charge le fichier de configuration
require('config.php');

// Charge l'autoloader de classe
require('Autoloader.php');
Autoloader::Autoload();

// Connecte le client s'il possède un cookie
$visiteDAO = new VisiteDAO(BDD::getInstancePDO());
if(!isset($_SESSION[NOM_SESSION_CONNEXION]))
	$visiteDAO->connectWithCookie();

// Enregistre la visite si c'est la premiere de cette heure
$visite = new Visite(array('id_visite' => DAO::UNKNOWN_ID, 'ip' => $_SERVER['REMOTE_ADDR']));
$visiteDAO->checkVisite($visite);

// Si params n'existe pas (technote.dev), on la créé
$_GET['params'] = !isset($_GET['params']) ? '' : $_GET['params'];

// On découpe la chaine de paramètre pour avoir le controleur, la page, et l'action
// On pourrait faire plus simple en faisant toujours apparaître le controleur dans l'url
// Mais l'URL est plus jolie comme ça
$url = explode('/', $_GET['params']);
$controleur = $url[0] == 'admin' ? 'admin' : 'main';
if($controleur == 'admin'){
	if(empty($url[1])){
		$page = 'accueil';
		$action = 'get';
	}
	else{
		$page = $url[1];
		if(empty($url[2]))
			$action = 'get';
		else
			$action = $url[2];
	}
}
else{
	if(empty($url[0])){
		$page = 'accueil';
		$action = 'get';
	}
	else{
		$page = $url[0];
		if(empty($url[1]))
			$action = 'get';
		else
			$action = $url[1];
	}
}

// Supprime la variable des paramètres de l'URL
unset($_GET['params']);

// Charge le controleur
$controleur = Controleur::construct($controleur);

// Charger le controleur de la page demandé
$controleur->chargerControleurPage($page, $action, $_GET);
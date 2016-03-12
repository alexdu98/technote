<?php

// Charge le fichier de configuration
require('config.php');

// Charge l'autoloader de classe
require('Autoloader.php');
Autoloader::Autoload();

// Démarre une session
session_start();

// Connecte le client s'il possède un cookie
$tokenDAO = new TokenDAO(BDD::getInstancePDO());
if(!isset($_SESSION['user']))
	$tokenDAO->checkToken();

// Créé le jeton pour éviter la faille CSRF
if(empty($_SESSION['jetonCSRF']))
	$_SESSION['jetonCSRF'] = hash('sha1', uniqid(rand(), true) . SALT_JETON_CSRF);

// Enregistre la visite si c'est la premiere de cette heure
$visiteDAO = new VisiteDAO(BDD::getInstancePDO());
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
	// Si $controleur == main, alors $url[0]
	// represente la page (et non le type de connexion)
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
$controleur = new $controleur();

// Charge le controleur de la page demandé
$controleur->chargerControleurPage($controleur, $page, $action);
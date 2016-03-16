<?php

// Charge le fichier de configuration
require('config.php');

// Charge l'autoloader de Composer
require 'vendor/autoload.php';

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

// Récupération de l'URL
$controleur = $_GET['url_controleur'];
$page = !empty($_GET['url_page']) ? $_GET['url_page'] : 'accueil';
$action = !empty($_GET['url_action']) ? $_GET['url_action'] : 'get';
$id = !empty($_GET['url_id']) ? $_GET['url_id'] : NULL;

// Charge le controleur
$controleur = new $controleur();

// Charge le controleur de la page demandé
$controleur->chargerControleurPage($controleur, $page, $action, $id);
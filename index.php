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

// Récupère le controleur, la page et l'action (main, membre, get)
$controleur = !empty($_GET['$controleur']) ? $_GET['$controleur'] : 'main';
$GLOBALS['pageDemande'] = !empty($_GET['page']) ? $_GET['page'] : 'index';
$action = !empty($_GET['action']) ? $_GET['action'] : 'get';

// Charge le controleur
$controleur = Controleur::construct($controleur);

// Supprime les variables autres que les paramètres
unset($_GET['controleur'], $_GET['page'], $_GET['action']);

// Charger le controleur de la page demandé
$controleur->chargerControleurPage($GLOBALS['pageDemande'], $action, $_GET);
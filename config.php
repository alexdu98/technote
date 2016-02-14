<?php

/**
 * Fichier de configuration
 * @author Alexandre CULTY
 * @version 1.0
 */

mb_internal_encoding("UTF-8");

// BASE DE DONNEES
define('DB_NAME', 'technote');
define('DB_HOST', 'localhost');
define('DB_USER', 'technote');
define('DB_PASS', 'azshara26');

// DIVERS
define('NOM_COOKIE_CONNEXION', 'token');
define('NOM_SESSION_CONNEXION', 'user');

// STATISTIQUES
define('NB_SEC_ENTRE_2_VISITES', 60*60);
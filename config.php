<?php

/**
 * Fichier de configuration
 */

mb_internal_encoding("UTF-8");

// BASE DE DONNEES
define('DB_NAME', 'technote');
define('DB_HOST', 'localhost');
define('DB_USER', 'technote');
define('DB_PASS', 'azshara26');

// DIVERS
define('DUREE_COOKIE_AUTOCONNECT_SEC', 60 * 60 * 24 * 7);
define('DUREE_COOKIE_AUTOCONNECT_JOURS', 7);
define('SALT_TOKEN', 'j{djW|~QC*');

// STATISTIQUES
define('NB_SEC_ENTRE_2_VISITES', 60*60);
<?php

/**
 * Fichier de configuration
 */

// Indique l'encodage locale à PHP
mb_internal_encoding("UTF-8");

// BASE DE DONNEES
define('DB_NAME', 'technote');
define('DB_HOST', 'localhost');
define('DB_USER', 'technote');
define('DB_PASS', 'azshara26');

// COOKIES
define('DUREE_COOKIE_AUTOCONNECT_SEC', 60 * 60 * 24 * 7);
define('DUREE_COOKIE_AUTOCONNECT_JOURS', 7);

// SALT
define('SALT_TOKEN', 'j{djW|~QC*');
define('SALT_JETON_CSRF', '4}&Bl|/|)J');
define('SALT_RESET_PASS', 'b@dK|U^Qh:');

// PAGINATION
define('NB_TECHNOTE_ACCUEIL', 6);
define('NB_TECHNOTES_PAGE', 9);
define('NB_QUESTIONS_PAGE', 10);
define('NB_REPONSES_PAGE', 10);

// STATISTIQUES
define('NB_SEC_ENTRE_2_VISITES', 60 * 60);

// DIVERS
define('PRIVATE_KEY_RECAPTCHA', '6LdIRhgTAAAAAMKShVrZyBTvvJP08hHu2la0P_ks');
define('EXPEDITEUR_MAIL', 'no-reply@technote.dev');
define('DESTINATAIRE_MAIL_CONTACT', 'alexdu98@gmx.fr');
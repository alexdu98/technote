<?php

class Autoloader{

	/**
	 * Charge les classes automatiquement
	 * Usage : require('Autoloader.php');
	 *			Autoloader::Autoload();
	 * @static
	 */
	static public function Autoload(){
		spl_autoload_register(array(__CLASS__, 'register'));
	}

	/**
	 * @param String $classe La classe à charger
	 * @return bool True si classe charger, False si il y'a eu un problème
	 * @static
	 */
	static public function register($classe){
		// Les dossiers où vont être cherchées les classes
		$dossiers = array('core/', 'controleurs/', 'modeles/', 'modeles/DAO/', 'vues/');
		foreach($dossiers as $dossier){
			if(file_exists($dossier . $classe . '.php')){
				require  $dossier . $classe . '.php';
				return true;
			}
		}
		return false;
	}

}


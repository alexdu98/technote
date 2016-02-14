<?php

class Autoloader{

	static public function Autoload(){
		spl_autoload_register(array(__CLASS__, 'register'));
	}

	static public function register($classe){
		$dossiers = array('controleurs/', 'modeles/');
		foreach($dossiers as $dossier){
			if(file_exists($dossier . $classe . '.php')){
				require  $dossier . $classe . '.php';
				return true;
			}
		}
		return false;
	}

}

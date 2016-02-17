<?php

/**
 * Classe de connexion à la base de données
 * Design pattern Singleton pour n'ouvrir qu'une seule connexion
 */
class BDD{

	/**
	 * @var PDO $pdo L'objet PDO
	 * @static
	 */
	static private $pdo = NULL;

	/**
	 * Obtension du singleton
	 * @return PDO L'objet PDO
	 */
	static public function getInstancePDO(){
		if(self::$pdo == NULL){
			try{
				self::$pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
				self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // le fetch() retourne des objets std par défaut
				self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Les erreurs sont traitées comme exception
			}catch(PDOException $e){
				die('Problème de base de données');
			}
		}
		return self::$pdo;
	}

}
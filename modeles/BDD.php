<?php

class BDD{

	static private $pdo = NULL;

	static public function getInstancePDO(){
		if(self::$pdo == NULL){
			try{
				self::$pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
				self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			}catch(PDOException $e){
				die('Problème de base de données');
			}
		}
		return self::$pdo;
	}

}
<?php

/**
 * Classe abstraite pour l'accès aux données de la base
 * @abstract
 */
abstract class DAO{

	/**
	 * Id inconnu (ex: insert)
	 */
	const UNKNOWN_ID = -1;

	/**
	 * @var PDO $pdo Objet PDO pour l'accès à la table
	 */
	protected $pdo;

	/**
	 * Constructeur de DAO
	 * @param PDO $pdo La connexion
	 */
	public function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	/**
	 * Récupère une ligne grâce à ses identifiants
	 * @param array $id
	 */
	abstract public function getOne($id);

	/**
	 * Récupèrer toutes les lignes
	 */
	abstract public function getAll();

	/**
	 * Regroupe insert et update
	 *      id == UNKNOWN_ID ==> INSERT de tous les champs de l'objet
	 *      id != UNKNOWN_ID ==> UPDATE de tous les champs de l'objet sauf l'id qui sert dans le WHERE
	 * @param mixed $obj L'objet à enregistrer
	 */
	abstract public function save($obj);

	/**
	 * Supprime une ligne grâce à ses identifiants
	 * @param mixed $obj L'objet à supprimer
	 */
	abstract public function delete($obj);

}
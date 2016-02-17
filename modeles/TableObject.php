<?php

/**
 * Classe représentant un objet extrait d'une table de la base de données
 * Les champs sont créés définitivement par le constructeur
 * Implémente Iterator pour pouvoir faire des foreach sur les objets
 */
class TableObject extends Modele implements Iterator{

	/**
	 * @var array $fields Les champs de la table avec leur valeur
	 */
	protected $fields = array();

	/**
	 * @return array Liste des champs et de leur valeur
	 */
	public function getFields(){
		return $this->fields;
	}

	/**
	 * Constructeur permettant de copier les champs reçus
	 * @param array $fields
	 */
	public function __construct(array $fields){
		$this->fields = $fields;
	}

	/**
	 * @param string $field Le nom d'un champ
	 * @return mixed La valeur du champ
	 * @throws Exception Si le champ n'existe pas
	 */
	public function __get($field){
	    if(isset($this->fields[$field]))
	        return $this->fields[$field];
	    throw new Exception("Le champ '$field' n'existe pas dans la classe " . get_class($this));
	}

	/**
	 * @param string $field Le nom du champ à remplir
	 * @param mixed $value La valeur du champ à rmeplir
	 * @throws Exception Si le champ n'existe pas
	 */
	public function __set($field, $value){
	    if(isset($this->fields[$field]))
	        $this->fields[$field] = $value;
	    else
	        throw new Exception("Le champ '$field' n'existe pas dans la classe " . get_class($this));
	}

	/**
	 * @param string $field Le nom du champ à tester la présence
	 * @return bool
	 */
	public function __isset($field){
		return isset($this->fields[$field]);
	}

	/**
	 * @param string $field Le nom du champ à effacer
	 */
	public function __unset($field){
		unset($this->fields[$field]);
	}

	// Implémentation des méthodes d'Iterator pour les foreach sur objet

	public function current(){
		$var = current($this->fields);
		return $var;
	}

	public function next(){
		$var = next($this->fields);
		return $var;
	}

	public function key(){
		$var = key($this->fields);
		return $var;
	}

	public function valid(){
		$key = key($this->fields);
		$var = ($key !== NULL && $key !== FALSE);
		return $var;
	}

	public function rewind(){
		reset($this->fields);
	}

}
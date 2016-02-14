<?php

abstract class DAO{

	const UNKNOWN_ID = -1;
	protected $pdo;

	public function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	abstract public function getOne(array $id);

	abstract public function getAll();

	abstract public function save($obj);

	abstract public function delete($obj);

}
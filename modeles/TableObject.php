<?php 

class TableObject{

	protected $fields = array();

	public function getFields(){
		return $this->fields;
	}

	public function __construct($fields){
		$this->fields = $fields;
	}

	public function __get($field){
	    if(isset($this->fields[$field]))
	        return $this->fields[$field];
	    throw new Exception("Le champ '$field' n'existe pas dans la classe " . get_class($this));
	}

	public function __set($field, $value){
	    if(isset($this->fields[$field]))
	        $this->fields[$field] = $value;
	    else
	        throw new Exception("Le champ '$field' n'existe pas dans la classe " . get_class($this));
	}

	public function __isset($field){
		return isset($this->fields[$field]);
	}

}
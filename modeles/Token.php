<?php

class Token extends TableObject{

	static public function createToken(){
		return hash('sha256', uniqid(rand(), true) . SALT_TOKEN);
	}

	public function affiche(){
		echo 'IP de création : ' . $this->ip . ' / Expire le ' . $this->date_expiration;
	}

}
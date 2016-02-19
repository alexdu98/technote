<?php

class Token extends TableObject{

	static public function createToken(){
		return hash('sha512', uniqid(rand(), TRUE), SALT_TOKEN);
	}

}
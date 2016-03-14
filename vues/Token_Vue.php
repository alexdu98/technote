<?php

class Token_Vue extends Vue{

	public function affiche(){
		echo 'IP de création : ' . $this->ip . ' / Expire le ' . $this->date_expiration;
	}

}
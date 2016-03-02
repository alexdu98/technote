<?php

class Action extends TableObject{

	public function affiche(){
		echo $this->date_action . ' : <b>' . $this->libelle . '</b>';
	}

}
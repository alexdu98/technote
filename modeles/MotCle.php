<?php

class MotCle extends TableObject{

	public function toOption(){
		echo '<option value="' . $this->id_mot_cle . '">' . $this->label . '</option>';
	}

}
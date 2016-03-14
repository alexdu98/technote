<?php

class MotCle_Vue extends Vue{

	public function toOption(){
		echo '<option value="' . $this->id_mot_cle . '">' . $this->label . '</option>';
	}

}
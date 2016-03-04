<?php

class Technote extends TableObject{

	public function afficherExtrait(){
		$str = '';
		foreach($this->mot_cle as $mot_cle)
			$str .= $mot_cle->label . ', ';
		$str = substr($str, 0, -2);

		echo '
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">' . $this->titre . '</div>
					<div class="panel-body">
						<div class="col-md-12 text-center">
							<img src="' . $this->url_image . '" alt="test" class="img-thumbnail img-technote">
						</div>
						<div class="col-md-12 text-justify">
							' . substr($this->contenu, 0, 256) . '...
						</div>
					</div>
					<div class="panel-footer">' . $str . '</div>
				</div>
			</div>
		';
	}

}
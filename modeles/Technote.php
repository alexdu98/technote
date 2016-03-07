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
					<div class="panel-heading">
						<a href="/technotes/get?id_technote=' . $this->id_technote . '" role="button">' 
							. $this->titre . 
						'</a>
					</div>
					<div class="panel-body">
						<div class="col-md-12 text-center">
							<a href="/technotes/get?id_technote=' . $this->id_technote . '" role="button">
								<img src="' . $this->url_image . '" alt="test" class="img-thumbnail img-technote">
							</a>
						</div>
						<div class="col-md-12 text-justify">
							' . substr($this->contenu, 0, 256) . '...
						</div>
					</div>
					<div class="panel-footer">' 
						. $str . 						
					'</div>
				</div>
			</div>
		';
	}

}
<?php

class Technote extends TableObject{


	public function afficherExtrait(){

		$strMotCle = '';
		foreach($this->mot_cle as $mot_cle)
			$strMotCle .= '<a href="recherche?type=motcle&value=test">' . $mot_cle->label . '</a>, ';
		$strMotCle = substr($strMotCle, 0, -2);

		if(true): ?>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="/technotes/get/<?= $this->id_technote; ?>"><?= ucfirst($this->titre); ?></a>
					</div>
					<div class="panel-body">
						<a href="/technotes/get/<?= $this->id_technote; ?>" class="extraitTechnote">
							<div class="col-md-12 text-center">
								<img src="<?= $this->url_image; ?>" alt="test" class="img-thumbnail img-technote">
							</div>
							<div class="col-md-12 text-justify">
								<?= ucfirst(strip_tags(substr($this->contenu, 0, 383))); ?>...
							</div>
						</a>
					</div>
					<div class="panel-footer">
						<?= $strMotCle; ?>
					</div>
				</div>
			</div>
		<?php endif;
	}

}
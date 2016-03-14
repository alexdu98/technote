<?php

class TechnoteVue extends Vue{

	public function afficherExtraits(){
		$i = 0;

		foreach($this->params as $tn){

			$strMotCle = '';
			foreach($tn->mot_cle as $mot_cle){
				$strMotCle .= '<a href="motscles/get/' . $mot_cle->id_mot_cle . '">' . $mot_cle->label . '</a>, ';
			}
			$strMotCle = substr($strMotCle, 0, -2);

			if($i%3 == 0)
				echo '<div class="row">';

			if(true): ?>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<a href="/technotes/get/<?= $tn->id_technote; ?>"><?= ucfirst($tn->titre); ?></a>
						</div>
						<div class="panel-body">
							<a href="/technotes/get/<?= $tn->id_technote; ?>" class="extraitTechnote">
								<div class="col-md-12 text-center">
									<img src="<?= $tn->url_image; ?>" alt="test" class="img-thumbnail img-technote">
								</div>
								<div class="col-md-12 text-justify">
									<?= ucfirst(strip_tags(substr($tn->contenu, 0, 383))); ?>...
								</div>
							</a>
						</div>
						<div class="panel-footer">
							<?= $strMotCle; ?>
						</div>
					</div>
				</div>
			<?php endif;

			if($i%3 == 2)
				echo '</div>';

			$i++;
		}
	}

}
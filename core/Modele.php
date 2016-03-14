<?php

class Modele{

	static public function pagination(){
		// Recuperation du numéro de la page courante
		$page = !empty($_GET['page']) ? intval($_GET['page']) : 1;

		// Récupération des technotes à afficher
		$debut = ($page - 1) * NB_TN_PAGE;

		// Pour le nb de pages de la navigation
		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		$count = intval($technoteDAO->getCount());

		$nbPages = $count / NB_TN_PAGE;
		if ($count % NB_TN_PAGE != 0) $nbPages++;
		$fin = $debut + NB_TN_PAGE > $count ? 1 : 0;

		$std = new StdClass();
		$std->nbPages = $nbPages;
		$std->debut = $debut;
		$std->fin = $fin;
		$std->page = $page;
		return $std;
	}

	static public function afficherPagination($nbPages, $page, $fin, $url){
		if(true): ?>
			<nav class="text-center">
				<ul class="pagination">
					<?php if(isset($page) && $page > 1): ?>
						<li>
							<a href="<?= $url . ($page - 1) ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
					<?php endif; ?>
					<?php for($i = 1; $i < $nbPages; $i++): ?>
						<?php if($i == $page): ?>
							<li class="active"><a href="<?= $url . $i ?>"><?= $i ?></a></li>
						<?php else: ?>
							<li><a href="<?= $url . $i ?>"><?= $i ?></a></li>
						<?php endif; ?>
					<?php endfor; ?>
					<?php if(!$fin && isset($page)): ?>
						<li>
							<a href="<?= $url . ($page + 1) ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		<?php endif;
	}

}
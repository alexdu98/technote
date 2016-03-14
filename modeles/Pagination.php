<?php

class Pagination{

	private $nbPages;
	public $debut;
	private $fin;
	private $page;
	private $count;

	public function __construct($page, $count){
		$this->page = $page;
		$this->count = $count;
		$this->debut = ($page - 1) * NB_TECHNOTE_PAGE;
		$this->nbPages = $this->count / NB_TECHNOTE_PAGE;
		if ($this->count % NB_TECHNOTE_PAGE != 0) $this->nbPages++;
		$this->fin = $this->debut + NB_TECHNOTE_PAGE > $this->count ? 1 : 0;

		$std = new StdClass();
		$std->nbPages = $this->nbPages;
		$std->debut = $this->debut;
		$std->fin = $this->fin;
		$std->page = $this->page;
		return $std;
	}

	public function afficher($url){
		if(true): ?>
			<nav class="text-center">
				<ul class="pagination">
					<?php if(isset($this->page) && $this->page > 1): ?>
						<li>
							<a href="<?= $url . ($this->page - 1) ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
								</a>
							</li>
						<?php endif; ?>
					<?php for($i = 1; $i < $this->nbPages; $i++): ?>
						<?php if($i == $this->page): ?>
							<li class="active"><a href="<?= $url . $i ?>"><?= $i ?></a></li>
							<?php else: ?>
							<li><a href="<?= $url . $i ?>"><?= $i ?></a></li>
							<?php endif; ?>
						<?php endfor; ?>
					<?php if(!$this->fin && isset($this->page)): ?>
						<li>
							<a href="<?= $url . ($this->page + 1) ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			<?php endif;
	}

}
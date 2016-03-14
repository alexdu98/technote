<?php

class Pagination_Vue extends Vue{

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
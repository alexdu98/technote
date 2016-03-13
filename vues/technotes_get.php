<h1>Toutes les technotes</h1>
<section>
	<div class="container-fluid">
		
		<!-- PAGINATION -->
		<nav class="text-center">
			<ul class="pagination">
				<?php if (isset($v_page) && $v_page > 1): ?>
					<li>
						<a href="/technotes/get?page=<?= $v_page - 1 ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
				<?php endif; ?>
				<?php for($i = 1; $i < $v_nbPages; $i++): ?>
					<?php if($i == $v_page): ?>
						<li class="active"><a href="/technotes/get?page=<?= $i ?>"><?= $i ?></a></li>
					<?php else: ?>
						<li><a href="/technotes/get?page=<?= $i ?>"><?= $i ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>
				<?php if(!$v_fin && isset($v_page)): ?>
					<li>
						<a href="/technotes/get?page=<?= $v_page + 1 ?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>
		
		<!-- AFFICHAGE TECHNOTES -->
		<div class="container-fluid">
			<?php
				$i = 0;
				foreach($v_technotes as $technote){
					if($i%3 == 0)
						echo '<div class="row">';
                    $technote->afficherExtrait();
                    if($i%3 == 2)
						echo '</div>';
                    $i++;
				}
            ?>
		</div>

		<!-- PAGINATION -->
		<nav class="text-center">
			<ul class="pagination">
				<?php if (isset($v_page) && $v_page > 1): ?>
					<li>
						<a href="/technotes/get?page=<?= $v_page - 1 ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
				<?php endif; ?>
				<?php for($i = 1; $i < $v_nbPages; $i++): ?>
					<?php if($i == $v_page): ?>
						<li class="active"><a href="/technotes/get?page=<?= $i ?>"><?= $i ?></a></li>
					<?php else: ?>
						<li><a href="/technotes/get?page=<?= $i ?>"><?= $i ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>
				<?php if(!$v_fin && isset($v_page)): ?>
					<li>
						<a href="/technotes/get?page=<?= $v_page + 1 ?>" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</nav>
		
	</div>
</section>
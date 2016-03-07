<h1>Toutes les technotes</h1>

<section>
	<div class="container-fluid">
		<nav class="text-center">
			<ul class="pager">
				<?php if ($v_nav != 1): ?>
				<li><a href="/technotes/get?nav=<?= $v_nav - 1; ?>">Précédent</a></li>
			    <?php endif;?>
			    <?php if (!$v_fin):?>
			    <li><a href="/technotes/get?nav=<?= $v_nav + 1; ?>">Suivant</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</div>
	<div class="container-fluid">
		<?php
			$i = 0;
			foreach($v_tn as $tn){
				if($i%3 == 0)
					echo '<div class="row">';
				$tn->afficherExtrait();
				if($i%3 == 2)
					echo '</div>';
				$i++;
			}
		?>
	</div>
	<div class="container-fluid">
		<nav class="text-center">
			<ul class="pager">
				<?php if ($v_nav != 1): ?>
				<li><a href="/technotes/get?nav=<?= $v_nav - 1; ?>">Précédent</a></li>
			    <?php endif;?>
			    <?php if (!$v_fin):?>
			    <li><a href="/technotes/get?nav=<?= $v_nav + 1; ?>">Suivant</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</div>
</section>
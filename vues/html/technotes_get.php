<h1>Toutes les technotes</h1>
<section>
	<div class="container-fluid">
		
		<!-- PAGINATION -->
		<?php $v_pagination->afficher('/technotes/get?page='); ?>
		
		<!-- AFFICHAGE TECHNOTES -->
		<?php $v_technotes->AfficherExtraits(); ?>

		<!-- PAGINATION -->
		<?php $v_pagination->afficher('/technotes/get?page='); ?>
		
	</div>
</section>
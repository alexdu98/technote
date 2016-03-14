<h1>Toutes les technotes</h1>
<section>
	<div class="container-fluid">
		
		<!-- PAGINATION -->
		<?php Modele::afficherPagination($v_pagination->nbPages, $v_pagination->page, $v_pagination->fin, '/technotes/get?page='); ?>
		
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
		<?php Modele::afficherPagination($v_pagination->nbPages, $v_pagination->page, $v_pagination->fin, '/technotes/get?page='); ?>
		
	</div>
</section>
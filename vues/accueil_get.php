<h1>Les dernières technotes</h1>
<section>
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
</section>
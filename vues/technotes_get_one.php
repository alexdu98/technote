<div class="container-fluid">
	<section class="row">
		<h1 class="jumbotron"><?= $v_tn->getFields()['titre']; ?></h1>
		<p>
			<?= $v_tn->getFields()['contenu']; ?>
		</p>
			
		<div class="panel panel-default">
			<div class="panel-body">
				<?php
					// Pour afficher les mots-clés
					$str = "";
					
					foreach($v_tn->getFields()['mot_cle'] as $mot_cle)
						$str .= $mot_cle->label . ', ';
					
					$str = substr($str, 0, -2);
					echo $str;
				?>
			</div>
								
		</div>
	</section>
</div>
	
	

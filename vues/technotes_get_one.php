<div class="container">
<div class="row">

	
		<h1 class="jumbotron"><?= $v_tn->getFields()['titre']; ?></h1>
		
		<p>
			<?= $v_tn->getFields()['contenu']; ?>
		</p>
			
		<div class="panel panel-default">
			<div class="panel-body">
				<p>
					Mots-clés : 
					<?php
						// Pour afficher les mots-clés
						$str = "";
						
						foreach($v_tn->getFields()['mot_cle'] as $mot_cle)
							$str .= $mot_cle->label . ', ';
						
						$str = substr($str, 0, -2);
						echo $str;
					?>
					<a class="btn btn-default" href="technotes/get?id_technote= <?= $v_tn->getFields()['id_technote'];?> " role="button">Consulter</a>
				</p>
			</div>
								
		</div>
		
	</div>
	
	
			
		
		
		
	</div>
	
	
</div>
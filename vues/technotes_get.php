<h1>Toutes les technotes</h1>
<div class="container">
	<div class="row">
		
		<?php foreach ($v_tn as $tn) : ?>
			
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?= $tn->getFields()['titre']; ?></h3>
					</div>
					<div class="panel-body">
						<?= $tn->getFields()['contenu']; ?>
					</div>
					<div class="panel-footer">
						<?php
							// Pour afficher les mots-clés
							$str = "";
							
							foreach($tn->getFields()['mot_cle'] as $mot_cle)
								$str .= $mot_cle->label . ', ';
							
							$str = substr($str, 0, -2);
							echo $str;
						?>
					</div>	
				</div>
			</div>
			
		<?php endforeach; ?>
		
		
	</div>
	
	<nav class="text-center">
  		<ul class="pagination">
    		<li>
      			<a href="#" aria-label="Previous">
        			<span aria-hidden="true">&laquo;</span>
      			</a>
    		</li>
		    <li><a href="#">1</a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		    <li><a href="#">5</a></li>
		    <li>
		      <a href="#" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
  		</ul>
	</nav>
</div>



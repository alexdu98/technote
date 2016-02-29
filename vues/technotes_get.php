<h1>Toutes les technotes</h1>
<div class="container">
	<div class="row">
		<?php if(isset($v_technote1)) : ?>	
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote1['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote1['contenu']; ?>
				</div>	
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($v_technote2)) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote2['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote2['contenu']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
				
		<?php if(isset($v_technote3)) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote3['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote3['contenu']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($v_technote4)) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote4['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote4['contenu']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($v_technote5)) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote5['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote5['contenu']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(isset($v_technote6)) : ?>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $v_technote6['titre']; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo $v_technote6['contenu']; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
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



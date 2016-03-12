<h1>Ecrire une technote</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<?php if(!empty($v_res)): ?>
			<div class="alert alert-<?php if($v_res['success']) echo 'success'; else echo 'danger'; ?> alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?= $v_res['msg']; ?>
			</div>
		<?php endif; ?>
		<form method="POST" class="container form-horizontal">
			<div class="form-group">
				<label for="titre" >Titre</label>
				<input type="text" name="titre" class="form-control" id="titre" placeholder="Titre de la technote" maxlength="31" value="<?php if(isset($_POST['titre'])) echo $_POST['titre']; ?>" required>
			</div>
			<div class="form-group">
				<textarea name="contenu" id="contenu" class="form-control" rows="25" cols="6" placeholder="Contenu de la technote..."></textarea>
				<script>
					// Replace the <textarea id="editor1"> with a CKEditor
	                // instance, using default configuration.
	                CKEDITOR.replace( 'contenu' );
				</script>
			</div>
			
		</form>
	</div>
</div>
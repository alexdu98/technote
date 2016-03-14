<h1>Écrire une technote</h1>
<section>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="text-center text-danger text">* champs obligatoires</p>
				<?php if(!empty($v_res)): ?>
					<div class="alert alert-<?php if($v_res['success']) echo 'success'; else echo 'danger'; ?> alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="flex">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<ul>
								<?php if($v_res['success'] === false): ?>
									<?php foreach($v_res['messages'] as $message): ?>
										<li><?= $message; ?></li>
									<?php endforeach; ?>
								<?php else: ?>
									<li><?= $v_res['messages']; ?></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
				<form method="POST" class="form-horizontal">
					<div class="form-group">
						<label for="titre" class="col-md-2 control-label">Titre*</label>
						<div class="col-md-10">
							<input type="text" name="titre" class="form-control" id="titre" placeholder="Titre" maxlength="63" value="<?php if(isset($_POST['titre'])) echo $_POST['titre']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="url_image" class="col-md-2 control-label">URL image*</label>
						<div class="col-md-10">
							<input type="url" name="url_image" class="form-control" id="url_image" placeholder="URL image" maxlength="1023" value="<?php if(isset($_POST['url_image'])) echo $_POST['url_image']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="contenu" class="col-md-2 control-label">Contenu*</label>
						<div class="col-md-10">
							<textarea name="contenu" id="contenu" class="form-control" rows="25" cols="6"></textarea>
						</div>
						<script>
			                CKEDITOR.replace('contenu');
						</script>
					</div>
					<div class="form-group">
						<label for="mots-cles" class="col-md-2 control-label">Mots-clés</label>
						<div class="col-md-10">
							<select name="mots-cles[]" class="form-control" id="mots-cles" multiple="multiple">
								<?php
									foreach($v_motsCles as $motCle)
										$motCle->toOption();
								?>
							</select>
						</div>
						<script>
							$(document).ready(function() {
								$('#mots-cles').multiselect({
									buttonWidth: '100%',
									nonSelectedText: 'Aucun mot-clé sélectionné',
									nSelectedText: ' mots-clés sélectionnés',
									filterPlaceholder: 'Rechercher un mot-clé',
									enableFiltering: true,
									maxHeight: 400,
									dropUp: true
								});
							});
						</script>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-10">
							<input type="submit" class="btn btn-default" value="Envoyer">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
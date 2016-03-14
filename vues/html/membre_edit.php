<h1>Modification du profil</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li role="presentation"><a href="/membre/get">Profil</a></li>
			<li role="presentation" class="active"><a href="/membre/edit">Modifier</a></li>
		</ul>
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
				<label for="email" class="col-sm-2 control-label">Email*</label>
				<div class="col-sm-10">
					<input type="email" name="email" class="form-control" id="email" placeholder="<?= $_SESSION['user']->email; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-default" value="Valider">
				</div>
			</div>
			<input type="hidden" name="jetonCSRF" value="<?= $_SESSION['jetonCSRF']; ?>">
		</form>
		<hr>
		<form method="POST" class="form-horizontal">
			<div class="form-group">
				<label for="passwordNow" class="col-sm-2 control-label">Mot de passe actuel*</label>
				<div class="col-sm-10">
					<input type="password" name="passwordNow" class="form-control" id="passwordNow" placeholder="Mot de passe actuel" required>
				</div>
			</div>
			<div class="form-group">
				<label for="passwordNew" class="col-sm-2 control-label">Nouveau mot de passe*</label>
				<div class="col-sm-10">
					<input type="password" name="passwordNew" class="form-control" id="passwordNew" placeholder="Nouveau mot de passe" required>
				</div>
			</div>
			<div class="form-group">
				<label for="passwordNewConfirm" class="col-sm-2 control-label">Confirmation nouveau mot de passe*</label>
				<div class="col-sm-10">
					<input type="password" name="passwordNewConfirm" class="form-control" id="passwordNewConfirm" placeholder="Confirmation nouveau mot de passe" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-default" value="Valider">
				</div>
			</div>
			<input type="hidden" name="jetonCSRF" value="<?= $_SESSION['jetonCSRF']; ?>">
		</form>
	</div>
</div>

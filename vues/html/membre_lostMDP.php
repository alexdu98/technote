<h1>Mot de passe oublié</h1>
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
			<?php if(!empty($v_etape) && $v_etape == 'formMDP'): ?>
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
			<?php else: ?>
			<div class="form-group">
				<label for="pseudoEmail" class="col-sm-2 control-label">Pseudo ou email*</label>
				<div class="col-sm-10">
					<input type="text" name="pseudoEmail" class="form-control" id="pseudoEmail" placeholder="Pseudo ou email" required>
				</div>
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Captcha*</label>
				<div class="col-sm-10">
					<div class="g-recaptcha" data-sitekey="6LdIRhgTAAAAAETW0QglcOGfBb3cYMTlcYOkWozt"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-default" value="Valider">
				</div>
			</div>
		</form>
	</div>
</div>
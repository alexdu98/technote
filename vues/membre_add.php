<h1>Inscription</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<?php if(!empty($v_res)): ?>
			<div class="alert alert-<?php if($v_res['success']) echo 'success'; else echo 'danger'; ?> alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?= $v_res['msg']; ?>
			</div>
		<?php endif; ?>
		<form method="POST" class="form-horizontal">
			<div class="form-group">
				<label for="pseudo" class="col-sm-2 control-label">Pseudo</label>
				<div class="col-sm-10">
					<input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo" maxlength="31" required>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Mot de passe</label>
				<div class="col-sm-10">
					<input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required>
				</div>
			</div>
			<div class="form-group">
				<label for="passwordConfirm" class="col-sm-2 control-label">Confirmation mot de passe</label>
				<div class="col-sm-10">
					<input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Confirmation mot de passe" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="conditions" required> J'ai lu et j'accepte les <a href="/conditions" target="_blank">conditions d'utilisation</a>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="g-recaptcha" data-sitekey="6LdIRhgTAAAAAETW0QglcOGfBb3cYMTlcYOkWozt"></div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-default" value="Inscription">
				</div>
			</div>
		</form>
	</div>
</div>
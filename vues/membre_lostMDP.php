<h1>Mot de passe oublié</h1>
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
				<label for="pseudoEmail" class="col-sm-2 control-label">Pseudo ou email</label>
				<div class="col-sm-10">
					<input type="text" name="pseudoEmail" class="form-control" id="pseudoEmail" placeholder="Pseudo ou email" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
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
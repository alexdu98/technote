<h1>Inscription</h1>
<div class="panel panel-default">
	<div class="panel-body">
		<form method="POST" class="form-horizontal">
			<div class="form-group">
				<label for="pseudo" class="col-sm-2 control-label">Pseudo</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="pseudo" placeholder="Pseudo" required>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" placeholder="Email" required>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Mot de passe</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="password" placeholder="Password" required>
				</div>
			</div>
			<div class="form-group">
				<label for="passwordConfirm" class="col-sm-2 control-label">Confirmation mot de passe</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="passwordConfirm" placeholder="Confirmation mot de passe" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" required> J'ai lu et j'accepte les conditions d'utilisation
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
<script src='https://www.google.com/recaptcha/api.js'></script>
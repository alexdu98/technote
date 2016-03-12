<h1>Contact</h1>
<section>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCUWe7-YqqNblh58wp_ciY0u_B8evxqa9g"></script>
				<script>
					function initialize() {
						var mapProp = {
							center:new google.maps.LatLng(43.631417, 3.861584),
							zoom:15,
							mapTypeId:google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
					}
					google.maps.event.addDomListener(window, 'load', initialize);
				</script>
				<div id="googleMap" style="width:100%;height:400px;"></div>
				<br>
				<h4 class="text-center">Adresse</h4>
				<address class="text-center">
					Université Montpellier 2<br>
					Place Eugène Bataillon<br>
					34095 Montpellier cedex 5<br>
					France
				</address>
				<h4 class="text-center">Téléphone</h4>
				<p class="text-center">
					Tél: 04 67 14 30 30<br>
					Fax: 04 67 14 30 31
				</p>
				<h4 class="text-center">Email</h4>
				<p class="text-center">
					Email: <a href="mailto:admin@technote.dev">admin@technote.dev</a>
				</p>
				<hr>
				<h3 class="text-center">Formulaire de contact</h3>
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
					<?php if(!$_SESSION['user']): ?>
						<div class="form-group">
							<label for="pseudo" class="col-sm-2 control-label">Pseudo*</label>
							<div class="col-sm-10">
								<input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Pseudo" maxlength="31" value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email*</label>
							<div class="col-sm-10">
								<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
							</div>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="sujet" class="col-sm-2 control-label">Sujet*</label>
						<div class="col-sm-10">
							<input type="text" name="sujet" class="form-control" id="sujet" placeholder="Sujet" maxlength="63" value="<?php if(isset($_POST['sujet'])) echo $_POST['sujet']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="message" class="col-sm-2 control-label">Message*</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="10" name="message" id="message" placeholder="Message" maxlength="2047" required><?php if(isset($_POST['message'])) echo $_POST['message']; ?></textarea>
						</div>
					</div>
					<?php if(!$_SESSION['user']): ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Captcha*</label>
							<div class="col-sm-10">
								<div class="g-recaptcha" data-sitekey="6LdIRhgTAAAAAETW0QglcOGfBb3cYMTlcYOkWozt"></div>
							</div>
						</div>
					<?php endif; ?>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" class="btn btn-default" value="Envoyer">
						</div>
					</div>
					<?php if($_SESSION['user']): ?>
						<input type="hidden" name="jetonCSRF" value="<?= $_SESSION['jetonCSRF']; ?>">
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
</section>
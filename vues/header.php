<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Technote</title>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="shortcut icon" href="/assets/images/favicon.ico">
	<link rel="stylesheet" href="/assets/librairies/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/assets/librairies/jquery/jquery.min.js"></script>
	<script src="/assets/librairies/bootstrap/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src='/assets/js/main.js'></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<header class="container-fluid">
				<div class="row">
					<div class="col-md-5 col-md-offset-6">
						<?php if($_SESSION['user']): ?>
							<div class="text-right">
								<a href="/membre"><?= ucfirst($_SESSION['user']->pseudo); ?></a> • <a href="/deconnexion">Déconnexion</a>
							</div>
						<?php else: ?>
							<form action="/connexion" method="POST" class="form-inline text-right">
								<div class="col-md-12">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><img src="/assets/images/pseudo.png" alt="Pseudo"></span>
											<input type="text" name="pseudo" class="form-control" placeholder="Pseudo" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><img src="/assets/images/MDP.png" alt="Mot de passe"></span>
											<input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
										</div>
									</div>
									<input type="submit" class="btn btn-default" value="Connexion"><br>
								</div>
								<div class="col-md-12 text-right conteneurLiensCo">
									<div class="col-md-9 text-right liensCo">
										• <a href="/membre/add">S'inscrire</a>
										• <a href="/membre/edit?mdp=1">Mot de passe oublié</a> •
									</div>
									<div class="col-md-3 liensCo">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="autoConnexion"> Resté connecté
											</label>
										</div>
									</div>
								</div>
								<?php if(!empty($v_connect) && $v_connect['success'] === false): ?>
									<div class="col-md-12 text-center">
										<div class="badLogin"><?= $v_connect['msg']; ?></div>
									</div>
								<?php endif; ?>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</header>
			<div id="logo" class="col-md-12">
				<img src="/assets/images/logo.png" alt="Logo">
			</div>
			<nav class="col-md-12 main">
				<div class="col-md-8 col-md-offset-2">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav nav-pills nav-justified">
							<li class="<?php if(isset($v_accueil)) echo "active";?>"><a href="/">Accueil</a></li>
							<li class="<?php if(isset($v_technotes)) echo "active";?>"><a href="/technotes">Technotes</a></li>
							<?php if($_SESSION['user']): ?>
								<li class="<?php if(isset($v_profile)) echo "active";?>"><a href="/membre">Profile</a></li>
							<?php endif; ?>
							<li class="<?php if(isset($v_contact)) echo "active";?>"><a href="/contact">Contact</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<article class="col-md-10 col-md-offset-1">

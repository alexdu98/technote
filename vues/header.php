<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Technote | <?php echo $GLOBALS['page']; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="shortcut icon" href="/assets/images/favicon.png">
	<link rel="stylesheet" href="/assets/librairies/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<header class="container-fluid">
		<div class="row">
			<div class="col-md-5 col-md-offset-6">
				<form method="POST" class="form-inline">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><img src="/assets/images/pseudo.png" alt="Pseudo"></span>
							<input type="text" class="form-control" placeholder="Pseudo">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><img src="/assets/images/MDP.png" alt="Mot de passe"></span>
							<input type="password" class="form-control" placeholder="Mot de passe">
						</div>
					</div>
					<input type="submit" class="btn btn-default" value="Connexion">
					• <a href="">S'inscrire</a>
					• <a href="">Mot de passe oublié</a> •
					<div class="checkbox">
						<label>
							<input type="checkbox"> Resté connecté
						</label>
					</div>
				</form>
			</div>
		</div>
	</header>
	<div id="logo" class="col-md-12">
		<img src="/assets/images/logo.png" alt="Logo">
	</div>
	<nav class="col-md-12">
		<div class="col-md-8 col-md-offset-2">
			<ul class="nav nav-pills nav-justified">
				<li role="presentation" class="active"><a href="#">Accueil</a></li>
				<li role="presentation"><a href="#">Profile</a></li>
				<li role="presentation"><a href="#">Messages</a></li>
			</ul>
		</div>
	</nav>
	<article class="col-md-10 col-md-offset-1">

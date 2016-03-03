<html>
<head>
	<title><?= $this->sujet; ?></title>
	<meta charset="utf-8" />
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<style>
		*::selection{background:#2aabd2;color:#FFF;}
		body{font-size: 1.1em;}
		header{width:250px;height:100px;}
		h1{display: block;font-size: 24px;font-family: "Lobster", "cursive";color: #2aabd2;text-shadow: 2px 2px 1px #EEE, 3px 3px 5px #000;margin-bottom: 15px;}
		h1:first-letter{color:#333;}
		article a{color:#2aabd2;text-decoration:none;font-weight:bold;}
		article a:hover{border-bottom:1px dashed #2aabd2;}
		footer{margin:10px auto 0;padding:5px;display:table;}
		.info{font-size: .8em;}
	</style>
</head>
<body>
	<header>
		<a href="http://technote.dev"><img src="http://img4.hostingpics.net/pics/947233logo.png" alt="Logo Technote"></a>
	</header>
	<article>
		<h1><?= $this->sujet; ?></h1>
		<p>
			Bonjour <?= ucfirst($this->param['pseudo']); ?>,
		</p>
		<div>
			<?= $corps; ?>
		</div>
	</article>
	<footer>
		<p>
			Cordialement,<br>
			L'équipe de Technote
		</p>
		<p class="info">
			IP : <?= $_SERVER['REMOTE_ADDR']; ?><br>
			Date : <?= $date; ?>
		</p>
		</p>
	</footer>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>

<h1><?= ucfirst($_SESSION['user']->pseudo); ?></h1>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="/membre/get">Profil</a></li>
			<li role="presentation"><a href="/membre/edit">Modifier</a></li>
		</ul>
		<div class="col-md-8">
			<p>
				Connexion automatique sur <?= $v_nbTokenActif; ?> navigateur(s) <br>
				<?php
					if($v_tokenActif)
						foreach($v_tokenActif as $token)
							echo $token->affiche() . '<br>';
				?>
			</p>
			<br>
			<p>
				Vous avez rédigé :
				<ul>
					<li><b><?= $v_nbTechnoteRedige; ?></b> technote(s)</li>
					<li><b><?= $v_nbCommentaireRedige; ?></b> commentaire(s)</li>
					<li><b><?= $v_nbQuestionRedige; ?></b> question(s)</li>
					<li><b><?= $v_nbReponseRedige; ?></b> réponse(s)</li>
				</ul>
			</p>
		</div>
		<div class="col-md-4 text-right">
			<p><b>Date inscription :</b> <?= $_SESSION['user']->date_inscription; ?></p>
			<p><b>Dernière connexion :</b> <?= $_SESSION['user']->date_connexion; ?></p>
			<p><b>Groupe :</b> <?= $_SESSION['user']->groupe; ?></p>
		</div>
		<div class="col-md-12 text-center"><hr>
			<h4>Dernières actions</h4>
			<?php foreach($v_actions as $action): ?>
				<p><?php $action->affiche(); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
</div>
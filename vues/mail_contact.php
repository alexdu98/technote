<p>
	<?= $this->param['pseudoExpediteur'];?> (<?php if($_SESSION['user']) echo 'connecté'; else echo 'non connecté'; ?>) à envoyé un formulaire de contact sur Technote.<br>
	Email : <?= $this->param['email'];?><br>
	Sujet : <?= $this->param['sujet'];?>
</p>
<p>
	Message : <br>
	<hr>
	<?= $this->param['message'];?>
	<hr>
</p>
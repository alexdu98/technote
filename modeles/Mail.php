<?php

class Mail{

	static public $expediteur = EXPEDITEUR_MAIL;

	public $destinataire;

	public $sujet;

	public $vue;

	public $param;

	public function __construct($destinataire, $sujet, $vue, $param){
		$this->destinataire = $destinataire;
		$this->sujet = $sujet;
		$this->vue = $vue;
		$this->param = $param;
	}

	public function addHeaderFooter(){
		ob_start();
		include('/vues/' . $this->vue);
		$corps = ob_get_clean();
		$date = date('d/m/Y à H:i');
		ob_start();
		include('/vues/mail_base.php');
		$message = ob_get_clean();
		return $message;
	}

	public function sendMail(){
		$message = $this->addHeaderFooter();
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: no-reply@technote.dev <no-reply@technote.dev>' . "\r\n";
		if(mail($this->destinataire, $this->sujet, $message, $headers))
			return true;
		else
			return 'L\'email n\'a pas pu être envoyé, veuillez réessayer plus tard';
	}

}
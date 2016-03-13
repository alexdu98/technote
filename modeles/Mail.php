<?php

class Mail{

	static public $expediteur = EXPEDITEUR_MAIL;
	private $destinataire;
	private $sujet;
	private $vue;
	private $param;

	public function __construct($destinataire, $sujet, $vue, $param){
		$this->destinataire = $destinataire;
		$this->sujet = $sujet;
		$this->vue = $vue;
		$this->param = $param;
	}

	public function sendMail(){
		$std = new StdClass();
		$message = $this->addHeaderFooter();
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: no-reply@technote.dev <no-reply@technote.dev>' . "\r\n";
		if(mail($this->destinataire, $this->sujet, $message, $headers))
			return array('success' => true, 'messages' => 'L\'email a été envoyé avec succès');
		else
			return array('success' => false, 'messages' => 'L\'email n\'a pas pu être envoyé, veuillez réessayer plus tard');
	}

	private function addHeaderFooter(){
		ob_start();
		include('/vues/mail/' . $this->vue);
		$corps = ob_get_clean();
		$date = date('d/m/Y à H:i');
		ob_start();
		include('/vues/mail/mail_base.php');
		$message = ob_get_clean();
		return $message;
	}

}
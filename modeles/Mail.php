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
		$std = (object) array('success' => false, 'msg' => array());

		$message = $this->addHeaderFooter();
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: no-reply@technote.dev <no-reply@technote.dev>' . "\r\n";

		if(mail($this->destinataire, $this->sujet, $message, $headers)){
			$std->success = true;
			$std->msg[] = 'L\'email a été envoyé avec succès';
		}
		else
			$std->msg[] = 'L\'email n\'a pas pu être envoyé, veuillez réessayer plus tard';

		return $std;
	}

	private function addHeaderFooter(){
		$vue = new Vue();
		$twig = $vue->get();
		return $twig->render('mail/' . $this->vue, $this->param);
	}

}
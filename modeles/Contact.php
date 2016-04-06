<?php

class Contact{

	private $pseudo;
	private $email;
	private $sujet;
	private $message;
	private $captcha;

	public function __construct(&$param){
		if($_SESSION['user']){
			$this->pseudo = $_SESSION['user']->pseudo;
			$this->email = $_SESSION['user']->email;
		}
		else{
			$this->pseudo = $param['pseudo'];
			$this->email = $param['email'];
			$this->captcha = $param['g-recaptcha-response'];
		}
		$this->sujet = $param['sujet'];
		$this->message = $param['message'];
	}

	public function sendMail(){
		$resCheck = $this->check();
		$res = $resCheck;
		if($resCheck->success === true){
			$param = array(
				'pseudo' => 'Admin',
				'pseudoExpediteur' => $this->pseudo,
				'emailExpediteur' => $this->email,
				'sujet' => $this->sujet,
				'message' => nl2br($this->message)
			);
			$mail = new Mail(DESTINATAIRE_MAIL_CONTACT, '[Technote.dev] Contact', 'mail_contact.twig', $param);
			$resMail = $mail->sendMail();
			$res->success = $resCheck->success && $resMail->success;
			$res->msg = array_merge($res->msg, $resMail->msg);
			if($resMail->success === true){
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => 'Contact par formulaire',
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
			}
		}
		return $res;
	}

	private function check(){
		$std = (object) array('success' => false, 'msg' => array());

		if(!$_SESSION['user']){
			if(($res = Membre::checkPseudo($this->pseudo)) !== true)
				$std->msg[] = $res;
			if(($res = Membre::checkEmail($this->email)) !== true)
				$std->msg[] = $res;
			$captcha = new Captcha();
			if(($res = $captcha->check($this->captcha)) !== true)
				$std->msg[] = $res;
		}
		if(($res = $this->checkSujet($this->sujet)) !== true)
			$std->msg[] = $res;
		if(($res = $this->checkMessage($this->message)) !== true)
			$std->msg[] = $res;

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	private function checkMessage(&$message){
		if(!empty($message)){
			if(mb_strlen(strip_tags($message)) == mb_strlen($message)){
				if(mb_strlen($message) >= 8 && mb_strlen($message) <= 2047)
					return true;
				return 'Le message ne respecte pas les règles de longueur (8 à 2047 caractères)';
			}
			return 'Les balises HTML sont interdites dans le message (un espace est nécessaire après un \'<\')';
		}
		return 'Le message n\'est pas renseigné';
	}

	private function checkSujet(&$sujet){
		if(!empty($sujet)){
			if(mb_strlen(strip_tags($sujet)) == mb_strlen($sujet)){
				if(mb_strlen($sujet) >= 3 && mb_strlen($sujet) <= 63)
					return true;
				return 'Le sujet ne respecte pas les règles de longueur (3 à 63 caractères)';
			}
			return 'Les balises HTML sont interdites dans le sujet (un espace est nécessaire après un <)';
		}
		return 'Le sujet n\'est pas renseigné';
	}

}
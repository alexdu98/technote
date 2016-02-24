<?php

class Vue{
	/*
	 * La classe Vue permet de manipuler et de remplir les differents gabarits html
	 * du dossier vues.
	 * Elle permet de faire disparaitre ls instructions php des gabarits. Alors l'ensemble
	 * des documents du dossier vues pourront etre renommes avec l'extension ".html". (Documents plus faciles a rendre valides W3C, dit en passant)
	 * Le remplissage des gabarits html se fait par substitution (à l'aide de la fonction str_replace)
	 * des mot-clefs entoures par des accolades (car l'accolade est inemploye dans le langage html) avec des valeurs calculees et generees
	 * par PHP.
	 * 
	 * */
	private $fileContent;

	public function __construct($fichier, $connect){
		// $fichier = page a laquelle on veut accéder
		// $connect : booléen. Vrai si l'usr est connecté, faux sinon.
		if ($connect) {
			/* Il y a deux headers, un pour membre connecte et l'autre pour non-connecte */
			$this->fileContent = file_get_contents("vues/header-connected.html");
			$this->fileContent .= file_get_contents("vues/$fichier");
			
			/* Là ce serait Membre et MembreDAO a la place d'Utilisateurs*/
			$usr = new Utilisateurs($_SESSION['pseudo']);
			$this->configurerTab( $usr->getInfo() );

		} else {
			$this->fileContent = file_get_contents("vues/header-not-connected.html");
			$this->fileContent .= file_get_contents("vues/$fichier");
		}
		
		$this->fileContent .=  file_get_contents("vues/footer.html");
		$this->configurer('annee', date('Y'));
	}

	public function configurer($motClef, $valeur){
		$this->fileContent = str_replace("{".$motClef."}", $valeur, $this->fileContent);
	}

	public function configurerTab($tab){
		foreach($tab as $motClef => $valeur){
			$this->configurer($motClef, $valeur , $this->fileContent);
		}
	}

	public function configurerAvecObjet($obj){
		foreach($obj as $motClef=>$valeur)
			$this->configurer($motClef , $valeur);
	}

	/*
	 * Cette methode sert pour les structures iteratives quand y faudra 
	 * afficher toutes les technotes, ou tous les topics de forum...
	 */
	public function configurerObjListe($cursor, $max){ // Quand on a une liste (attr1, attr2, ..., attrN)
		$cpt = 0;
		while ($obj = $cursor->fetchObject() ){
			foreach($obj as $motClef=>$valeur){
				$this->configurer("$motClef$cpt", $valeur);
				$this->configurer("mode$cpt", "block");
			}
			$cpt += 1;
		}
		while ($cpt<=$max){ // si la page n'est pas complète, on cache les champs vides qui restent
			$this->configurer("mode$cpt" , "none");
			$cpt += 1;
		}
	}

	public function configurerArrayListe($cursor, $max){ // Quand on a une liste (attr1, attr2, ..., attrN)
		$cpt = 0;
		foreach($cursor as $val){
			foreach($val as $motClef=>$valeur){
				$this->configurer("$motClef$cpt", $valeur);
				$this->configurer("mode$cpt", "block");
			}
			$cpt += 1;
		}
		while ($cpt<=$max){ // si la page n'est pas complète, on cache les champs vides qui restent
			$this->configurer("mode$cpt" , "none");
			$cpt += 1;
		}
	}

	// -----------------------------------------------------------
	public function afficher(){
		echo $this->fileContent;
	}


}
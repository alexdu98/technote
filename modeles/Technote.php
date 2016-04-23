<?php

class Technote extends TableObject{

	static public function recherche(&$param, $page){
		$std = (object) array('success' => false, 'msg' => array());
		$cond = array();
		$strPagination = '';

		if(!empty($param['titre'])){
			$cond['titre'] = $param['titre'];
			$strPagination .= '&titre=' . urlencode($param['titre']);
		}

		if(!empty($param['date_debut'])){
			if(($res = Date::verifierDate($param['date_debut'])) !== true)
				$std->msg[] = $res . ' (date de début)';
			else{
				$cond['date_debut'] = $param['date_debut'];
				$strPagination .= '&date_debut=' . $param['date_debut'];
			}
		}

		if(!empty($param['date_fin'])){
			if(($res = Date::verifierDate($param['date_fin'])) !== true)
				$std->msg[] = $res . ' (date de fin)';
			else{
				$cond['date_fin'] = $param['date_fin'];
				$strPagination .= '&date_fin=' . $param['date_fin'];
			}
		}

		if(!empty($param['auteur'])){
			$membreDAO = new MembreDAO(BDD::getInstancePDO());
			if(($res = $membreDAO->checkPseudoExiste($param['auteur'])) === false)
				$std->msg[] = 'Aucun membre avec ce pseudo';
			else{
				$cond['auteur'] = $param['auteur'];
				$strPagination .= '&auteur=' . $param['auteur'];
			}
		}

		if(!empty($param['mots_cles'])){
			$tabMC = explode(',', $param['mots_cles']);
			$tabMCClean = array();
			foreach($tabMC as $key => $value){
				$valueClean = trim($value);
				if($valueClean != ''){
					$tabMCClean[] = $valueClean;
					if($valueClean[0] == '+')
						$valueClean = substr($valueClean, 1);
					if(($res = MotCle::checkExisteByLabel($valueClean)) !== true)
						$std->msg[] = $res;
				}
			}
			$cond['mots_cles'] = $tabMCClean;
		}

		if(!empty($std->msg))
			return $std;

		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		// On récupère le nombre de technotes qu'on a en résultat
		$count = $technoteDAO->getTechnotesWithSearch(NB_TECHNOTES_PAGE, $cond, true);

		// On créé la pagination
		$std->pagination = new Pagination($page, $count, NB_TECHNOTES_PAGE, '/technotes?recherche=' . $strPagination . '&page=');

		// On récupère les technotes
		$std->technotes = $technoteDAO->getTechnotesWithSearch(NB_TECHNOTES_PAGE, $cond, false, $std->pagination->debut);

		if(empty($std->technotes))
			$std->msg[] = 'Aucune technote avec ces critères';
		else
			$std->success = true;
		return $std;
	}



	static public function dropTechnote($id_technote){
		$res = (object) array('success' => false, 'msg' => array());

		$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
		if($_SESSION['user']->groupe == 'Membre' || $_SESSION['user']->groupe == 'Modérateur'){
			$res->success = $technoteDAO->noVisible($id_technote);
		}
		elseif($_SESSION['user']->groupe == 'Administrateur'){
			$res->success = $technoteDAO->delete($id_technote);
		}

		if($res->success)
			$res->msg[] = 'La technote a bien été supprimée';
		else
			$res->msg[] = 'Erreur BDD';

		return $res;
	}

	static public function editTechnote(&$param, &$files, $id_technote){
		$resCheck = self::checkTechnote($param, $files, 'edit');
		$res = $resCheck;
		if($resCheck->success === true){
			$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
			$technote = new Technote(array(
				'id_technote' => $id_technote,
				'titre' => $param['titre'],
				'contenu' => $param['contenu'],
				'id_modificateur' => $_SESSION['user']->id_membre,
				'url_image' => $param['url_image'],
				'description' => $param['description'],
				'publie' => $param['publie']
			));
			if(($resSaveTechnote = $technoteDAO->save($technote)) !== false){
				$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$decrire = new Decrire(array('id_technote' => $id_technote, 'id_mot_cle' => $id_mot_cle));
						$decrireDAO->save($decrire);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Modification d\'une technote (technote n°$id_technote)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->msg[] = 'Modification de la technote réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie et ajoute une technote
	 * @param array $param Les attributs de la technotes
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static public function addTechnote(&$param, &$files){
		$resCheck = self::checkTechnote($param, $files, 'add');
		$res = $resCheck;
		if($resCheck->success === true){
			$technoteDAO = new TechnoteDAO(BDD::getInstancePDO());
			$technote = new Technote(array(
				'id_technote' => DAO::UNKNOWN_ID,
				'titre' => $param['titre'],
				'contenu' => $param['contenu'],
				'id_auteur' => $_SESSION['user']->id_membre,
				'url_image' => $param['url_image'],
				'description' => $param['description'],
				'publie' => $param['publie'],
				'visible' => '1'
			));
			if(($resSaveTechnote = $technoteDAO->save($technote)) !== false){
				$decrireDAO = new DecrireDAO(BDD::getInstancePDO());
				if(!empty($param['id_mot_cle'])){
					foreach($param['id_mot_cle'] as $id_mot_cle){
						$decrire = new Decrire(array('id_technote' => $resSaveTechnote->id_technote, 'id_mot_cle' => $id_mot_cle));
						$decrireDAO->save($decrire);
					}
				}
				$actionDAO = new ActionDAO(BDD::getInstancePDO());
				$action = new Action(array(
					'id_action' => DAO::UNKNOWN_ID,
					'libelle' => "Ajout d\'une technote (technote n°$resSaveTechnote->id_technote)",
					'id_membre' => $_SESSION['user']->id_membre
				));
				$actionDAO->save($action);
				$res->success = true;
				$res->id_technote = $resSaveTechnote->id_technote;
				$res->msg[] = 'Ajout de la technote réussie';
			}
			else{
				$res->success = false;
				$res->msg[] = 'Erreur BDD';
			}
		}
		return $res;
	}

	/**
	 * Vérifie les attributs d'une technote
	 * @param array $param Les attributs à vérifier
	 * @return object 2 attributs, bool success et array string msg
	 * @static
	 */
	static private function checkTechnote(&$param, &$files, $typeCheck){
		$std = (object) array('success' => false, 'msg' => array());

		if(($res = Technote::checkDescription($param['description'])) !== true)
			$std->msg[] = $res;
		if(($res = Technote::checkPublie($param['publie'])) !== true)
			$std->msg[] = $res;
		if(($res = Technote::checkTitre($param['titre'])) !== true)
			$std->msg[] = $res;
		if(($res = Technote::checkContenu($param['contenu'])) !== true)
			$std->msg[] = $res;

		// Si on ajoute une technote, ou que c'est une édition avec modification de l'image
		if($typeCheck == 'add' || !empty($files['image'])){
			if(($res = Technote::checkImage($files['image'])) !== true)
				$std->msg[] = $res;
			// On génère un nom aléatoire
			do{
				$gen = uniqid(rand());
				$nom = pathinfo($files['image']['name'], PATHINFO_FILENAME);
				$extension = pathinfo($files['image']['name'], PATHINFO_EXTENSION);
				$base = dirname(__FILE__) . '/..';
				$chemin = '/assets/images/uploads/' . $nom . $gen . '.' . $extension;
			}while(file_exists($base . $chemin));

			if(move_uploaded_file($files['image']['tmp_name'], $base . $chemin)){
				$param['url_image'] = $chemin;
			}
			else{
				$std->msg[] = 'Problème de déplacement de l\'image sur le serveur, veuillez contacter un admin';
			}
		}
		// Sinon on vérifie l'url de l'image
		else{
			if(($res = Technote::checkURLImage($param['url_image'])) !== true){
				$std->msg[] = $res;
			}
		}

		if(!empty($param['id_mot_cle'])){
			foreach($param['id_mot_cle'] as $id_mot_cle){
				if(($res = MotCle::checkExiste($id_mot_cle)) !== true)
					$std->msg[] = $res;
			}
		}

		if(empty($std->msg))
			$std->success = true;
		return $std;
	}

	static public function checkPublie(&$publie){
		if(isset($publie)){
			if($publie == 0 || $publie == 1)
				return true;
			else
				return 'La valeur de publié n\'est pas correcte';
		}
		return 'La valeur de publié n\'est pas renseigné';
	}

	static public function checkDescription(&$description){
		if(!empty($description)){
			if(mb_strlen(strip_tags($description)) == mb_strlen($description)){
				if(mb_strlen($description) >= 15 && mb_strlen($description) <= 383){
					return true;
				}
				return 'La description ne respecte pas les règles de longueur (15 à 383 caractères)';
			}
			return 'Les balises HTML sont interdites dans la description (un espace est nécessaire après un \'<\')';
		}
		return 'La description n\'est pas renseigné';
	}

	/**
	 * Vérifie le titre d'une technote
	 * @param string $titre Le titre à vérifier
	 * @return bool|string True si le titre est valide, un message sinon
	 * @static
	 */
	static public function checkTitre(&$titre){
		if(!empty($titre)){
			if(mb_strlen(strip_tags($titre)) == mb_strlen($titre)){
				if(mb_strlen($titre) >= 3 && mb_strlen($titre) <= 63){
					return true;
				}
				return 'Le titre ne respecte pas les règles de longueur (3 à 63 caractères)';
			}
			return 'Les balises HTML sont interdites dans le titre (un espace est nécessaire après un \'<\')';
		}
		return 'Le titre n\'est pas renseigné';
	}

	/**
	 * Vérifie le contenu d'une technote
	 * @param string $contneu Le contenu à vérifier
	 * @return bool|string True si le contenu est valide, un message sinon
	 * @static
	 */
	static public function checkContenu(&$contenu){
		if(!empty($contenu)){
			if(mb_strlen($contenu) >= 15 && mb_strlen($contenu) <= 65535){
				return true;
			}
			return 'Le contenu ne respecte pas les règles de longueur (15 à 65535 caractères)';
		}
		return 'Le contenu n\'est pas renseigné';
	}

	/**
	 * Vérifie le lien de l'image d'une technote
	 * @param string $url L'URL de l'image à vérifier
	 * @return bool|string True si l'URL de l'image est valide, un message sinon
	 * @static
	 */
	static public function checkImage(&$image){
		if(!empty($image) && $image['error'] != UPLOAD_ERR_NO_FILE){
			if($image['error'] == UPLOAD_ERR_OK){
				$typesAcceptes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
				$typeDetecte = exif_imagetype($image['tmp_name']);
				if(in_array($typeDetecte, $typesAcceptes)){
					if($image['size'] < 1048576){
						return true;
					}
					return 'L\'image est trop volumineuse';
				}
				return 'Le fichier n\'est pas une image (png,jpeg';
			}
			return 'Une erreur (code:' . $image['error'] . ') est survenue lors du télécharement de l\'image, veuillez réessayer';
		}
		return 'L\'image n\'est pas renseigné';
	}

	/**
	 * Vérifie le lien de l'image d'une technote
	 * @param string $url L'URL de l'image à vérifier
	 * @return bool|string True si l'URL de l'image est valide, un message sinon
	 * @static
	 */
	static public function checkURLImage(&$url){
		if(!empty($url)){
			if(preg_match('#^/assets/images/uploads/#', $url)){
				if(file_exists(dirname(__FILE__) . '/..' . $url)){
					return true;
				}
				return 'L\'URL de l\'image n\'existe pas';
			}
			return 'L\'URL de l\'image n\'est pas valide';
		}
		return 'L\'URL de l\'image n\'est pas renseigné';
	}

}
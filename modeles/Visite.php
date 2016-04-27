<?php

class Visite extends TableObject{

	/**
	 * Vérifie si une visite est nouvelle (< NB_SEC_ENTRE_2_VISITES)
	 * Si c'est inférieur enregistrement dans la BDD, sinon rien
	 * @param Visite $visite La viste à vérifier
	 */
	public function checkVisite($visite){
		$visiteDAO = new VisiteDAO(BDD::getInstancePDO());
		$lastVisite = $visiteDAO->getLastVisite($visite->ip);
		$timeStamp1Heure = time() - NB_SEC_ENTRE_2_VISITES;

		if($lastVisite === false){
			// Si c'est la premiere fois que le client vient sur le site
			$lastVisite = new stdClass();
			$lastVisite->date_visite = 1;
		}
		if(strtotime($lastVisite->date_visite) <= $timeStamp1Heure){
			$visiteDAO->save($visite);
		}
	}

	/**
	 * Récupère les statistiques des visites
	 * @return array Un tableau des statistiques sur les visites
	 * @static
	 */
	static public function getStat(){
		$visiteDAO = new VisiteDAO(BDD::getInstancePDO());
		$arr['total'] = $visiteDAO->getCount();
		$arr['today'] = $visiteDAO->getCountToday();
		$arr['now'] = $visiteDAO->getCountNow();
		return $arr;
	}

}
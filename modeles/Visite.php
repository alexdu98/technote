<?php

class Visite extends TableObject{

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

}
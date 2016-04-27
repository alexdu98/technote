<?php

class Date{

	/**
	 * Vérifie la validité d'une date
	 * @param $date La date à vérifier
	 * @return bool|string Vrai si date valide, string sinon
	 * @static
	 */
	static public function verifierDate(&$date){
		if(!empty($date)){
			$tdate = explode('-', $date);
			if(count($tdate) == 3 && is_numeric($tdate[0]) && is_numeric($tdate[1]) && is_numeric($tdate[2])){
				list($annee, $mois, $jour) = $tdate;
				if(checkdate($mois, $jour, $annee))
					return true;
				return 'La date est invalide';
			}
			return 'La date doit être au format aaaa-mm-jj (2016-01-30)';
		}
		return 'La date n\'est pas renseigné';
	}

}
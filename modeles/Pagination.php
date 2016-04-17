<?php

class Pagination{

	/**
	 * @var int le nombre de page total
	 */
	public $nbPages;
	/**
	 * @var int Numéro du premier élément devant être charger
	 */
	public $debut;
	/**
	 * @var bool True si c'est la dernière page, false sinon
	 */
	public $fin;
	/**
	 * @var int Page actuelle
	 */
	public $page;
	/**
	 * @var int Nombre d'éléments total
	 */
	public $count;
	/**
	 * @var int Nombre d'éléments par page
	 */
	public $nbElementPage;
	/**
	 * @var string URL pour la pagination
	 */
	public $url;

	/**
	 * Constructeur de pagination
	 * @param int $page La page demandé
	 * @param int $count Le nombre d'élément total
	 * @param int $nbElementPage Le nombre d'élément par page
	 * @param string $url L'URL des boutons de pagination
	 */
	public function __construct($page, $count, $nbElementPage, $url){
		$this->url = $url;
		$this->page = $page;
		$this->count = $count;
		$this->nbElementPage = $nbElementPage;
		$this->debut = ($page - 1) * $nbElementPage;
		$this->nbPages = floor($this->count / $nbElementPage);
		if($this->count % $nbElementPage != 0)
			$this->nbPages++;
		$this->fin = $this->debut + $nbElementPage >= $this->count ? true : false;
	}

}
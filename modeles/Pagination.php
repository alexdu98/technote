<?php

class Pagination{

	public $nbPages;
	public $debut;
	public $fin;
	public $page;
	public $count;
	public $nbElementPage;
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
		$this->fin = $this->debut + $nbElementPage > $this->count ? 1 : 0;
	}

}
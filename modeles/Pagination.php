<?php

class Pagination{

	public $nbPages;
	public $debut;
	public $fin;
	public $page;
	public $count;
	public $url;

	public function __construct($page, $count, $url){
		$this->url = $url;
		$this->page = $page;
		$this->count = $count;
		$this->debut = ($page - 1) * NB_TECHNOTE_PAGE;
		$this->nbPages = floor($this->count / NB_TECHNOTE_PAGE);
		if($this->count % NB_TECHNOTE_PAGE != 0)
			$this->nbPages++;
		$this->fin = $this->debut + NB_TECHNOTE_PAGE > $this->count ? 1 : 0;
	}

}
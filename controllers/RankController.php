<?php

class RankController extends BaseController {
	
	protected function onInit() {
		$this -> title = 'Rank';
		$this -> model = new RankModel();
		$this -> location = "my_albums";
		$this->sub_location = "";
	}

	public function index($page = 0, $pageSize = 6) {
		
		$this->renderView();		
		
	}

	public function users(){
		$this->renderView();		
	}
	
	public function albums(){
		$this->renderView();		
	}
	
	public function pictures(){
		$this->renderView();		
	}

}

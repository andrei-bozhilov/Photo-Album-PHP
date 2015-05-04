<?php

class RankController extends BaseController {
	
	protected function onInit() {
		$this -> title = 'Rank';
		$this -> model = new RankModel();
		$this -> location = "";
		$this->sub_location = "";
	}

	public function index() {
		$this->redirectToUrl('/rank/users');
	}

	public function users(){
		$this->sub_location = "users";
		$this->renderView();		
	}
	
	public function albums(){
		$this->sub_location = "albums";
		$this->renderView();		
	}
	
	public function pictures(){
		$this->sub_location = "pictures";
		$this->renderView();		
	}

}

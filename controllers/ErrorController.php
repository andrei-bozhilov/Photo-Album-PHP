<?php

class ErrorController extends BaseController {
	
	protected function onInit() {
		$this -> title = 'Error';
		
	}

	public function index() {
		$this->renderView();		
	}
}
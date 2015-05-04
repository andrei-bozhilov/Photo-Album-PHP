<?php

class HomeController extends BaseController {
	protected function onInit() {
		$this -> title = 'Welcome';
		$this -> model = new HomeModel();
		$this ->location = "home";
	}

	public function index($page = 0, $pageSize = 3) {
		$this->renderView();
		$this -> getAlbums($page, $pageSize);
		
	}

	public function getAlbums($page = 0, $pageSize = 6) {
		$from = $page * $pageSize;
		$albums_result = $this -> model -> getAlbumsWithPictures($from, $pageSize);

		$albums = array();
		$album_name = "";
		$albumCount = -1;

		for ($i = 0; $i < count($albums_result); $i++) {
			if ($album_name != $albums_result[$i]['album_name']) {
				$album_name = $albums_result[$i]['album_name'];
				$pic_acount = 0;
				$albumCount++;
			}

			if ($pic_acount > 3) {
				continue;
			}

			$albums[$albumCount][$pic_acount++] = $albums_result[$i];
		}

		$this -> albums = $albums;
		$this->renderView(__FUNCTION__, true);
	}
	
	public function album($id)
	{
		$this->renderView();
	}
}

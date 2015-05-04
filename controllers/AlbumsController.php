<?php

class AlbumsController extends BaseController {
	
	protected function onInit() {
		$this -> title = 'My albums';
		$this -> model = new AlbumsModel();
		$this -> location = "my_albums";
		$this->sub_location = "";
	}

	public function index($page = 0, $pageSize = 6) {
		$this->authorized();
		$this->sub_location = "index";
		$this->renderView();		
		$this -> getAlbumsForCurrentUser($page, $pageSize);
	}

	public function getAlbumsForCurrentUser($page = 0, $pageSize = 6) {
		$this->authorized();
		$this->albums = $this->model->get_users_albums($this->getUserId());
		$user_id = $this->getUserId();
		$from = $page * $pageSize;
		$albums_result = $this-> model-> getAlbumsWithPictures($from, $pageSize, $user_id);

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

		$this -> albums_with_pics = $albums;
		
		$this->renderView(__FUNCTION__, true);
		
	}
	
	public function user_albums()
	{
		$this->authorized();
		$this->sub_location = "user_albums";
		$this->renderView();
	}
	
	public function user_pictures()
	{
		$this->authorized();
		$this->sub_location = "user_pictures";
		$this->renderView();
	}

}

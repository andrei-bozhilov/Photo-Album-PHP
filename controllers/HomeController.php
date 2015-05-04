<?php

class HomeController extends BaseController {
	protected function onInit() {
		$this -> title = 'Welcome';
		$this -> model = new HomeModel();
		$this -> location = "home";
	}

	public function index() {
		$this -> pics = $this -> model -> getTopTenPic();
		$this -> renderView();
		$this -> getAlbums();
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
		$this -> renderView(__FUNCTION__, true);
	}

	public function album($id) {
		if (!ctype_digit($id)) {
			$this -> redirectToUrl('/error');
		}
		$rating = $this -> model -> getAlbumRating($id);
		$this -> rating = intval(round($rating[0]['value'], 0));
		$this -> album = $this -> model -> getAlbumsWithPicturesById($id);
		$this -> album_id = $id;
		$this -> renderView();
	}
}

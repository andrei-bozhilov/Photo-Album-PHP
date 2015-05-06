<?php

class HomeController extends BaseController {
	protected function onInit() {
		$this -> title = 'Welcome';
		$this -> model = new HomeModel();
		$this -> location = "home";
	}

	public function index() {
		$this -> pics = $this -> model -> getNewestPictures();
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

		$album = $this -> model -> getAlbumById($id);
				
		if ($album == null) {
			$this -> album = null;
		}else{
			$this -> album = $album[0];
			$rating = $this -> model -> getAlbumRating($id);
			$this -> rating = round($rating[0]['value'], 0);
			$this -> comments = $this -> model -> getAlbumComments($id);
		}
		
		$this -> renderView();
	}

	public function getPictures($id, $page = 0, $pageSize = 12) {
		$from = $page * $pageSize;
		$this -> album = $this -> model -> getAlbumWithPicturesById($id, $from, $pageSize);
		$this -> renderView(__FUNCTION__, true);
	}

	public function getPictureComments($id) {
		$this -> comments = $this -> model -> getPictureComments($id);
		$this -> renderView(__FUNCTION__, true);
	}

}

<?php

class UserController extends BaseController {

	protected function onInit() {
		$this -> title = 'My albums';
		$this -> model = new UserModel();
		$this -> location = "my_albums";
		$this -> sub_location = "";
	}

	public function index($page = 0, $pageSize = 6) {
		$this -> authorized();
		$this -> sub_location = "index";
		$this -> renderView();
		$this -> getAlbumsForCurrentUser($page, $pageSize);
	}

	public function getAlbumsForCurrentUser($page = 0, $pageSize = 6) {
		$this -> authorized();
		$this -> albums = $this -> model -> getUsersAlbums($this -> getUserId());
		$user_id = $this -> getUserId();
		$from = $page * $pageSize;
		$albums_result = $this -> model -> getAlbumsWithPictures($from, $pageSize, $user_id);

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

		$this -> renderView(__FUNCTION__, true);

	}

	public function albums() {
		$this -> authorized();
		$this -> sub_location = "user_albums";
		$user_id = $this -> getUserId();
		$this -> albums = $this -> model -> getAlbumsInfo($user_id);
		$this -> renderView();
	}

	public function pictures() {
		$this -> authorized();
		$this -> sub_location = "user_pictures";
		$this -> renderView();
	}

	public function rateAlbum($album_id, $value) {
		$this -> authorized(true);
		$user_id = $this -> getUserId();

		$check = $this -> model -> checkIsAlbumOwnByUser($album_id, $user_id);

		if ($check) {
			$this -> addErrorMessage("Connot rate yours albums.");
			$this -> redirectToUrl('/home/album/' . $album_id);
		}

		$result = $this -> model -> rateAlbum($album_id, $value, $user_id);

		if ($result) {
			$this -> addInfoMessage("Albums is rated.");
			$this -> redirectToUrl('/home/album/' . $album_id);
		} else {
			$this -> addInfoMessage("Sorry there was an error, try to login first");
		}
	}

	public function commentPicture() {
		if ($this -> isPost()) {
			$this -> authorized(true);
			
			$album_id = $_POST['albumId'];
			$text = $_POST['text'];
			$picture_id =$_POST['pictureId'];
			
			$user_id = $this -> getUserId();
			$result = $this -> model -> addCommentToPicture($text, $user_id, $picture_id);

			if ($result) {
				$this -> addInfoMessage("Comment is added.");
				$this -> redirectToUrl('/home/album/' . $album_id);
			} else {
				$this -> addInfoMessage("Sorry there was an error.");
			}
		}
	}

	public function commentAlbum() {
		if ($this -> isPost()) {
			$this -> authorized(true);

			$album_id = $_POST['albumId'];
			$text = $_POST['text'];

			$user_id = $this -> getUserId();

			$result = $this -> model -> addCommentToAlbum($text, $user_id, $album_id);

			if ($result) {
				$this -> addInfoMessage("Comment is added.");
				$this -> redirectToUrl('/home/album/' . $album_id);
			} else {
				$this -> addErrorMessage("Sorry there was an error.");
			}
		}
	}

}

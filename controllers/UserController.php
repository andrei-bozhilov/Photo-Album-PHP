<?php

class UserController extends BaseController {

	protected function onInit() {
		$this -> title = 'My albums';
		$this -> model = new UserModel();
		$this -> location = "my_albums";
		$this -> sub_location = "";
	}

	public function index() {
		$this -> authorized();
		$this -> sub_location = "index";
		$this -> renderView();
		$this -> getAlbumsForCurrentUser();
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
			if ($album_name != $albums_result[$i]['album_name'] . $albums_result[$i]['album_id']) {
				$album_name = $albums_result[$i]['album_name'] . $albums_result[$i]['album_id'];
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

	public function rateAlbum($album_id, $value) {
		$this -> authorized(true);
		$user_id = $this -> getUserId();

		$check = $this -> model -> checkIsAlbumOwnByUser($album_id, $user_id);

		if ($check) {
			$this -> addErrorMessage("Connot rate your albums.");
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
			$picture_id = $_POST['pictureId'];

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

	public function addAlbum() {
		$this -> authorized();

		if ($this -> isPost()) {
			$name = $_POST['name'];
			$category_id = $_POST['category'];

			if (empty($name) || strlen($name) < 3) {
				$this -> addErrorMessage("Name cannot be empty or less than 3 symbols.");
				$this -> redirectToUrl("/user/addAlbum");
			}

			if ($category_id == 0) {
				$this -> addErrorMessage("Please choose category.");
				$this -> redirectToUrl("/user/addAlbum");
			}

			$user_id = $this -> getUserId();

			$result = $this -> model -> createAlbum($name, $user_id, $category_id);

			if ($result) {
				$this -> addInfoMessage("Album is created.");
				$this -> redirectToUrl("/user/albums");
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
			}

		}

		$this -> categories = $this -> model -> getCategories();
		$this -> renderView();
	}

	public function editAlbum($id) {
		$this -> authorized();
		if ($this -> isPost()) {
			$user_id = $this -> getUserId();
			$check = $this -> model -> checkIsAlbumOwnByUser($id, $user_id);

			if (!$check) {
				$this -> addErrorMessage("This albums is not yours. Connot modified it.");
				$this -> redirectToUrl('/user/editAlbum/' . $id);
			}

			$name = $_POST['name'];
			$category_id = $_POST['category'];

			if (empty($name) || strlen($name) < 3) {
				$this -> addErrorMessage("Name cannot be empty or less than 3 symbols.");
				$this -> redirectToUrl("/user/editAlbum/" . $id);
			}

			if ($category_id == 0) {
				$this -> addErrorMessage("Please choose category.");
				$this -> redirectToUrl("/user/editAlbum/" . $id);
			}

			$result = $this -> model -> editAlbum($id, $name, $category_id);

			if ($result) {
				$this -> addInfoMessage("Album is modified.");
				$this -> redirectToUrl("/user/albums");
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
				$this -> redirectToUrl("/user/albums");
			}
		}

		$user_id = $this -> getUserId();
		$this -> album = $this -> model -> findAlbumByUser($id, $user_id);
		$this -> categories = $this -> model -> getCategories();
		$this -> renderView();
	}

	public function deleteAlbum($album_id) {
		$this -> authorized();
		$user_id = $this -> getUserId();
		if ($this -> isPost()) {
			$check = $this -> model -> checkIsAlbumOwnByUser($album_id, $user_id);

			if (!$check) {
				$this -> addErrorMessage("This albums is not yours. Connot delete it.");
				$this -> redirectToUrl('/user/albums/');
			}

			$result = $this -> model -> deleteAlbum($album_id);

			if ($result) {
				$this -> addInfoMessage("Album is deleted.");
				$this -> redirectToUrl("/user/albums");
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
				$this -> redirectToUrl("/user/albums");
			}
		}

		$this -> album = $this -> model -> findAlbumByUser($album_id, $user_id);
		$this -> picture_count = count($this -> model -> getPicturesInfo($user_id, $album_id));
		$this -> renderView();
	}

	public function pictures() {
		$this -> authorized();
		$this -> sub_location = "user_pictures";

		$user_id = $this -> getUserId();
		$this -> pictures = array();

		$this -> albums = $this -> model -> getUsersAlbums($user_id);
		$this -> album = null;

		if (isset($_GET['album'])) {
			$album_id = $_GET['album'];
			$this -> pictures = $this -> model -> getPicturesInfo($user_id, $album_id);
			$this -> album = $this -> model -> findAlbumByUser($album_id, $user_id);
		}

		$this -> renderView();
	}

	public function addPicture() {
		$this -> authorized();
		$user_id = $this -> getUserId();
		if ($this -> isPost()) {
			$picture_name = $_POST['name'];
			$album_id = $_POST['album'];

			if (empty($picture_name) || strlen($picture_name) < 3) {
				$this -> addErrorMessage("Name cannot be empty or less than 3 symbols.");
				$this -> redirectToUrl("/user/addPicture");
			}

			if ($album_id == 0) {
				$this -> addErrorMessage("Please choose album.");
				$this -> redirectToUrl("/user/addPicture");
			}

			$check = $this -> model -> checkIsAlbumOwnByUser($album_id, $user_id);

			if (!$check) {
				$this -> addErrorMessage("This albums is not yours. Connot add pictures to it.");
				$this -> redirectToUrl('/user/addPicture/' . $id);
			}

			if (isset($_FILES['picture'])) {
				// Make sure the file was sent without errors
				if ($_FILES['picture']['error'] == 0) {
					$data = file_get_contents($_FILES['picture']['tmp_name']);
				}
			} else {
				$data = null;
			}

			$result = $this -> model -> createPicture($picture_name, $data, $album_id);

			if ($result) {
				$this -> addInfoMessage("Picture is created.");
				$this -> redirectToUrl("/user/pictures");
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
			}
		}

		$this -> albums = $this -> model -> getUsersAlbums($user_id);
		$this -> renderView();
	}

	public function editPicture($id) {
		$this -> authorized();
		if ($this -> isPost()) {

		}

		$this -> renderView();
	}

	public function deletePicture($picture_id) {
		$this -> authorized();
		$user_id = $this -> getUserId();

		if ($this -> isPost()) {
			$check = $this -> model -> checkIsPictureIsInUserAlbum($user_id, $picture_id);

			if (!$check) {
				$this -> addErrorMessage("This picture is not yours. Connot delete it.");
				$this -> redirectToUrl("/user/pictures/");
			}

			$result = $this -> model -> deletePicture($picture_id);

			if ($result) {
				$this -> addInfoMessage("Picture is deleted.");
				$this -> redirectToUrl("/user/pictures");
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
				$this -> redirectToUrl("/user/pictures");
			}
		}

		$this -> picture = $this -> model -> findPictureByUser($user_id, $picture_id);
		$this -> renderView();
	}
	
	public function deletePicturesByAlbum($album_id) {
		$this -> authorized();
		$user_id = $this -> getUserId();

		if ($this -> isPost()) {
			$check = $this -> model -> checkIsAlbumOwnByUser($album_id, $user_id);
			if (!$check) {
				$this -> addErrorMessage("This pictures is not yours. Connot delete them.");
				$this -> redirectToUrl("/user/albums/");
			}

			$result = $this -> model -> deletePictureByAlbum($album_id);

			if ($result) {
				$this -> addInfoMessage("Pictures are deleted.");
				$this -> redirectToUrl("/user/deleteAlbum/" . $album_id);
			} else {
				$this -> addErrorMessage("Sorry there was a problem.");
				$this -> redirectToUrl("/user/albums");
			}
		}
	}

}

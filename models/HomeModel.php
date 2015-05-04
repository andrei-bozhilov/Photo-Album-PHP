<?php

class HomeModel extends BaseModel {

	public function getAlbumsWithPictures($from, $pageSize) {
		$squery = "select a.id as album_id, a.name as album_name, p.name as pic_name, p.picture as pic
		from pictures p
		Inner JOIN (select * from albums limit ?, ?) a
		 on a.id = p.album_id
		WHERE a.is_public = true and p.is_public = true
		Order by a.name";

		
		$statement = self::$db -> prepare($squery);
		$statement -> bind_param("ii", $from, $pageSize);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;
	}
	
	public function getAlbumsWithPicturesById($id) {
		$squery = "select a.id as album_id, a.name as album_name, p.name as pic_name, p.picture as pic
		from pictures p
		Inner JOIN (select * from albums limit ?, ?) a
		 on a.id = p.album_id
		WHERE a.is_public = true and p.is_public = true
		Order by a.name";

		
		$statement = self::$db -> prepare($squery);
		$statement -> bind_param("i", $id);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;
	}
}

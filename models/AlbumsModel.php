<?php

class AlbumsModel extends BaseModel {

	public function getAlbumsWithPictures($from, $pageSize, $user_id) {
		$squery = "select a.name as album_name, p.name as pic_name, p.picture as pic
		from pictures p
		Inner JOIN (select * from albums where albums.user_id = ? limit ?, ?) a
		 on a.id = p.album_id
		Order by a.name";
	
		$statement = self::$db -> prepare($squery);
		$statement -> bind_param("sii", $user_id, $from, $pageSize);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}
	
	public function get_users_albums($user_id)
	{
		$squery = "select * from albums where albums.user_id = ?";
		
		$statement = self::$db -> prepare($squery);
		$statement -> bind_param("i", $user_id);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}

	

}

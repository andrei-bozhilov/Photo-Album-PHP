<?php

class HomeModel extends BaseModel {

	public function getAlbumsWithPictures($from, $pageSize) {
		$query = "
		SELECT a.album_id, a.album_rating, a.album_name, p.name as pic_name, p.picture as pic
		FROM pictures p
		INNER JOIN (
		    SELECT a.id as album_id, a.name as album_name, AVG(r.value) as album_rating, a.created_date
		    FROM albums a
		    LEFT JOIN ratings r
		 ON a.id = r.album_id
         GROUP BY a.id, a.name, a.created_date
		    LIMIT ?, ?) a
		 ON a.album_id = p.album_id
		WHERE p.is_public = true
		ORDER BY a.album_rating DESC";

		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("ii", $from, $pageSize);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		/*$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};*/

		
	}
	
	public function getAlbumWithPicturesById($id, $from, $pageSize) {
		$query = "
		SELECT a.name as album_name, p.id as pic_id, p.name as pic_name, p.picture as pic, p.created_date as pic_date
		FROM albums a
		INNER JOIN pictures p
			ON a.id = p.album_id
		WHERE a.id = ?
		LIMIT ?, ?
		";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("iii", $id, $from, $pageSize);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		
		/*$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;*/
	}
	
	public function getAlbumRating($id)
	{
		$query = "
		SELECT AVG(r.value) as value
		FROM ratings r
		WHERE r.album_id = ?
		";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $id);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		
		/*$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;*/
	}
	
	public function getNewestPictures(){
		$query = "
		SELECT p.name as pic_name, p.album_id as album_id, p.picture as pic
		FROM pictures p
		WHERE p.is_public = true
		AND p.picture IS NOT NULL
		ORDER BY p.id DESC
		LIMIT 20
		";
		
		
		$result = self::$db->query($query);
		$fetch_result = $this->fetch($result);
		return $fetch_result;
		
		/*$results_array = array();
		while ($row = $result->fetch_assoc()) {
		  $results_array[] = $row;
		}
		return $results_array;	*/	
	}
	
	public function getAlbumById($id){
	
		$query = "
		SELECT *
		FROM albums a
		WHERE a.id = ?
		";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $id);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		
		/*$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;*/
	}
	
	public function getAlbumComments($id){
		$query = "
		SELECT u.username as username, c.text as comment, c.created_date as date
		FROM comments c
		JOIN users u
			on c.user_id = u.id
		WHERE c.album_id = ?
		ORDER BY c.id DESC
		";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $id);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		
		/*$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;*/
	}
	
	public function getPictureComments($id)
	{
		$query = "
		SELECT u.username as username, c.text as comment, c.created_date as date
		FROM comments c
		JOIN users u
			on c.user_id = u.id
		WHERE c.pic_id = ?
		ORDER BY c.id DESC
		";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $id);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		return $fetch_result;
		/*
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
		};

		return $fetch_result;*/
	}
}

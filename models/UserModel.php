<?php

class UserModel extends BaseModel {

	public function getAlbumsWithPictures($from, $pageSize, $user_id) {
		$query = "
		SELECT a.album_id, a.album_rating, a.album_name, p.name as pic_name, p.picture as pic
		FROM pictures p
		INNER JOIN (
		    SELECT a.id as album_id, a.name as album_name, AVG(r.value) as album_rating, a.created_date
		    FROM albums a
		    LEFT JOIN ratings r
		 ON a.id = r.album_id
		 WHERE a.user_id = ?
         GROUP BY a.id, a.name, a.created_date
		    LIMIt ?, ?) a
		 ON a.album_id = p.album_id
		ORDER BY a.created_date DESC";
	
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("sii", $user_id, $from, $pageSize);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}
	
	public function getUsersAlbums($user_id)
	{
		$query = "select * from albums where albums.user_id = ?";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $user_id);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}
	
	public function getAlbumsInfo($user_id)
	{
		$query = "
		SELECT a.id, a.name, pic_count, AVG(r.value) as rating
		FROM albums a
		LEFT JOIN ratings r 
		 on a.id = r.album_id
		LEFT JOIN (select album_id, count(id) as pic_count
		          from pictures
		          group by album_id) p 
		 on a.id = p.album_id 
		WHERE a.user_id = ?
		GROUP BY a.id, a.name";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("i", $user_id);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}
	
	public function rateAlbum($album_id, $value, $user_id){
        if ($album_id == '' || $value == '' || $user_id == '') {
            return false;
        }
        $query = 
        "INSERT INTO ratings(value, user_id, album_id)
		VALUES (?,?,?)";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("iii", $value, $user_id, $album_id);
        $statement->execute();
         return $statement->affected_rows > 0;
	}
	
	public function checkIsAlbumOwnByUser($album_id, $user_id){
		if ($album_id == '' || $user_id == '') {
            return false;
        }
        $query = 
        "select id from albums a
        where a.user_id = ? and a.id = ?";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("ii", $user_id, $album_id);
        $statement->execute();
		$result = $statement -> get_result();		
				
         return $result->num_rows > 0;
	}
	
	public function addCommentToPicture($text, $user_id, $picture_id){
        if ($text == '' || $user_id == '' || $picture_id == '') {
            return false;
        }    
		
		var_dump($text) ;
		
        $query = 
        "INSERT INTO `comments`(`text`, `created_date`, `user_id`, `pic_id`, `album_id`)
		VALUES (?,now(),?,?,null)";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("sii", $text, $user_id, $picture_id);
        $statement->execute();
         return $statement->affected_rows > 0;
	}
	
	public function addCommentToAlbum($text, $user_id, $album_id){
        if ($text == '' || $user_id == '' || $album_id == '') {
            return false;
        }      
		
        $query = 
        "INSERT INTO `comments`(`text`, `created_date`, `user_id`, `pic_id`, `album_id`)
		VALUES (?,now(),?,null,?)";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("sii", $text, $user_id, $album_id);
        $statement->execute();
         return $statement->affected_rows > 0;
	}

	

}

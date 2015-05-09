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
		$query = "
		SELECT * 
		FROM albums 
		WHERE albums.user_id = ?";
		
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
		SELECT a.id, a.name, c.name as category_name, IFNULL(pic_count, 0) as pic_count , AVG(r.value) as rating
		FROM albums a
		LEFT JOIN ratings r 
		 on a.id = r.album_id
		 LEFT JOIN categories c 
		 on c.id = a.category_id
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
        "
        SELECT id
        FROM albums a
        WHERE a.user_id = ? AND a.id = ?";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("ii", $user_id, $album_id);
        $statement->execute();
		$result = $statement -> get_result();		
				
         return $result->num_rows > 0;
	}
	
	public function checkIsPictureIsInUserAlbum($user_id, $picture_id){
		if ($user_id == '' || $picture_id == '') {
            return false;
        }
        $query = 
        "
        SELECT p.id
        FROM pictures p
        JOIN albums a
        	on p.album_id = a.id
        WHERE a.user_id = ? AND p.id = ?";
        
        $statement = self::$db->prepare($query);
        $statement->bind_param("ii", $user_id, $picture_id);
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

	public function findAlbumByUser($id, $user_id) {
		$query = "
		SELECT a.id as id, a.name as name, c.name as category, c.id as category_id
		FROM albums a
		JOIN categories c
			ON a.category_id = c.id
		WHERE a.id = ? AND a.user_id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("ii", $id, $user_id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }

    public function createAlbum($name, $user_id, $category_id) {
        if ($name == '') {
            return false;
        }
		
		$query = "
		INSERT INTO `albums`(`name`, `created_date`, `user_id`, `category_id`)
		VALUES(?, now(), ?, ?)";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("sis", $name, $user_id, $category_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function editAlbum($id, $name, $category_id) {
        if ($name == '') {
            return false;
        }
        $query = "
        UPDATE albums SET name = ?, category_id = ?
        WHERE id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("sii", $name, $category_id, $id);
        $statement->execute();
        return $statement->errno == 0;
    }

    public function deleteAlbum($id) {
    	$query =  "
    	DELETE FROM albums 
    	WHERE id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
	
	public function getCategories(){
		$statement = self::$db->query("SELECT * FROM categories ORDER BY id");
        return $statement->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getPicturesInfo($user_id, $album_id)
	{
		$query = "
		SELECT p.id as id, p.name as name, p.picture as pic, a.name as album_name, c.name as album_category
		FROM pictures p
		JOIN albums a
			ON p.album_id = a.id
		JOIN categories c
			ON a.category_id = c.id
		WHERE a.user_id = ?
		AND a.id = ?
		ORDER BY p.id";
		
		$statement = self::$db -> prepare($query);
		$statement -> bind_param("ii", $user_id, $album_id);
		$statement -> execute();
		$result = $statement -> get_result();
		$fetch_result = array();
		
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$fetch_result[] = $row;
			
		};

		return $fetch_result;
	}
	
	public function findPictureByUser($user_id, $picture_id) {
		$query = "
		SELECT p.name as name, p.picture as pic, a.name as album_name, a.id as album_id
        FROM pictures p
        JOIN albums a
        	on p.album_id = a.id
        WHERE a.user_id = ? AND p.id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("ii", $user_id, $picture_id);
        $statement->execute();
        return $statement->get_result()->fetch_assoc();
    }
	
	public function createPicture($name, $picture, $album_id) {
        if ($name == '' || $album_id == '') {
            return false;
        }
		
		$query = "
		INSERT INTO `pictures`(`name`, `picture`, `created_date`, `is_public`, `album_id`)
		VALUES (?,?,now(),1,?)";
	    $null = NULL;
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("sbi", $name, $null, $album_id);
		$statement->send_long_data(1, $picture);
        
        $statement->execute();
        return $statement->affected_rows > 0;
    }
    
    public function deletePicture($id) {
    	$query =  "
    	DELETE FROM pictures 
    	WHERE id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
	
	public function deletePictureByAlbum($album_id) {
    	$query =  "
    	DELETE FROM pictures 
    	WHERE album_id = ?";
		
        $statement = self::$db->prepare($query);
        $statement->bind_param("i", $album_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
}

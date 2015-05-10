<?php

class AccountModel extends BaseModel {
	public function login($username, $password) {
		$statement = self::$db -> prepare("SELECT id, username, password, is_admin FROM users WHERE username = ?");
		$statement -> bind_param("s", $username);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
		
		
		if (password_verify($password, $fetch_result[0]['password'])) {
			return true;
		}

		return "Invalid username or password.";
		
		
		/*

		$result = $statement -> get_result() -> fetch_assoc();
	
		if (password_verify($password, $result['password'])) {
			return true;
		}

		return "Invalid username or password.";*/
	}

	public function register($username, $password) {
		$statement = self::$db -> prepare("SELECT Count(id) FROM users WHERE username = ?");
		$statement -> bind_param("s", $username);
		$statement -> execute();

		$statement->store_result();
		$fetch_result = $this->fetch($statement);

		if ($fetch_result[0]['Count(id)']) {
			return "Username is taken.";
		}

		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		$register_statment = self::$db -> prepare("INSERT INTO users (username, password) VALUES (?,?)");
		$register_statment -> bind_param("ss", $username, $password_hash);
		$register_statment -> execute();
		return $register_statment -> affected_rows > 0;
	}
	
	public function getCurrentUser($username) {
		$statement = self::$db -> prepare("SELECT * FROM users WHERE username = ?");
		$statement -> bind_param("s", $username);
		$statement -> execute();
		
		$statement->store_result();
		$fetch_result = $this->fetch($statement);
			
		return $fetch_result[0];
		/*
		$statement -> execute();
		return $statement -> get_result() -> fetch_assoc();*/
	}

}

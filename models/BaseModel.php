<?php
abstract class BaseModel {
	protected static $db;

	public function __construct() {
		if (self::$db == null) {
			self::$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (self::$db -> connect_errno) {
				die('Cannot connect to database');
			}
			self::$db -> set_charset("utf8");
		}
	}

	public function fetch($result) {
		$array = array();

		if ($result instanceof mysqli_stmt) {
			$result -> store_result();

			$variables = array();
			$data = array();
			$meta = $result -> result_metadata();

			while ($field = $meta -> fetch_field())
				$variables[] = &$data[$field -> name];
			// pass by reference

			call_user_func_array(array($result, 'bind_result'), $variables);

			$i = 0;
			while ($result -> fetch()) {
				$array[$i] = array();
				foreach ($data as $k => $v)
					$array[$i][$k] = $v;
				$i++;

				// don't know why, but when I tried $array[] = $data, I got the same one result in all rows
			}
		} elseif ($result instanceof mysqli_result) {
			while ($row = $result -> fetch_assoc())
				$array[] = $row;
		}

		return $array;
	}

}

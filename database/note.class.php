<?php

require_once 'model.class.php';

class Note extends Model {

	//private static db;
	private $id = null;
	private $_userId = 1;
	private $_mysqli = null;
	private $_table = 'notes';

	public $text;

	function __construct() {

		$args = func_get_args();

		if (isset($args[0])) $this->id = $args[0];

		// Iniliaze db object
		$db = DB::getInstance();
		$this->_mysqli = $db->getConnection();
		if ($this->_mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->_mysqli->connect_error);

	}


	// load note lists
	public function load() {

		$sql =  "
			SELECT * FROM 
				`". $this->_table . "`
			WHERE
				`user_id` = '" . mysql_real_escape_string(Auth::getUser()->id) . "'
			ORDER BY `created_date` DESC";

		return $this->_mysqli->query($sql);

	}

	public function delete() {

		if (!is_null($this->id)) { // Delete 

			$sql =  "DELETE FROM `". $this->_table . "` WHERE id = '" . $this->id. "'";

			$res = $this->_mysqli->query($sql);
			return $res;

		}

		return false;

	}


	public function save() {

		if (is_null($this->id)) { // Add new 

			$sql =  "INSERT INTO `". $this->_table . "` SET `text` = '" . mysql_real_escape_string($this->text) . "', `user_id` = '" . Auth::getUser()->id . "'";

		} else { // Edit selected one

			$sql =  "UPDATE 
							`". $this->_table . "` 
						SET `text` = '" .  mysql_real_escape_string($this->text) . "' 
					WHERE 
						`id` = " . $this->id . " AND
						`user_id` = '" . Auth::getUser()->id . "'";

		}

		$res = $this->_mysqli->query($sql);

		return array('status' => $res, 'mysql_insert_id' => (is_null($this->id)) ? $this->_mysqli->insert_id : null);

	}

	public function showList() {

		$res = $this->_mysqli->query("SELECT * FROM `". $this->_table . "` order by `id` DESC");

		if (!$res) echo "Failed to run query: (" . $this->_mysqli->errno . ") " . $this->_mysqli->error;

		return $res;

	}
	
}
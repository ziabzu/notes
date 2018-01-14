<?php

class Note
{

    private $id = null;
    private $mysqli = null;
    private $table = 'notes';

    public $text;

    public function __construct()
    {

        $args = func_get_args();

        if (isset($args[0])) {
            $this->id = $args[0];
        }

        // Iniliaze db object
        $db = DB::getInstance();
        $this->mysqli = $db->getConnection();
        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }
    }


    // load note lists
    public function load()
    {

        $sql =  "
			SELECT * FROM 
				`". $this->table . "`
			WHERE
				`user_id` = '" . mysql_real_escape_string(Auth::getUser()->id) . "'
			ORDER BY `created_date` DESC";

        return $this->mysqli->query($sql);
    }

    public function delete()
    {

        if (!is_null($this->id)) { // Delete
            $sql =  "DELETE FROM `". $this->table . "` WHERE id = '" . $this->id. "'";

            $res = $this->mysqli->query($sql);
            return $res;
        }

        return false;
    }


    public function save()
    {

        if (is_null($this->id)) { // Add new
            $sql =  "INSERT INTO `". $this->table . "` 
            	SET `text` = '" . mysql_real_escape_string($this->text) . "', 
            	`user_id` = '" . Auth::getUser()->id . "'";
        } else { // Edit selected one
            $sql =  "UPDATE 
							`". $this->table . "` 
						SET `text` = '" .  mysql_real_escape_string($this->text) . "' 
					WHERE 
						`id` = " . $this->id . " AND
						`user_id` = '" . Auth::getUser()->id . "'";
        }

        $res = $this->mysqli->query($sql);

        return array('status' => $res, 'mysql_insert_id' => (is_null($this->id)) ? $this->mysqli->insert_id : null);
    }

    public function showList()
    {

        $res = $this->mysqli->query("SELECT * FROM `". $this->table . "` order by `id` DESC");

        if (!$res) {
            echo "Failed to run query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $res;
    }
}

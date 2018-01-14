<?php

// Must be singleton class

class User {

	private $_id = null;
	private $_email = null;
	private $_password= null;

	private $_user = null;
	private $_mysqli = null;
	private $_error = null;

	private $_table = 'users';

	public $text;

	function __construct($email, $password) {

		$this->_email = $email;
       	$this->_password = $password;

		// Iniliaze db object
		$db = DB::getInstance();
		$this->_mysqli = $db->getConnection();

	}

	public function login()
    {

        $user = $this->authenticate();

        if ($user) {

            $this->_user = $user;
            $_SESSION['user'] = serialize($user);
            
            return $user->id;

        }

        return false;

    }

    protected function authenticate()
    {

    	$sql = "SELECT * FROM `users` WHERE email = '" . mysql_real_escape_string($this->_email) . "' limit 1";

		$res = $this->_mysqli->query($sql);

        if ($res->num_rows > 0) {

            $user = $res->fetch_object();
            /*$submitted_pass = sha1($user['salt'] . $this->_password);
            if ($submitted_pass == $user['password']) {
                return $user;
            }*/

            //$submitted_pass = sha1($user['salt'] . $this->_password);
            if ($this->_password == $user->password) return $user;

             $this->_error = "Password does not match";

        } else {

        	$this->_error = "Email is not registered";

        }

        return false;

    }

    public function getError() {

    	return $this->_error;

    }


    public function getUser()
    {
        return $this->_user;
    }


	private function exists($email) {

		$sql = "SELECT * FROM `users` WHERE email = '" . mysql_real_escape_string($email) . "' limit 1";

		$res = $this->_mysqli->query($sql);

		//var_dump($res->num_rows);

		return $res->num_rows;

	}

	public function register($email, $password)
	{

		if ($this->exists($email)) {

			$this->_error = "Email already exists";
			return array('status' => false, 'mysql_insert_id' => null);

		}

		// Salt not implemented yet.
		//list($hashed, $salt) = $this->encryptPassword($password);

		$salt = '';
		//if ($this->_mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->_mysqli->connect_error);

		$sql =  "INSERT INTO `users`
			SET `email` = '" . mysql_real_escape_string($email) . "', `password` = '" . $password . "'"
				. ", salt='" . $salt . "'";

		$res = $this->_mysqli->query($sql);

		if ($res) { // if registered succesfully

			$this->_id = $this->_mysqli->insert_id;
			$this->_email = $email;


			$sql =  "SELECT * FROM `users`
				WHERE `email` = '" . mysql_real_escape_string($email) . "'";


			$res = $this->_mysqli->query($sql);

			$this->_user = $res->fetch_object();

			$_SESSION['user'] = serialize($this->_user);

		}

		return array('status' => $res, 'mysql_insert_id' => (is_null($this->_id)) ? $this->_mysqli->insert_id : null);

	}

	private function encryptPassword($password) {

		$salt = mt_rand(5, 10);
		$salted = $salt . $password;
		return array(hash('sha512', $salted), $salt);

	}

	private function validatePassword($password, $salt) {

		$salt = mt_rand(5, 10);
		$salted = $salt . $password;
		return array(hash('sha512', $salted), $salt);

	}

	public function saveSession()
	{

		$_SESSION['user'] = serialize($this);

	}

	public function delete() {

		if ($this->_mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->_mysqli->connect_error);

		if (!is_null($this->_id)) { // Delete 

			$sql =  "DELETE FROM `notes` WHERE id = '" . $this->_id. "'";

			$res = $this->_mysqli->query($sql);
			return $res;

		}

		return false;

	}


	private function setObject() {

	}


	public function save() {

		if ($this->_mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->_mysqli->connect_error);

		if (is_null($this->_id)) { // Add new 

			$sql =  "INSERT INTO `notes` SET `text` = '" . $this->text . "', `user_id` = " . $this->_id;

		} else { // Edit selected one

			$sql =  "UPDATE `notes` SET `text` = '" .  $this->text . "' WHERE id = "  . $this->_id;

		}

		$res = $this->_mysqli->query($sql);

		return array('status' => $res, 'mysql_insert_id' => (is_null($this->_id)) ? $this->_mysqli->insert_id : null);

	}

	public function logOut() {

		if ($this->_mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->_mysqli->connect_error);

		$res = $this->_mysqli->query("SELECT * FROM `notes` order by `id` DESC");

		if (!$res) echo "Failed to run query: (" . $this->_mysqli->errno . ") " . $this->_mysqli->error;

		return $res;

	}
	
}
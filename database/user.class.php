<?php

// Must be singleton class

class User
{

    private $id = null;
    private $email = null;
    private $password= null;

    private $user = null;
    private $mysqli = null;
    private $error = null;

    private $table = 'users';

    public $text;

    public function __construct($email, $password)
    {

        $this->email = $email;
        $this->password = $password;

        // Iniliaze db object
        $db = DB::getInstance();
        $this->mysqli = $db->getConnection();
    }

    public function login()
    {

        $user = $this->authenticate();

        if ($user) {
            $this->user = $user;
            $_SESSION['user'] = serialize($user);
            
            return $user->id;
        }

        return false;
    }

    protected function authenticate()
    {

        $sql = "SELECT * FROM `users` WHERE email = '" . mysql_real_escape_string($this->email) . "' limit 1";

        $res = $this->mysqli->query($sql);

        if ($res->num_rows > 0) {
            $user = $res->fetch_object();
            /*$submitted_pass = sha1($user['salt'] . $this->password);
            if ($submitted_pass == $user['password']) {
                return $user;
            }*/

            //$submitted_pass = sha1($user['salt'] . $this->password);
            if ($this->password == $user->password) {
                return $user;
            }

             $this->error = "Password does not match";
        } else {
            $this->error = "Email is not registered";
        }

        return false;
    }

    public function getError()
    {

        return $this->error;
    }


    public function getUser()
    {
        return $this->user;
    }


    private function exists($email)
    {

        $sql = "SELECT * FROM `users` WHERE email = '" . mysql_real_escape_string($email) . "' limit 1";

        $res = $this->mysqli->query($sql);

        //var_dump($res->num_rows);

        return $res->num_rows;
    }

    public function register($email, $password)
    {

        if ($this->exists($email)) {
            $this->error = "Email already exists";
            return array('status' => false, 'mysql_insert_id' => null);
        }

        // Salt not implemented yet.
        //list($hashed, $salt) = $this->encryptPassword($password);

        $salt = '';
        //if ($this->mysqli->connect_errno) die("Failed to connect to MySQL: " . $this->mysqli->connect_error);

        $sql =  "INSERT INTO `users`
			SET `email` = '" . mysql_real_escape_string($email) . "', `password` = '" . $password . "'"
                . ", salt='" . $salt . "'";

        $res = $this->mysqli->query($sql);

        if ($res) { // if registered succesfully
            $this->id = $this->mysqli->insert_id;
            $this->email = $email;


            $sql =  "SELECT * FROM `users`
				WHERE `email` = '" . mysql_real_escape_string($email) . "'";


            $res = $this->mysqli->query($sql);

            $this->user = $res->fetch_object();

            $_SESSION['user'] = serialize($this->user);
        }

        return array('status' => $res, 'mysql_insert_id' => (is_null($this->id)) ? $this->mysqli->insert_id : null);
    }

    private function encryptPassword($password)
    {

        $salt = mt_rand(5, 10);
        $salted = $salt . $password;
        return array(hash('sha512', $salted), $salt);
    }

    private function validatePassword($password, $salt)
    {

        $salt = mt_rand(5, 10);
        $salted = $salt . $password;
        return array(hash('sha512', $salted), $salt);
    }

    public function saveSession()
    {

        $_SESSION['user'] = serialize($this);
    }

    public function delete()
    {

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }

        if (!is_null($this->id)) { // Delete
            $sql =  "DELETE FROM `notes` WHERE id = '" . $this->id. "'";

            $res = $this->mysqli->query($sql);
            return $res;
        }

        return false;
    }


    public function save()
    {

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }

        if (is_null($this->id)) { // Add new
            $sql =  "INSERT INTO `notes` SET `text` = '" . $this->text . "', `user_id` = " . $this->id;
        } else { // Edit selected one
            $sql =  "UPDATE `notes` SET `text` = '" .  $this->text . "' WHERE id = "  . $this->id;
        }

        $res = $this->mysqli->query($sql);

        return array('status' => $res, 'mysql_insert_id' => (is_null($this->id)) ? $this->mysqli->insert_id : null);
    }

    public function logOut()
    {

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }

        $res = $this->mysqli->query("SELECT * FROM `notes` order by `id` DESC");

        if (!$res) {
            echo "Failed to run query: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
        }

        return $res;
    }
}

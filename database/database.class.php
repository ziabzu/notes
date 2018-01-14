<?php

/**
* MySql database class  u
* Used singelton design pattern
*/
class DB
{

    private $connection;
    private static $instance; //The single instance

    private $host = "localhost";
    private $username = "root";
    private $password = "samsol123";
    private $database = "notes";

    /*
    * Get an instance of the Database class
    * to make sure single instance always
    * @return Instance
    */
    public static function getInstance()
    {

        return (!self::$instance)
            ? self::$instance = new self()
            : self::$instance;
    }

    // Contructor made private so no one can instatniate object directly
    private function __construct()
    {

        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(), E_USER_ERROR);
        }
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->connection;
    }

    // To prevent making clone of this class
    // object so overrite magic method clone
    private function __clone()
    {
    }
}

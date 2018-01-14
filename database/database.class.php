<?php

/**
* MySql database class  u
* Used singelton design pattern
*/
class DB {

    private $_connection;
    private static $_instance; //The single instance

    private $_host = "localhost";
    private $_username = "root";
    private $_password = "samsol123";
    private $_database = "notes";

    /*
    * Get an instance of the Database class
    * to make sure single instance always
    * @return Instance
    */
    public static function getInstance() {

        return (!self::$_instance) ? self::$_instance = new self() : self::$_instance;

    }

    // Contructor made private so no one can instatniate object directly
    private function __construct() {

        $this->_connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

        if (mysqli_connect_error()) {

            trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(), E_USER_ERROR);

        }

    }

    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

    // To prevent making clone of this class object so overrite magic method clone
    private function __clone() { }

}
 

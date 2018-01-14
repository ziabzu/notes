<?php

// A static class just used as authentication related to session

class Auth {

	private static $_user = null;

    public static function getUser() {

    	if (is_null(self::$_user)) self::$_user = unserialize($_SESSION['user']);

    	return self::$_user;
    	
    }

    public static function isLoggedIn() {

    	return isset($_SESSION['user']) ? true : false;

    }
	
}
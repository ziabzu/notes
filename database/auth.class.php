<?php

// A static class just used as authentication related to session

class Auth
{

    private static $user = null;

    public static function getUser()
    {

        if (is_null(self::$user)) {
            self::$user = unserialize($_SESSION['user']);
        }

        return self::$user;
    }

    public static function isLoggedIn()
    {

        return isset($_SESSION['user']) ? true : false;
    }
}

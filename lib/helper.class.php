<?php

class Helper {


	/**
	* return current page name e.g register.php etc
	*/
	public static function getPageName() {

		return basename($_SERVER['PHP_SELF']);
		
	} 

	public static function getBaseUrl() {

		// Taken from stackoverlfow https://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php

		if (isset($_SERVER['HTTPS'])) {

        	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";

	    } else {

	        $protocol = 'http';

	    }

	    $requestUri = explode("/", $_SERVER['REQUEST_URI']);

	    return $protocol . "://" . $_SERVER['HTTP_HOST'] . "/" . $requestUri[1] . "/";

	}

	/*
	* timeToString 
	* Changed datetime object to now and then format Copied my cutom old funciton
	*/
	public static function timeToString ($datetime, $full = false) {

        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $k => &$v) {

            if ($diff->$k) {

                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');

            } else {

                unset($string[$k]);

            }

        }

        if (!$full) $string = array_slice($string, 0, 1);

        return $string ? implode(', ', $string) . ' ago' : 'just now';

    }

}
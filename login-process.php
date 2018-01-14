<?php
    session_start();

    require_once 'database/database.class.php';
    require_once 'database/auth.class.php';
    require_once 'database/user.class.php';

	$email = $_POST['email'];
	$password = $_POST['pass'];

	$user = new User($email, $password);
	$user_id = $user->login(); // Register means login automatically

	if (!$user_id) {

		header("Location: login.php?message=" . $user->getError());
		die();

	}

	header("Location: index.php");
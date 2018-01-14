<?php
    session_start();

    require_once 'database/database.class.php';
    require_once 'database/auth.class.php';
    require_once 'database/user.class.php';

	$email = $_POST['email'];
	$password = $_POST['pass'];

	$user = new User($email, $password);

	$res = $user->register($email, $password); // Register means login automatically if successfull


	if (!$res['status']) {

		header("Location: login.php?message=" . $user->getError());
		die();

	}

	header("Location: index.php?message=You are registered scuccessfully");
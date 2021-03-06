<?php

    session_start();
    error_reporting(E_ALL & ~E_NOTICE);

    require_once 'database/database.class.php';
    require_once 'database/auth.class.php';
    require_once 'database/user.class.php';
    require_once 'database/note.class.php';

    require_once 'lib/helper.class.php';

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Note Storage</title>

        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" 
        crossorigin="anonymous"></script>

        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
        crossorigin="anonymous"></script>
    -->


        <link href="css/global.css" rel="stylesheet">

        <script src="js/note.js"></script>
        

        <!-- Styles -->
        <style>
            .card {
                margin: 5px;
            }

            .pagination a.active {
                background-color: #4CAF50;
                color: white;
            }

            .pagination a:hover:not(.active) {background-color: #ddd;}

        </style>
    </head>
    <body>
    
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo Helper::getBaseUrl() ?>">Notes Hub</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?php echo (Helper::getPageName() == 'index.php' ? 'active' : '') ?>">
                <a href="<?php echo Helper::getBaseUrl() ?>">Home</a>
            </li>
        </ul>

        <ul class="nav navbar-nav  navbar-right">
            <?php if (Auth::isLoggedIn()) { ?>
                <li><a href="logout.php">Log Out</a></li>
            <?php } else { ?>
                <li class='<?php echo (Helper::getPageName() == 'login.php' ? 'active' : '') ?>"'>
                    <a href="<?php echo Helper::getBaseUrl() ?>login.php">Login</a></li>
                <li class='<?php echo (Helper::getPageName() == 'resgister.php' ? 'active' : '') ?>"'>
                    <a href="<?php echo Helper::getBaseUrl() ?>register.php">Register</a></li>
            <?php } ?>
        </ul>

        <input type='hidden' id='user-loggedin' value='<?php echo (Auth::isLoggedIn() ? 1 : 0); ?>' />

      </div>
    </nav>


    <div class='container'>
        <div class="">
           
            <div class="content">
                <div class="well-">

<?php if (isset($_GET['message'])) { ?>
    <div class="alert alert-info">
        <?php echo $_GET['message']; ?>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>

<?php }

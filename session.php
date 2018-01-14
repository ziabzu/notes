<?php


/*session is started if you don't write this line can't use $_Session  global variable*/
if (isset($_GET['userId'])) {
     $_SESSION["userId"] = $_GET['userId'];
}

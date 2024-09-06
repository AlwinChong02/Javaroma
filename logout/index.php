<?php
session_start();

$_SESSION = array();

session_destroy();

setcookie("PHPSESSID", "", time() - 3600, "/");
setcookie("userID", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");
setcookie("password", "", time() - 3600, "/");


header("Location: ../index.php");
exit;
?>
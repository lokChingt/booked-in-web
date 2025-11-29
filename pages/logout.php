<?php 
include "includes/header.php";

// clear session userid & username
unset($_SESSION['userid']);
unset($_SESSION['username']);

// edit messages
$error = "You have logged out";
$message = "";

include "includes/show_message.php";

// hold for 0.5 seconds then redirect to home page
header('Refresh: 0.5; URL = index.php');
exit();
?>
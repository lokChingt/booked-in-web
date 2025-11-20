<?php 
include "includes/header.php";

unset($_SESSION['userid']);
unset($_SESSION['username']);

$error = "You have logged out";
$message = "";

include "includes/show_message.php";

header('Refresh: 0.5; URL = index.php');
exit();
?>
<?php 
session_start();
unset($_SESSION['userid']);
unset($_SESSION['username']);
include "includes/header.php";
$error = "You have logged out";
include "includes/show_message.php";
header('Refresh: 0.5; URL = ../pages/index.php');
exit();
?>
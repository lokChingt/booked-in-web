<?php 
session_start();
unset($_SESSION['username']);
include "includes/header.php";
$message = "You have logged out";
include "includes/show_message.php";
header('Refresh: 1; URL = ../pages/index.php');
exit();
?>
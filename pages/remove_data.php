<?php 
session_start();
include "includes/db_connect.php";
include "includes/header.php";
include "includes/show_message.php";

// delete from db
$col = $_GET["data"];
$userid = $_SESSION["userid"];
$sql = "UPDATE Users SET $col = NULL WHERE UserID = '$userid'";
$result = $conn -> query($sql);
if($result) {
    $message = "Removed successfully";
} else {
    $error = "Error: " . $conn -> error;
}

$conn -> close();

// redirect to previous page
header("Location: profile.php");
exit();

include "includes/footer.php";
?>
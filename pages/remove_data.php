<?php
include "includes/header.php";
include "includes/show_message.php";

// get column name & userid
$col = $_GET["data"];
$userid = $_SESSION["userid"];

// delete data from db
$sql = "UPDATE Users SET $col = NULL WHERE UserID = '$userid'";
$result = $conn -> query($sql);

// check if successful
if($result) {
    $message = "Removed successfully";
} else {
    $error = "Error: " . $conn -> error;
}

$conn -> close();

// redirect to profile page
header("Location: profile.php");
exit();

include "includes/footer.php";
?>
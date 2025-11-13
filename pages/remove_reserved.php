<?php 
session_start();
include "includes/db_connect.php";
include "includes/header.php";
include "includes/show_message.php";

// delete from db
$isbn = $_GET["isbn"];
$username = $_SESSION["username"];
$sql = "DELETE FROM Reservations WHERE ISBN = '$isbn' and Username = '$username'";
$result = $conn -> query($sql);
if($result) {
    $message = "Removed successfully";
} else {
    $error = "Error: " . $conn -> error;
}

// redirect to previous page
header("Location: view_reserved.php");
?>

<?php
include "includes/footer.php";
?>
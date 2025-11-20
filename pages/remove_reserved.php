<?php 
include "includes/header.php";
include "includes/show_message.php";

// delete from db
$isbn = $_GET["isbn"];
$userid = $_SESSION["userid"];
$sql = "DELETE FROM Reservations WHERE ISBN = '$isbn' and UserID = '$userid'";
$result = $conn -> query($sql);
if($result) {
    $message = "Removed successfully";
} else {
    $error = "Error: " . $conn -> error;
}

$conn -> close();

// redirect to previous page
header("Location: view_reserved.php");
exit();

include "includes/footer.php";
?>
<?php 
session_start();
include "includes/db_connect.php";
include "includes/header.php";
include "includes/show_message.php";

if(!$_SESSION['username']) {
    // redirect to login page if not logged in
    $_SESSION['error'] = "Please login to view your profile";
    header("Location: login.php");
    exit();
}
?>

<h1>User Profile</h1>

<?php
$username = $_SESSION['username'];
$sql = "SELECT * FROM Users WHERE Username = '$username'";
$result = $conn -> query($sql);
if($result) {
    echo "<table>";
    while($row = $result -> fetch_assoc()) {
        foreach ($row as $column => $value) {
            echo "<tr><td>$column: </td><td>$value</td>";
            echo "<td><a href='edit.php?data=$column'>Edit</a></td></tr>";
        }
    }
    echo "</table>";
}



$conn -> close();

include "includes/footer.php";
?>
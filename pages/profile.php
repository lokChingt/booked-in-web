<?php 
include "includes/header.php";
include "includes/show_message.php";

if(!$_SESSION['userid']) {
    // redirect to login page if not logged in
    $_SESSION['error'] = "Please login to view your profile";
    header("Location: login.php");
    exit();
}
?>

<h1>User Profile</h1>

<?php
$required_col = ['FirstName', 'Surname', 'Username', 'Password', 'City'];
$userid = $_SESSION['userid'];
$sql = "SELECT * FROM Users WHERE UserID = '$userid'";
$result = $conn -> query($sql);
if($result) {
    echo "<table>";
    while($row = $result -> fetch_assoc()) {
        foreach ($row as $column => $value) {
            if($column !== 'UserID') {
                echo "<tr><td>$column: </td>";
                if ($column == 'Password') {
                    echo "<td>*****</td>";
                } else {
                    echo "<td>$value</td>";
                }
                if($value == '') {
                    $var = "Add";
                } else {
                    $var = "Edit";
                }
                echo "<td><a href='edit.php?data=$column'>$var</a></td>";
                if(!in_array($column, $required_col)) {
                    echo "<td><a href='remove_data.php?data=$column'>Remove</a></td></tr>";
                }
            }
        }
    }
    echo "</table>";
}



$conn -> close();

include "includes/footer.php";
?>
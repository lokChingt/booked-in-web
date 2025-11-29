<?php 
include "includes/header.php";
include "includes/show_message.php";

// check if logged in
if(!$_SESSION['userid']) {
    $_SESSION['error'] = "Please login to view your profile";

    // redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
?>

<!-- display user profile -->
<div class="display">
<h2>User Profile</h2>

<?php
// userid
$userid = $_SESSION['userid'];

// assign required columns
$required_col = ['FirstName', 'Surname', 'Username', 'Password', 'City'];

// get user info
$sql = "SELECT * FROM Users WHERE UserID = '$userid'";
$result = $conn -> query($sql);

if($result) {
    echo "<table>";
    // iterate over user data
    while($row = $result -> fetch_assoc()) {
        foreach ($row as $column => $value) {
            // skip displaying userid
            if($column !== 'UserID') {
                echo "<tr><td>$column: </td>";

                // check if password
                if ($column == 'Password') {
                    echo "<td>*****</td>"; // password placeholder
                } else {
                    echo "<td>$value</td>";
                }

                // check if blank data
                if($value == '') {
                    $var = "Add";
                } else {
                    $var = "Edit";
                }
                echo "<td><a href='edit_data.php?data=$column'>$var</a></td>";

                // check if column required
                if(!in_array($column, $required_col)) {
                    echo "<td><a href='remove_data.php?data=$column'>Remove</a></td></tr>";
                } else {
                    echo "<td>Required</td>";
                }
            }
        }
    }
    echo "</table>";
}
echo '</div>';


$conn -> close();

include "includes/footer.php";
?>
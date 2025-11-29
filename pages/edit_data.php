<?php 
include "includes/header.php";
include "includes/show_message.php";

$col = $_GET['data'];
$userid = $_SESSION['userid'];

// get old data
$sql = "SELECT $col FROM Users WHERE UserID = '$userid'";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();
if($col !== 'Password') {
    $old_data = $row[$col];
}

// check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // update date
    $new_data = $_POST['new_data'];
    $sql = "UPDATE Users SET $col = ? WHERE UserID = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("ss", $new_data, $userid);

    if($stmt -> execute()) {
        if($col == 'Username') {
            // update session username
            $_SESSION['username'] = $new_data;
        }
        // redirect to profile page
        header("Location: profile.php");
        exit();
    } else {
        $error = "Failed to update " . $col;
    }
    $stmt -> close();
}

$conn -> close();
?>

<!-- display edit form -->
<h2>Edit User Data</h2>
<form method="POST">
    <table>
        <tr>
            <td><label for="new_data"> <?php echo $col?>:</label></td>
            <td><input type="<?php if($col == 'Password') {echo 'password';} else {echo 'text';} ?>" 
                id="new_data" name="new_data" placeholder="<?php echo $old_data;?>"required></td>
            <td><input type="submit" value="Update"></td>
        </tr>
    </table>
</form>


<?php
include "includes/footer.php";
?>
<?php 
session_start();
include "includes/db_connect.php";
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

// update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_data = $_POST['new_data'];
    $sql = "UPDATE Users SET $col = ? WHERE UserID = ?";
    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("ss", $new_data, $userid);
    if($stmt -> execute()) {
        if($col == 'Username') {
            $_SESSION['username'] = $new_data;
        }
        header("Location: profile.php");
        exit();
    } else {
        echo "failed";
    }
    $stmt -> close();
}

$conn -> close();
?>

<h1>Edit user data</h1>
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
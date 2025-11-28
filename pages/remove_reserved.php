<?php 
include "includes/header.php";
include "includes/show_message.php";

if(isset($_POST["delete"])) {
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
}

?>

<h2>Delete Confirmation</h2>
<form method="POST">
    <input type="submit" name="delete" value="Delete">
    <a href="view_reserved.php">Cancel</a>
</form>

<?php include "includes/footer.php"; ?>
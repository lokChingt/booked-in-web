<?php 
include "includes/header.php";
include "includes/show_message.php";

// check if remove button clicked
if(isset($_POST['remove'])) {
    // get isbn & userid
    $isbn = $_GET["isbn"];
    $userid = $_SESSION["userid"];

    // remove reservation from db
    $sql = "DELETE FROM Reservations WHERE ISBN = '$isbn' and UserID = '$userid'";
    $result = $conn -> query($sql);

    // check if successful
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

<!-- display remove confirmation -->
<h2>Remove Confirmation</h2>
<form method="POST">
    <input type="submit" name="remove" value="Remove">
    <a href="view_reserved.php">Cancel</a>
</form>

<?php include "includes/footer.php"; ?>
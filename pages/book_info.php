<?php 
include "includes/header.php";

// no isbn
if (!isset($_GET['isbn']) || $_GET['isbn'] == '') {
    $error = "No ISBN received";
    header("Location: index.php");
    exit();
}

// get book info from db
$sql = "SELECT * FROM Books JOIN Categories USING(CategoryID) WHERE ISBN = ?";
$stmt = $conn -> prepare($sql);
$stmt -> bind_param("s", $_GET['isbn']);
$stmt -> execute();
$result = $stmt -> get_result();


// display book info
echo '<div class="display">';
echo "<h2>Book Info</h2>";
while ($row = $result -> fetch_assoc()) {
    // book cover
    echo "<img src='../images/template.png' alt='template' width=300>";
    // book info
    echo "<table>";
        echo "<tr><td>Title: </td><td>";
        echo $row['BookTitle'] . " [Edition " . $row['Edition'] . "]<br></td></tr>";
        echo "<tr><td>Author: </td><td>";
        echo $row['Author'] . "<br></td></tr>";
        echo "<tr><td>Year: </td><td>";
        echo $row['Year'] . "<br></td></tr>";
        echo "<tr><td>Category: </td><td>";
        echo $row['CategoryDetail'] . "<br></td></tr>";
    echo "</table>";
}

// check if reserved
$isbn = $_GET['isbn'];
$sql = "SELECT UserID FROM Reservations WHERE ISBN = '$isbn'";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();

$userid = $_SESSION['userid'];

// check if reserved
if($result -> num_rows > 0) {
    // check if reserved by user
    if($row['UserID'] == $userid) {
        $reserved = True;
    } else {
        // reserved by other user
        $reserved_other = True;
    }
} else {
    // not reserved
    $reserved = False;
}
?>

<!-- reserve button -->
<form method='POST'>
    <button type="submit" name="reserve" <?php if($reserved === True || $reserved_other == True){ echo 'disabled'; }?> >Reserve</button>
    <!-- show reservde message -->
    <?php if($reserved === True){ echo 'Reserved'; }?>
    <?php if($reserved_other === True){ echo 'Reserved by others'; }?>
</form>
</div>

<?php
// check if reserve button is clicked
if(isset($_POST['reserve'])) {
    // check if logged in
    if(!$_SESSION['userid']) {
        // redirect to login page if not logged in
        $_SESSION['error'] = "Please login to reserve books";
        header("Location: login.php");
        exit();
    } else {
        // logged in
        $userid = $_SESSION['userid'];
        $isbn = $_GET['isbn'];
        $date = date("Y-m-d");

        // add reservation to db
        $stmt = $conn -> prepare("INSERT INTO Reservations (ISBN, UserID, ReservedDate) VALUES (?, ?, ?)");
        $stmt -> bind_param("sss", $isbn, $userid, $date);

        if($stmt -> execute()) {
            $message = "Reserved successfully";
        } else {
            $error = "Error" . $stmt -> error;
        }

        $stmt -> close();
    }
    
}

$conn -> close();

include "includes/show_message.php";
include "includes/footer.php";
?>
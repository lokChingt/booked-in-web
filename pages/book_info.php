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


// display
echo '<div class="display">';
echo "<h2>Book Info</h2>";
while ($row = $result -> fetch_assoc()) {
    echo "<img src='../images/template.png' alt='template' width=300>";
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
if($result -> num_rows > 0) {
    if($row['UserID'] == $userid) {
        $reserved = True;
    } else {
        $reserved_other = True;
    }
} else {
    $reserved = False;
}
?>
<form method='POST'>
    <button type="submit" name="reserve" <?php if($reserved === True || $reserved_other == True){ echo 'disabled'; }?> >Reserve</button>
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
        $userid = $_SESSION['userid'];
        $isbn = $_GET['isbn'];
        $date = date("Y-m-d");

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
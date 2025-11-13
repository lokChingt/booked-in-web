<?php 
session_start();
include "includes/db_connect.php";

// check if logged in 
if(!($username = $_SESSION['username'])) {
    // redirect to login page if not logged in
    $_SESSION['error'] = "Please login to view reserved books";
    header("Location: login.php");
    exit();
} else {
    $message = "Logged in as " . $username;
}

include "includes/header.php";
include "includes/show_message.php";
echo "<h1>View reserved books</h1>";

// get book info from db
$sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail, ReservedDate 
        FROM Reservations
        JOIN Books USING(ISBN) 
        JOIN Categories USING(CategoryID)
        WHERE Username = '$username'";
$result = $conn -> query($sql);

if($result -> num_rows > 0) {
    echo "<table>";
    // Display headers
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Author</th>";
    echo "<th>Year</th>";
    echo "<th>Category</th>";
    echo "<th>Reserved Date</th>";
    echo "<th>Action</th>";
    echo "</tr><br>";

    // loop over the rows
    while($row = $result -> fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['BookTitle']} [Edition {$row['Edition']}]</td>";
        echo "<td>{$row['Author']}</td>";
        echo "<td>{$row['Year']}</td>";
        echo "<td>{$row['CategoryDetail']}</td>";
        echo "<td>{$row['ReservedDate']}</td>";
        echo "<td><a href='remove_reserved.php?isbn={$row['ISBN']}'>Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "*** No reserved books ***";
}

$conn -> close();

include "includes/footer.php";
?>
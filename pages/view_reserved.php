<?php 
include "includes/header.php";

// check if logged in 
if(!($userid = $_SESSION['userid'])) {
    // redirect to login page if not logged in
    $_SESSION['error'] = "Please login to view reserved books";
    header("Location: login.php");
    exit();
} else {
    $message = "Logged in as " . $_SESSION['username'];
}

echo '<div class="display">';
include "includes/show_message.php";
echo "<h2>View Reserved Books</h2>";

// get book info from db
$sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail, ReservedDate 
        FROM Reservations
        JOIN Books USING(ISBN) 
        JOIN Categories USING(CategoryID)
        WHERE UserID = '$userid'
        ORDER BY ReservedDate DESC";
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
    echo "</tr>";

    // loop over the rows
    while($row = $result -> fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['BookTitle']} [Edition {$row['Edition']}]</td>";
        foreach ($row as $column => $value) {
            if($column == 'ISBN' || $column == 'BookTitle' || $column == 'Edition') {
                continue;
            }
            echo "<td>$value</td>";
        }
        echo "<td><a href='remove_reserved.php?isbn={$row['ISBN']}'>Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "*** No reserved books ***";
}
echo '</div>';

$conn -> close();

include "includes/footer.php";
?>
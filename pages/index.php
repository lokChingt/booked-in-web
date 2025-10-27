<?php 
include "includes/header.php";
include "includes/db_connect.php";

$sql = "SELECT ISBN, BookTitle, Author, Edition, Year, CategoryDetail, 
            if(ReservedDate is null, 'Available', 'Booked') AS Status
        FROM Books 
        JOIN Categories USING(CategoryID)
        LEFT JOIN Reservations USING(ISBN)
        ORDER BY BookTitle";
$result = $conn->query($sql);
?>

<h1>This is the Home page</h1>

<p>All Books</p>
<table>
    <tr>
        <th>ISBN</th>
        <th>Book Title</th>
        <th>Author</th>
        <th>Edition</th>
        <th>Year</th>
        <th>Category</th>
        <th>Status</th>
    </tr>
    <?php 
        // Show all books
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>" . $row['ISBN'] . "</td>";
                    echo "<td>" . $row['BookTitle'] . "</td>";
                    echo "<td>" . $row['Author'] . "</td>";
                    echo "<td>" . $row['Edition'] . "</td>";
                    echo "<td>" . $row['Year'] . "</td>";
                    echo "<td>" . $row['CategoryDetail'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }
        }
        $conn->close();
    ?>
</table>


<?php include "includes/footer.php";?>
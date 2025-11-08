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

<h2>All Books</h2>
<?php 
    // show all books with BookTitle, Edition and Author
    while ($row = $result -> fetch_assoc()) {
        echo "<div class='book'>";
        echo '<img src="../images/template.png" alt="Book Template" height="200">' . '<br>';
        echo "<a href='book_info.php?isbn={$row['ISBN']}'> {$row['BookTitle']} [Edition {$row['Edition']}] </a> <br>";
        echo "{$row['Author']}</p>";
        echo "</div>";
    }
    $conn->close();
?>


<?php include "includes/footer.php";?>
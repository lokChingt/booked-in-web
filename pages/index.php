<?php
include "includes/header.php";
include "includes/show_message.php";

// get book info from db
$sql = "SELECT * FROM Books ORDER BY BookTitle";
$result = $conn -> query($sql);

?>
<div class='display'>
<h2>All Books</h2>
<div class="book_grid">
<?php 
    // show all books with BookTitle, Edition and Author
    while ($row = $result -> fetch_assoc()) {
        echo "<div class='book'>";
        echo '<img src="../images/template.png" alt="Book Template" height="200"><br>';
        echo "<a href='book_info.php?isbn={$row['ISBN']}'> {$row['BookTitle']}<br>[Edition {$row['Edition']}]</a><br>";
        echo "{$row['Author']}</p>";
        echo "</div>";
    }
    $conn->close();
?>
</div>
</div>

<?php include "includes/footer.php";?>
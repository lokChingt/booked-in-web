<?php 
include "includes/header.php";
include "includes/show_message.php";

echo "<h2>Search Results</h2>";

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $search_by = isset($_GET['search_by']) ? $_GET['search_by'] : array();
    $search_word = $_GET['search'];
    $search_category = $_GET['category'];

    $by_title = in_array('by_title', $search_by);
    $by_author = in_array('by_author', $search_by);

    if($search_word) {
        if($by_title && $by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and (BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%')";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%'";
            }
        } elseif($by_title) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and BookTitle LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                    WHERE BookTitle LIKE '%$search_word%'";
            }
        } elseif($by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and Author LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                    WHERE Author LIKE '%$search_word%'";
            }
        } else { # only search word
            $_SESSION['error'] = "Search by and Search word must use together";
            header("Location: index.php");
            exit();
        }
    } else { # no search word
        if($search_category) {
            $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                    WHERE CategoryDetail = '$search_category'";
        } else {
            $_SESSION['error'] = "Please enter Search word or choose a Category";
            header("Location: index.php");
            exit();
        }
    }
    
    $result = $conn -> query($sql);
    $book_num = $result -> num_rows;
    if($book_num > 0) {
        echo "<table>";
        // Display headers
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Year</th>";
        echo "<th>Category</th>";
        echo "</tr>";
    
        // loop over the rows
        while($row = $result -> fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='book_info.php?isbn={$row['ISBN']}'> {$row['BookTitle']} [Edition {$row['Edition']}]</a><td>";
            foreach ($row as $column => $value) {
                if($column == 'ISBN' || $column == 'BookTitle' || $column == 'Edition') {
                    continue;
                }
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        
    } else {
        echo "*** No books found ***";
    }
}
echo '<br>Number of books: ' . $book_num;
include "includes/footer.php";
?>
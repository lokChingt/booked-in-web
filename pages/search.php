<?php 
include "includes/header.php";
include "includes/show_message.php";

if (!isset ($_GET['page']) ) {
    $_SESSION['params'] = $_GET;
    $_SESSION['params']['page'] = 1;

    $_SESSION['url'] = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    header("Location: " . $_SESSION['url']);
    exit;
} else {
    $page = $_GET['page'];
} 


if($_SERVER["REQUEST_METHOD"] == "GET") {
    $search_by = isset($_GET['search_by']) ? $_GET['search_by'] : array();
    $search_word = $_GET['search'];
    $search_category = $_GET['category'];

    $by_title = in_array('by_title', $search_by);
    $by_author = in_array('by_author', $search_by);

    $search_q = "";
    if ($by_title) {
        if($search_category)
            $separator = ',';
        $search_q = $search_q . " by Title";
    } 
    if ($by_author) {
        if($by_title)
        $search_q = $search_q . " & by Author";
    }
    if($search_category) {
        $search_q = $search_q . " in Category " . $search_category;
    } 

    $limit = 5;
    $start = ($page-1) * $limit;

    if($search_word) {
        if($by_title && $by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and (BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%')
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and (BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%')";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%'";
            }
        } elseif($by_title) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and BookTitle LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and BookTitle LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%'";
            }
        } elseif($by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and Author LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
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
                    WHERE CategoryDetail = '$search_category'
                    LIMIT $start, $limit";
            $sql2 = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                    WHERE CategoryDetail = '$search_category'";
        } else {
            $_SESSION['error'] = "Please enter Search word or choose a Category";
            header("Location: index.php");
            exit();
        }
    }
    
    echo "<h2>Result for '$search_word' $search_q</h2>";

    $result = $conn -> query($sql);
    $result2 = $conn -> query($sql2);
    $total_rows = $result2 -> fetch_assoc();
    $book_num = $total_rows['Total'];
    $total_page = ceil($book_num/$limit);

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
            echo "<td><a href='book_info.php?isbn={$row['ISBN']}'> {$row['BookTitle']} [Edition {$row['Edition']}]</a></td>";
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
        echo "*** No books found for '$search_word' " . $search_q . " ***";
    }
}
echo '<div class="books_num">';
echo 'Number of books: ' . $book_num;
echo '</div>';

$_SESSION['params']['page'] = $page-1;
$last_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

$_SESSION['params']['page'] = $page+1;
$next_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

echo '<div class="pagination">';
echo '<ul>';
$disabledAttr = ($page == 1) ? 'class = "disabled"' : '';
echo "<li $disabledAttr><a href='$last_page'>" . '<' . "</a></li>";
for ($i = 1; $i <= $total_page; $i++) { 
    $_SESSION['params']['page'] = $i;
    $url = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    if($i == $page) {
        $page_link = "<li class='current_page'><a href='$url'>$i</a></li>";
    } else {
        $page_link = "<li><a href='$url'>$i</a></li>";
    }
    echo $page_link;
}
$disabledAttr2 = ($page == $total_page) ? 'class = "disabled"' : '';
echo "<li $disabledAttr2><a href='$next_page'>" . '>' . "</a></li>";
echo '</ul>';
echo '</div>';
include "includes/footer.php";
?>
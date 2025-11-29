<?php 
include "includes/header.php";
include "includes/show_message.php";

// check if get page number
if (!isset ($_GET['page']) ) {
    // get parameters
    $_SESSION['params'] = $_GET;
    // set the initial page as page 1
    $_SESSION['params']['page'] = 1;

    // update url with page number
    $_SESSION['url'] = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    // redirect to updated url
    header("Location: " . $_SESSION['url']);
    exit();
} else {
    // get page number from url
    $page = $_GET['page'];
}


// check if form submitted
if($_SERVER["REQUEST_METHOD"] == "GET") {
    // create an array to store search by
    $search_by = isset($_GET['search_by']) ? $_GET['search_by'] : array();
    $search_word = $_GET['search'];
    $search_category = $_GET['category'];

    // add by_title and/or by_author in search_by array
    $by_title = in_array('by_title', $search_by);
    $by_author = in_array('by_author', $search_by);

    // create string of the search query
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


    // set item limit per page to 5
    $limit = 5;
    // set the start index
    $start = ($page-1) * $limit;

    // check if search word entered
    if($search_word) {
        // check for any combinations of search by and search catagory
        if($by_title && $by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and (BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%')
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and (BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%')";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%' OR Author LIKE '%$search_word%'";
            }
        } elseif($by_title) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and BookTitle LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and BookTitle LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE BookTitle LIKE '%$search_word%'";
            }
        } elseif($by_author) {
            if($search_category) {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE CategoryDetail = '$search_category' and Author LIKE '%$search_word%'";
            } else {
                $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                        WHERE Author LIKE '%$search_word%'
                        LIMIT $start, $limit";
                $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                        WHERE Author LIKE '%$search_word%'";
            }
        } else { // only search word
            $_SESSION['error'] = "Search by and Search word must use together";

            // redirect to home page
            header("Location: index.php");
            exit();
        }
    } else { // no search word
        if($search_category) {
            $sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail FROM Books JOIN Categories USING(CategoryID) 
                    WHERE CategoryDetail = '$search_category'
                    LIMIT $start, $limit";
            $count_sql = "SELECT COUNT(*) AS Total FROM Books JOIN Categories USING(CategoryID) 
                    WHERE CategoryDetail = '$search_category'";
        } else { // no search word, no category selected
            $_SESSION['error'] = "Please enter Search word or choose a Category";

            // redirect to home page
            header("Location: index.php");
            exit();
        }
    }
    
    // display search result
    echo "<h2>Result for '$search_word' $search_q</h2>";

    // get result with limit of 5
    $result = $conn -> query($sql);

    // count total number of search results
    $count_result = $conn -> query($count_sql);
    $total_rows = $count_result -> fetch_assoc();
    $book_num = $total_rows['Total'];
    // calculate the total pages
    $total_page = ceil($book_num/$limit);

    // check if there is result
    if($book_num > 0) {
        echo "<table>";
        // display headers
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Year</th>";
        echo "<th>Category</th>";
        echo "</tr>";
    
        // loop over the result
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
        // no books
        echo "*** No books found for '$search_word' " . $search_q . " ***";
    }
}

// display the total number of search results
echo '<div class="books_num">';
echo 'Number of books: ' . $book_num;
echo '</div>';



// pagination
echo '<div class="pagination">';
echo '<ul>';

// create url for previous page
$_SESSION['params']['page'] = $page-1;
$last_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

// create url for next page
$_SESSION['params']['page'] = $page+1;
$next_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

// check if the current page is the first one, if yes disable
$disabledAttr = ($page == 1) ? 'class = "disabled"' : '';
echo "<li $disabledAttr><a href='$last_page'>" . '<' . "</a></li>";

// show all pages with url
for ($i = 1; $i <= $total_page; $i++) { 
    // create url for other pages
    $_SESSION['params']['page'] = $i;
    $url = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    // check if current page
    if($i == $page) {
        // add class on current page 
        $page_link = "<li class='current_page'><a href='$url'>$i</a></li>";
    } else {
        // other pages
        $page_link = "<li><a href='$url'>$i</a></li>";
    }

    echo $page_link;
}

// check if the current page is the last one, if yes disable
$disabledAttr2 = ($page == $total_page) ? 'class = "disabled"' : '';
echo "<li $disabledAttr2><a href='$next_page'>" . '>' . "</a></li>";

echo '</ul>';
echo '</div>';

include "includes/footer.php";
?>
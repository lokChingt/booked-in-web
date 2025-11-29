<?php
include "includes/header.php";

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

// set item limit per page to 5
$limit = 5;
// set the start index
$start = ($page-1) * $limit;

// get book info from db
$sql = "SELECT * FROM Books ORDER BY BookTitle LIMIT $start, $limit";
$result = $conn -> query($sql);

// count total books
$count_sql = "SELECT COUNT(*) AS Total FROM Books";
$count_result = $conn -> query($count_sql);
$total_rows = $count_result -> fetch_assoc();
$book_num = $total_rows['Total'];
// calculate the total pages
$total_page = ceil($book_num/$limit);

include "includes/show_message.php";
?>

<!-- display all books info -->
<div class='display'>
    <h2>All Books</h2>
    <div class="book_grid">
        <?php 
            // show BookTitle, Edition and Author
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

<?php
// create url for previous page
$_SESSION['params']['page'] = $page-1;
$last_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

// create url for next page
$_SESSION['params']['page'] = $page+1;
$next_page = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

// pagination
echo '<div class="pagination">';
echo '<ul>';
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

include "includes/footer.php";?>
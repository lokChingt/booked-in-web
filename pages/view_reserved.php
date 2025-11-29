<?php 
include "includes/header.php";

// check if logged in 
if(!($userid = $_SESSION['userid'])) {
    $_SESSION['error'] = "Please login to view reserved books";

    // redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// check if get page number
if (!isset ($_GET['page']) ) {
    // get parameters
    $_SESSION['params'] = $_GET;
    $_SESSION['params']['page'] = 1; // set the initial page as page 1

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

// count total reservations
$count_sql = "SELECT COUNT(*) AS Total FROM Reservations WHERE UserID = '$userid'";
$count_result = $conn -> query($count_sql);
$total_rows = $count_result -> fetch_assoc();
$reserve_num = $total_rows['Total'];
// calculate the total pages
$total_page = ceil($reserve_num/$limit);


include "includes/show_message.php";

// display reserved books
echo '<div class="display">';
echo "<h2>View Reserved Books</h2>";

// get book info from db
$sql = "SELECT ISBN, BookTitle, Edition, Author, Year, CategoryDetail, ReservedDate 
        FROM Reservations
        JOIN Books USING(ISBN) 
        JOIN Categories USING(CategoryID)
        WHERE UserID = '$userid'
        ORDER BY ReservedDate DESC
        LIMIT $start, $limit";
$result = $conn -> query($sql);

if($result -> num_rows > 0) {
    echo "<table>";
    // display headers
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Author</th>";
    echo "<th>Year</th>";
    echo "<th>Category</th>";
    echo "<th>Reserved Date</th>";
    echo "<th>Action</th>";
    echo "</tr>";

    // iterate over the result
    while($row = $result -> fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['BookTitle']} [Edition {$row['Edition']}]</td>";
        foreach ($row as $column => $value) {
            if($column == 'ISBN' || $column == 'BookTitle' || $column == 'Edition') {
                continue;
            }
            echo "<td>$value</td>";
        }
        // link to remove reserved book
        echo "<td><a href='remove_reserved.php?isbn={$row['ISBN']}'>Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "*** No reserved books ***";
}
echo '</div>';

$conn -> close();


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

include "includes/footer.php";
?>
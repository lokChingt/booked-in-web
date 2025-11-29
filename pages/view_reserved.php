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

if (!isset ($_GET['page']) ) {
    $_SESSION['params'] = $_GET;
    $_SESSION['params']['page'] = 1;

    $_SESSION['url'] = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    header("Location: " . $_SESSION['url']);
    exit;
} else {
    $page = $_GET['page'];
} 

$limit = 5;
$start = ($page-1) * $limit;

$sql2 = "SELECT COUNT(*) AS Total FROM Reservations WHERE UserID = '$userid'";
$result2 = $conn -> query($sql2);
$total_rows = $result2 -> fetch_assoc();
$book_num = $total_rows['Total'];
$total_page = ceil($book_num/$limit);


include "includes/show_message.php";
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
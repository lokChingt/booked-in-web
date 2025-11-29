<?php
include "includes/header.php";
include "includes/show_message.php";

if (!isset ($_GET['page']) ) {
    $_SESSION['params'] = $_GET;
    echo $_SESSION['params'];
    $_SESSION['params']['page'] = 1;

    $_SESSION['url'] = $_SERVER['PHP_SELF'] . '?' . http_build_query($_SESSION['params']);

    header("Location: " . $_SESSION['url']);
    exit;
} else {
    $page = $_GET['page'];
}

$limit = 5;
$start = ($page-1) * $limit;

// get book info from db
$sql = "SELECT * FROM Books ORDER BY BookTitle LIMIT $start, $limit";
$result = $conn -> query($sql);

$sql2 = "SELECT COUNT(*) AS Total FROM Books";
$result2 = $conn -> query($sql2);
$total_rows = $result2 -> fetch_assoc();
$book_num = $total_rows['Total'];
$total_page = ceil($book_num/$limit);


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

<?php 
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

include "includes/footer.php";?>
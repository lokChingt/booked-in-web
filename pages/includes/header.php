<?php
session_start();
include "db_connect.php";

// get categories for select by category dropdown
$sql = "SELECT CategoryDetail FROM Categories";
$categories = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookedIn</title>
    <link rel="stylesheet" href="/booked-in-web/css/style.css">
</head>
<body>
    <header>
        <h1><a href="index.php">BookedIn</a></h1>
        <!-- navigation -->
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="view_reserved.php">Reserved books</a></li>
            <li><a href="profile.php">Profile</a></li>
            <!-- check if logged in -->
            <?php 
            if (!$_SESSION['userid']) {
                echo "<li><a href='login.php'>Login/Register</a></li>";
            } else {
                echo "<li><a href='logout.php'>Logout</a></li>";
                $message = "Logged in as " . $_SESSION['username'];
            }
            ?>
            </ul>
        </nav>
        <Search>
            <form action="search.php" method="GET">
                <!-- search by categoty -->
                <label for="by_category">Search by Category</label>
                <select name="category" id="by_category">
                    <option value="0">--Select option--</option>
                    <?php 
                    while ($row = $categories -> fetch_assoc()) {
                        $category = $row['CategoryDetail'];
                        echo "<option value='{$category}'>$category</option>";
                    }
                    ?>
                </select>
                <!-- search by title -->
                <input type="checkbox" id="by_title" name="search_by[]" value="by_title">
                <label for="by_title">Search by Title</label>
                <!-- search by author -->
                <input type="checkbox" id="by_author" name="search_by[]" value="by_author">
                <label for="by_author">Search by Author</label>
                <!-- search word -->
                <input type="text" id="search" name="search" placeholder="Search for a book">
                <input type="submit" value="Search">
            </form>
        </Search>
    </header>

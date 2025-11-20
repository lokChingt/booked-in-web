<?php
session_start();
include "includes/db_connect.php";

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
        <h1>Welcome to BookedIn!</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="view_reserved.php">Reserved books</a>
            <a href="profile.php">Profile</a>
            <!-- check if logged in -->
            <?php 
            if (!$_SESSION['userid']) {
                echo "<a href='login.php'>Login/Register</a>";
            } else {
                echo "<a href='logout.php'>Logout</a>";
                $message = "Logged in as " . $_SESSION['username'];
            }
            ?>
            <Search>
                <form action="search.php" method="GET">
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
                    <br>
                    <input type="text" id="search" name="search" placeholder="Search for a book">
                    <input type="submit" value="Search">
                    <br>
                    <input type="checkbox" id="by_title" name="search_by[]" value="by_title">
                    <label for="by_title">Search by Title</label>
                    <input type="checkbox" id="by_author" name="search_by[]" value="by_author">
                    <label for="by_author">Search by Author</label>
                </form>
            </Search>
        </nav>
    </header>

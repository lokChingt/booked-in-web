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
            <Search>
                <form action="search.php" method="POST">
                    <input type="checkbox" id="by_title" name="search_by[]" value="by_title">
                    <label for="by_title">Search by Title</label>
                    <input type="checkbox" id="by_author" name="search_by[]" value="by_author">
                    <label for="by_author">Search by Author</label>
                    <br>
                    <input type="text" id="search" name="search" placeholder="Search for a book" required>
                    <input type="submit" value="Search">                    
                </form>
            </Search>

            <!-- check if logged in -->
            <?php 
            if (!$_SESSION['userid']) {
                echo "<a href='login.php'>Login/Register</a>";
            } else {
                echo "<a href='logout.php'>Logout</a>";
                $message = "Logged in as " . $_SESSION['username'];
            }
            ?>

            <a href="view_reserved.php">Reserved books</a>
            <a href="profile.php">Profile</a>
        </nav>
    </header>

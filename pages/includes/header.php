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
                <form method="POST">
                    <input type="text" name="search" placeholder="Search for a book">
                    <input type="submit">
                </form>
            </Search>

            <!-- check if logged in -->
            <?php 
            if (!$_SESSION['username']) {
                echo "<a href='login.php'>Login/Register</a>";
            } else {
                echo "<a href='logout.php'>Logout</a>";
            }
            ?>

            <a href="view_reserved.php">View reserved books</a>
        </nav>
    </header>

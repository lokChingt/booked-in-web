<?php 
include "includes/header.php";

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // get user password from db
    $stmt = $conn -> prepare("SELECT Password FROM Users WHERE Username = ?;");
    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $stmt -> store_result();

    // check if username existed
    if ($stmt -> num_rows() > 0) {
        $stmt -> bind_result($db_password);
        $stmt -> fetch();

        // check if password correct
        if($password === $db_password) {
            // correct password
            $result = $conn -> query("SELECT UserID FROM Users WHERE Username = '$username'");
            $row = $result -> fetch_assoc();
            $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $username;
            
            $stmt->close();
            $conn->close();
            // redirect to home page
            header("Location: index.php");
            exit();
        } else {
            // wrong password
            $error = "Incorrect Password";
        }
    } else {
        // username not exist
        $error = "Username not exist";
    }

    $stmt -> close();
    $conn -> close();
}

include "includes/show_message.php";

?>

<!-- display login form -->
<div class="display">
<h2>Login</h2>
<form method="POST">
    <table>
        <!-- username -->
        <tr>
            <td><label for="username"> Username:</label></td>
            <td><input type="text" id="username" name="username" placeholder="Username" autocomplete="username" required></td>
        </tr>
        <!-- password -->
        <tr>
            <td><label for="password"> Password:</label></td>
            <td><input type="password" id="password" name="password" placeholder="Password" required></td>
        </tr>
    </table>
    <!-- submit button -->
    <input type="submit" value="Login">
</form>

<!-- link to registration -->
<a href="register.php">Don't have an account?</a>
</div>

<?php include "includes/footer.php";?>
<?php 
include "includes/header.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // get user password from db
    $stmt = $conn -> prepare("SELECT Password FROM Users WHERE Username = ?;");
    $stmt -> bind_param("s", $username);
    $stmt -> execute();
    $stmt -> store_result();

    // existed username
    if ($stmt -> num_rows() > 0) {
        $stmt -> bind_result($db_password);
        $stmt -> fetch();

        // correct password
        if($password === $db_password) {
            $result = $conn -> query("SELECT UserID FROM Users WHERE Username = '$username'");
            $row = $result -> fetch_assoc();
            $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $username;
            $stmt->close();
            $conn->close();
            header("Location: index.php"); # redirect to main page
            exit();
        } else {
            $error = "Incorrect Password";
        }
    } else {
        $error = "Username not exist";
    }

    $stmt -> close();
    $conn -> close();
}

include "includes/show_message.php";

?>
<div class="display">
<h2>Login</h2>

<form method="POST">
    <table>
        <tr>
            <td><label for="username"> Username:</label></td>
            <td><input type="text" id="username" name="username" placeholder="Username" autocomplete="username" required></td>
        </tr>
        <tr>
            <td><label for="password"> Password:</label></td>
            <td><input type="password" id="password" name="password" placeholder="Password" required></td>
        </tr>
    </table>
    <input type="submit" value="Login">
</form>
<a href="register.php">Don't have an account?</a>
</div>

<?php include "includes/footer.php";?>
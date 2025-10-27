<?php include "includes/header.php";?>

<h1>Login to BookedIn</h1>

<form method="POST">
    <table>
        <tr>
            <label> 
                <td>Username:</td>
                <td><input type="text" name="username" placeholder="Username" required></td>
            </label>
        </tr>
        <tr>
            <label> 
                <td>Password:</td>
                <td><input type="text" name="password" placeholder="Password" required></td>
            </label>
        </tr>
    </table>
    <input type="submit" value="Login">
</form>
<br>
<a href="register.php">Don't have an account?</a>

<?php include "includes/footer.php";?>
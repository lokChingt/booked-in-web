<?php 
include "includes/header.php";
include "includes/show_message.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username  = $_POST['username'];
    $fname     = $_POST['fname'];
    $surname   = $_POST['surname'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $city      = $_POST['city'];
    $telephone = $_POST['telephone'];
    $mobile    = $_POST['mobile'];
    $password  = $_POST['password'];


    // check if username exist
    $checkUserStmt = $conn -> prepare("SELECT Username FROM Users WHERE Username = ?;");
    $checkUserStmt -> bind_param("s", $username);
    $checkUserStmt -> execute();
    $result = $checkUserStmt -> get_result();

    // username been used
    if($result && $result -> num_rows > 0) {
        $message = "Username already been used";
    } else {
        // username not been used
        $stmt = $conn -> prepare("INSERT INTO Users 
                                (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) 
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("sssssssss", $username, $password, $fname, $surname, $address_1, $address_2, $city, $telephone, $mobile);
        $message = "Registered Please login!";
        if($stmt -> execute()) {
            # redirect to login page
            header("Location: login.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt -> close();
    }
    $checkUserStmt -> close();
    $conn -> close();
}

?>

<h2>Register BookedIn Account</h2>
<form method="POST">
    <table>
        <tr>
            <td><label for="fname">First Name:</label></td>
            <td><input type="text" id="fname" name="fname" placeholder="First Name" required></td>
        </tr>
        <tr>
            <td><label for="surname">Surname:</label></td>
            <td><input type="text" id="surname" name="surname" placeholder="Surname" required></td>
        </tr>
        <tr>
            <td><label for="address_1">Address Line 1:</label></td>
            <td><input type="text" id="address_1" name="address_1" placeholder="Address Line 1"></td>
        </tr>
        <tr>
            <td><label for="address_2">Address Line 2:</label></td>
            <td><input type="text" id="address_2" name="address_2" placeholder="Address Line 2"></td>
        </tr>
        <tr>
            <td><label for="city">City:</label></td>
            <td><input type="text" id="city" name="city" placeholder="City" required></td>
        </tr>
        <tr>
            <td><label for="telephone">Telephone:</label></td>
            <td><input type="text" id="telephone" name="telephone" placeholder="Telephone"></td>
        </tr>
        <tr>
            <td><label for="mobile">Mobile:</label></td>
            <td><input type="text" id="mobile" name="mobile" placeholder="Mobile"></td>
        </tr>
        <tr>
            <td><label for="username"> Username:</label></td>
            <td><input type="text" id="username" name="username" placeholder="Username" autocomplete="username" required></td>
        </tr>
        <tr>
            <td><label for="password"> Password:</label></td>
            <td><input type="password" id="password" name="password" placeholder="Password" required></td>
        </tr>
    </table>
    <input type="submit" value="Register">
</form>

<?php include "includes/footer.php";?>
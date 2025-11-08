<?php 
include "includes/header.php";
include "includes/db_connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username       = $_POST['username'];
    $fname          = $_POST['fname'];
    $surname        = $_POST['surname'];
    $address_line_1 = $_POST['address_line_1'];
    $address_line_2 = $_POST['address_line_2'];
    $city           = $_POST['city'];
    $telephone      = $_POST['telephone'];
    $mobile         = $_POST['mobile'];
    $password       = $_POST['password'];

    $sql = "INSERT INTO Users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) 
    VALUES('$username', '$password', '$fname', '$surname', '$address_line_1', '$address_line_2', '$city', '$telephone', '$mobile')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
        $conn->close();
    }
}

?>

<h1>Register BookedIn Account</h1>
<form method="POST">
    <table>
        <tr>
            <label>
                <td>First Name:</td>
                <td><input type="text" name="fname" placeholder="First Name" required></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Surname:</td>
                <td><input type="text" name="surname" placeholder="Surname" required></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Address Line 1:</td>
                <td><input type="text" name="address_line_1" placeholder="Address Line 1"></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Address Line 2:</td>
                <td><input type="text" name="address_line_2" placeholder="Address Line 2"></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>City:</td>
                <td><input type="text" name="city" placeholder="City" required></td>
            </label>
        </tr>
        <tr>
            <label> 
                <td>Telephone:</td>
                <td><input type="text" name="telephone" placeholder="Telephone"></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Mobile:</td>
                <td><input type="text" name="mobile" placeholder="Mobile"></td>
            </label>
        </tr>
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
    <input type="submit" value="Register">
</form>

<?php 
// Display error if any
if (isset($error)) {
    echo "<div class='error'>" . $error . "</div>";
}

include "includes/footer.php";
?>
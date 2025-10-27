<?php include "includes/header.php";?>

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
                <td><input type="text" name="address_line_1" placeholder="Address Line 1" required></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Address Line 2:</td>
                <td><input type="text" name="address_line_2" placeholder="Address Line 2" required></td>
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
                <td><input type="text" name="telephone" placeholder="Telephone" required></td>
            </label>
        </tr>
        <tr>
            <label>
                <td>Mobile:</td>
                <td><input type="text" name="mobile" placeholder="Mobile" required></td>
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

<?php include "includes/footer.php";?>
<?php
/*
    register.php
    Daniel Shupe
    CSIS 410
    This page displays the account registration form and displays any errors that occur.
*/
    require 'header.php';
    if (!isset($_SESSION['access'])) {
        display_header("Account Registration","Account registration for OrangeNinjaProductions.com","candelas.css");
    }
    else {
        display_header("Account Management","Account management for OrangeNinjaProductions.com","candelas.css");
    }
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<h1>Register</h1>
<?php
//  if user is already logged in and not an administrator, send to index
if (isset($_SESSION['logged_in']) && (!isset($_SESSION['access']) == "Admin")) {
    header("Location: ../index.php");
    exit();
}
    if (isset($_GET['error'])) {
        $username=$_GET['username'];
        $email=$_GET['email'];
        $first_name=$_GET['first_name'];
        $last_name=$_GET['last_name'];
        echo '<div class="register_failed">';
        //  display any error messages passed from signup.pho script
        if ($_GET['error'] == "empty") {
            echo '<p>Please fill in all of the fields.</p></div>';
        }
        else if ($_GET['error'] == "invalidemailaddress") {
            echo '<p>Email address is not valid</p></div>';
        }
        else if ($_GET['error'] == "alreadyexits") {
            echo '<p>The username or email already exists.</p></div>';
        }
        else if ($_GET['error'] == "invalidusername") {
            echo '<p>The username can only contain letters and numbers.</p></div>';
        }
        else if ($_GET['error'] == "impropernameformat") {
            echo '<p>The first and last name may only contain letters.</p></div>';
        }
        else if ($_GET['error'] == "passwordnomatch") {
            echo '<p>The passwords must match.</p></div>';
        }
        else if ($_GET['error'] == "invalidentry") {
            echo '<p>You entered something unexpected.</p></div>';
        }
    }
    else if (isset($_GET['register'])) {
        //  notify user if account creation successful
        echo '<div class="register_successful">';
        if ($_GET['register'] == 'success') {
            echo '<p>Account created successfully!</p></div>';
        }
    }
?>
<div class="register">
<form action="signup.php" method="post">
    <table>
    <tr><td><label>Username</label></td>
    <td><input type="text" name="username" <?php if(isset($_GET['username'])) { echo 'value="'.$username .'"';} ?> /></td></tr>
    <tr><td><label>Email Address</label></td>
    <td><input type="text" name="email" <?php if(isset($_GET['email'])) { echo 'value="'.$email .'"';} ?> /></td></tr>
    <tr><td><label>First Name</label></td>
    <td><input type="text" name="first_name" <?php if(isset($_GET['first_name'])) { echo 'value="'.$first_name .'"';} ?> /></td></tr>
    <tr><td><label>Last Name</label></td>
    <td><input type="text" name="last_name" <?php if(isset($_GET['last_name'])) { echo 'value="'.$last_name .'"';} ?> /></td></tr>
    <tr><td><label>Password</label></td>
    <td><input type="password" name="password" /></td></tr>
    <tr><td><label>Re-enter Password</label></td>
    <td><input type="password" name="password_check" /></td></tr>
    ><?php if (isset($_SESSION['access'])) {
        if ($_SESSION['access'] == "Admin") {
            echo '<tr><td><label>Access Level</label></td>';
            require_once 'access_selector.php';
            echo '<td>';
            get_access();
            echo '</td></tr>';
        }
    }
    ?>
    </table>
    <div><input type="submit" name="register" value="Register" /></div>
</form>
</div>
<div class="footer">
<?php
    display_footer("register.php");
?>
</div>
</body>
</html>
<?php
/*
    signin.php
    Daniel Shupe
    CSIS 410
    This page allows the user to sign into the website.  This page generally only appears if the user unsuccessfully logs in with the menu login form, or accesses the shop before logging in.
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Sign In","Login page for Orange Ninja Productions","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
    
    <?php
    //  display any errors from login 
    if (isset($_GET['error'])) {
        echo '<div class="register_failed">';
        if ($_GET['error'] == "empty") {
            echo '<p>A value must be entered into both fields.</p>';
        }
        else if ($_GET['error'] == "invalidpass") {
            echo '<p>Password does not match.</p>';
        }
        else if ($_GET['error'] == "usernotfound") {
            echo '<p>The username/email is not in the database.</p>';
        }
        echo '</div>';
    }
    //  if user is already logged in, go to index
    if (isset($_SESSION['logged_in'])) {
        header("Location: index.php");
        exit();
    }
    ?>
<div class="article">
<h1>User Login</h1>
    <p>
        Please login using the form in the menu bar.
    </p>
</div>
<div class="footer">
<?php
    display_footer("signin.php");
?>
</div>
</body>
</html>
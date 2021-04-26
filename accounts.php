<?php
/*
    accounts.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Home","This is the home page for the Orange Ninja Productions website","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
<?php
    if (isset($_SESSION['logged_in']) &&  isset($_SESSION['access'])) {
        if ($_SESSION['access'] == "Admin") {
            require 'database_handler.php';
            $sql = "SELECT * FROM accounts WHERE account_id <> ".$_SESSION['account_id'];
            $result = $connection->query($sql);
            if (!$result) {
                trigger_error('Invalid query: ' . $connection->error);
            }
            if ($result->num_rows > 0) {
                echo '<div class="manage"><form action="user_manage.php" method="post">';
                echo '<select name="account_id">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row['account_id'].'">'.$row['username'].'</option>';
                }
                echo '</select>';
                echo '<input type="submit" name="edit" value="Edit" />';
                echo '<input type="submit" name="delete" value="Delete" />';
                echo '<div><input type="submit" name="new" value="New" /></div>';
                echo '</form></div>';
            }
        }
    }
?>
</div>
<div class="footer">
<?php
    display_footer("accounts.php");
?>
</div>
</body>
</html>
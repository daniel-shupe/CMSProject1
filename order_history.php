<?php
    require 'header.php';
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
?>

<?php
    display_header("Orange Ninja Productions - Order History for ".$_SESSION['username'],"This is the Order History page for the Orange Ninja Productions website","candelas.css");
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<body>
<?php
if (isset($_SESSION['logged_in']) && isset($_SESSION['access'])) {
    if ($_SESSION['access'] == "Customer") {
        require 'database_handler.php';
        $sql = "SELECT a.account_id, a.username, o.order_id, "
    }
}


?>
<div class="footer">
<?php
    display_footer("index.php");
?>
</body>
</html>
<?php
    require 'header.php';
    require 'footer.php';
    require 'menu.php';
    require 'database_handler.php';
?>
<?php
    display_header("Product Menu","A list of products sold on OrangeNinjaProductions.com","candelas.css");
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<body>
<?php
    $sql = "SELECT * FROM products ORDER BY 'content_type_id'";
    $result = $connection->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $connection->error);
    }
    if ($result->num_rows > 0) {
        print "<table class=\"product\">";
        while ($row = $result->fetch_assoc()) {
            print "<tr><td><img src=\"images/{$row['image']}\" alt=\"CRB\" /><div class=\"caption\">{$row['name']}</div></td><td>{$row['short_description']}</td><td>{$row['price']}</td></tr>";
        }
        print "</table>";
        $connection->close();
    }
?>
<div class="footer">
<?php
    display_footer("index.php");
?>
</body>
</html>
<?php
/*
    index.php
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
<h1>Welcome to Orange Ninja Productions!</h1>
<p>This is the website for Orange Ninja Productions!  We make games that focus on teaching biblical values while still being a lot of fun!</p>
</div>
<div class="footer">
<?php
    display_footer("index.php");
?>
</div>
</body>
</html>
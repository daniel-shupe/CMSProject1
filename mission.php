<?php
/*
    index.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Our Mission","This is the mission statement for Orange Ninja Productions","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<body>
<div class="article">
<h1>Mission Statement</h1>
<h2>Gaming with a Purpose:</h2>
<p>
      Orange Ninja Productions seeks to use a controversial time in Christian History to give players an opportunity to explore the deeper moral truths of the Christian ethic in a fun and memorable way.  By rewarding players for their moral decisions above and beyond their outward successes, Orange Ninja Productions fosters an Christian attitude and way of thinking that can be applied even in difficult life circumstances.
<p>
</div>
<div class="footer">
<?php
    display_footer("mission.php");
?>
</div>
</body>
</html>
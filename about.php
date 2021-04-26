<?php
/*
    about.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - About Us","About Orange Ninja Productions","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
<h1>About Us</h1>
<p>
Orange Ninja Productions was founded by Daniel Shupe with inspiration from his wife, Jennifer Shupe, as well as from their adorable dog, Pixie, in July, 2020.  Orange Ninja Productions seeks to provide quality gaming experiences with a Christian moral center in order to provide an experience that is both fun and spiritually beneficial.  Currently, ONP is using historic events to provide the basis for these gaming adventures, beginning with the Crusades.  ONP has a number of other projects in the works, including adventures based on Biblical times and settings.  In the meantime, we hope you enjoy and benefit from the moral and life challenges inherent in this setting and its modules.  
</p>
</div>
<div class="footer">
<?php
    display_footer("about.php");
?>
</div>
</body>
</html>
<?php
/*
    biography.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Biographies","Biography for the founder of ONP","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
    <h1>Daniel Shupe</h1>
    <p>Daniel Shupe is the founder of Orange Ninja Productions.  He is a student at Libery University, and lives in Richmond, Virginia.  Daniel is a fan of both computer and tabletop
    games, including roleplaying games such a Pathfinder and Dungeons and Dragons.  He was inspired to create the Trials of Faith roleplaying
    game because he felt there was a need for a Christianity-based tabletop game.</p>
</div>
<div class="footer">
<?php
    display_footer("biography.php");
?>
</div>
</body>
</html>
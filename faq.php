<?php
/*
    faq.php
    Daniel Shupe
    CSIS 410
    This page displays frequently asked questions.
*/
    require 'header.php';
    display_header("Orange Ninja Productions - FAQ","Frequently asked questions","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
<h1>Frequently Asked Questions</h1>
<div class="class_name">Q. How many players can play a game of Trials of Faith?</div>
<p>
    A: There is no limit to the numbers of players that you can have.  However, it is recommened to be played with 5-6 players, with one
    acting as the Game Master.
</p>
<div class="class_name">Q. Will there be any character classes added in the future?</div>
<p>
    A: We are always looking for ways to add content to the game, where it makes sense.  So, the answer here is maybe.
</p>
</div>
<div class="footer">
<?php
    display_footer("faq.php");
?>
</div>
</body>
</html>
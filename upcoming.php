<?php
/*
    upcoming.php
    Daniel Shupe
    CSIS 410
    This page will highlight upcoming products.
*/
    require 'header.php';
    display_header("Upcoming Products","A list of upcoming items for Orange Ninja Productions.","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
<h1>Coming Soon!</h1>
<h2>Trials of Faith: The Crusades (video game)</h2>
<p>Experience the Crusades like never before with the Trails of Faith: The Crusades video game.  Create your adventurer and travel across the land spreading the word of God.</p>
<h3>Features:</h3>
<ul>
    <li>Online Multiplayer, up to 6 players.</li>
    <li>All 10 classes from the Core Rule Book.</li>
    <li>Campaign Editor: Create your own campaigns to play with your friends.</li>
    <li>Available for PC, MAC, Switch</li>
</ul>
<p>Trials of Faith: The Crusades video game will be available in 2022.</p>
</div>
<div class="footer">
<?php
    display_footer("upcoming.php");
?>
</div>
</body>
</html>
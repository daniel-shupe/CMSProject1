<?php
    require '../header.php';
    require '../footer.php';
    require '../menu.php';
    require '../variables.php';
?>

<?php
    display_header("Trials of Faith - Overview","An overview of the Trials of Faith roleplaying game.","../candelas.css");
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<body>
<div class="article">
<h1>Trials of Faith Roleplaying Game System Overiew</h1>
<p>
    The Trials of Faith roleplaying game is based on the d20 system used in similar games such as Pathfinder and Dungeons and Dragons.
    What sets Trials of Faith apart are the morality system and faith-based abilities called "Miracles".  While other games do have character
    alignments such as good and evil, or lawful and chaotic, the morality system in Trials of Faith work differently.  Every time a character
    commits an action that God would view favorably, they gain faith points; faith points are lost if the character performs an unfavorable action.
    As the player accumulates faith, they get access to Miracles, which are based on their class.  Alternatively, players who have a large negative
    faith value gain access to Disasters which, while powerful, have severe consequences for the party if used.
</p>
</div>
<div class="footer">
<?php
    display_footer("overview.php");
?>
</body>
</html>
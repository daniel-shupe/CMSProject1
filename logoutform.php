<?php
/*
    logoutform.php
    Daniel Shupe
    CSIS 410
    This file displays the logout button in the menu
*/
    print "<div class=\"logout\"><form action=\"logout.php\" method=\"post\">";
    print "<label for=\"test\">Welcome, " . $_SESSION['username'] . "</label>";
    print "<input type=\"submit\" value=\"Logout\" /></form></div>";
?>
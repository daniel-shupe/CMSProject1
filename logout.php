<?php
/*
    logout.php
    Daniel Shupe
    CSIS 410
    This file destroys the session upon Logout
*/
    //  logs the user out of the session
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
?>
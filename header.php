<?php
/*
    header.php
    Author: Daniel Shupe
    Creation Date: 7/10/2020
    Liberty University
    CSIS 410
*/
    
    session_start();
    $temp = basename($_SERVER['PHP_SELF']);
    $_SESSION['current_page'] = str_replace("scripts","",$temp);
    //  inserts title, description, and css link passed to function into header
    function display_header(string $title, string $description, string $css) {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        echo "\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
        require 'variables.php';
        print "<head>
                <meta content=\"text/html\" />
                <title>{$title}</title>
                <meta name=\"description\" content=\"{$description}\" />
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"$css\" />
            </head><body>";
            print $banner;
        
    }
?>
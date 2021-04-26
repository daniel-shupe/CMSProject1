<?php
/*
    footer.php
    Author: Daniel Shupe
    Creation Date: 7/10/2020
    Liberty University
    CSIS 410
*/
    function display_footer(string $filename) {
        //  attempt to get the last modified time of $filename
        try {
            $last_modified = date("d M Y H:i:s", filemtime($filename));
        }
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        //  display last modified time in footer
        echo '<hr />';
        echo '<p><a href="https://twitter.com/OrangeNinjaPro2"><img style="border:1px;width:40px;height:40px" src="../images/twitter.png" alt="Follow us on Twitter" /></a>';
        echo '<a href="https://facebook.com"><img style="border:1px;width:40px;height:40px" src="../images/fb.png" alt="Follow us on Facebook" /></a></p>';
        echo "<p>$filename was last Modified on $last_modified</p>";
        //  display validation icons/links
        print " <p>
                    <a href=\"http://validator.w3.org/check?uri=referer\"><img
                    src=\"http://www.w3.org/Icons/valid-xhtml10\" alt=\"Valid XHTML 1.0 Strict\" height=\"31\" width=\"88\" /></a>
                    <a href=\"http://jigsaw.w3.org/css-validator/check/referer\">
                    <img style=\"border:0;width:88px;height:31px\"
                    src=\"http://jigsaw.w3.org/css-validator/images/vcss-blue\"
                    alt=\"Valid CSS!\" />
                    </a>
                </p>";
    }
?>
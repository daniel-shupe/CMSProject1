<?php
    /*
    menu.php
    Author: Daniel Shupe
    July 12, 2020
    CSIS 410
    Liberty University
    This file displays the menu for OrangeNinjaProductions.com
    */
    require 'variables.php';
    //  this function displays the site menu
    
    function display_menu($links, $drop, $css_class) {
        print "<div class=\"$css_class\">";
        foreach($links as $key => $value) {
            if(($key != "tof/overview.php") && ($key != "../shop.php")) {
                print "<a href=\"$key\">$value</a>";
            }
            //  display dropdown for Trials of Faith
            else if ($key == "tof/overview.php") {
                echo '<div class="dropdown">';
                echo '<button class="dropbutton">Trials Of Faith</button>';
                echo '<div class="dropdown-content">';
                echo '<ul>';
                foreach($drop as $key => $value) {
                    echo '<li><a href="'.$key.'">'.$value.'</a></li>';
                }
                echo '</ul>';
                echo '</div></div>';
            }
            //  If Admin or Publisher, display product listing instead of shop
            else if (isset($_SESSION['access'])) {
                if ($_SESSION['access'] == "Admin" || $_SESSION['access'] == "Publisher") {
                    $key = "../products.php";
                    $value = "Products";
                }
                print "<a href=\"$key\">$value</a>";
            }
            else {
                print "<a href=\"$key\">$value</a>";
            }
        }
        //  if access is Admin, display user management link
        if (isset($_SESSION['access'])) {
            if ($_SESSION['access'] == "Admin") {
                $key = "accounts.php";
                $value = "User Management";
                print "<a href=\"$key\">$value</a>";
            }
            if ($_SESSION['access'] == "Customer") {
                $key = "orderhistory.php";
                $value = "Order History";
                print "<a href=\"$key\">$value</a>";
            }
        }
        
        //  if logged in, displayed logout button and bag
        if (isset($_SESSION['logged_in'])) {
            if(isset($_SESSION['access'])) {
                if ($_SESSION['access'] == "Customer") {
                    require 'database_handler.php';
                    $bag_id = get_bag($connection);
                    if ($_SERVER['PHP_SELF'] !== '/ordersubmit.php') {
                        $sql = "SELECT c.account_id, c.bag_id, SUM(cp.quantity) AS qty FROM bags c JOIN bag_products cp ON c.bag_id = cp.bag_id WHERE c.account_id = {$_SESSION['account_id']} AND c.active=1";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $_SESSION['bag_load'] = $row['qty'];
                            $_SESSION['bag_id'] = $bag_id;
                            echo '<div class="bag"><a href="bag.php"><img src="../images/bag.png" alt="bag" />('.$_SESSION['bag_load'].')</a></div>';
                        }
                    }                    
                }
            }
            include 'logoutform.php';
        }
        //  else display login form
        else {
            print "<div class=\"login\">\n<form method=\"post\" action=\"login.php\">\n";
            print "<div><label for=\"username\">Username:</label>\n";
            print "<input type=\"text\" name=\"username\" />\n";
            print "<label for=\"password\">Password:</label>\n";
            print "<input type=\"password\" name=\"password\" />\n";
            print "<input type=\"submit\" value=\"Login\" name=\"login\"/>\n";
            echo '<a style="padding-right: 10px; padding-left: 10px" href="register.php">Register</a></div></form></div>';
        }
        
        echo '</div>';

    }

    function get_bag($connection) {
        $sql = "SELECT * FROM bags WHERE account_id = ".$_SESSION['account_id']." AND active=1 LIMIT 1";
        $result = $connection->query($sql);
        //  create new bag_id
        if ($result->num_rows == null)
        {
            $sql = "INSERT INTO bags (account_id) VALUES (".$_SESSION['account_id'].")";
                    $result = $connection->query($sql);
                    $bag_id = mysqli_insert_id($connection);
        }
        //  pull existing bag_id
        else {
            while($row = $result->fetch_assoc()) {
                $bag_id = $row['bag_id'];
            }
        }
        return $bag_id;
    }
?>
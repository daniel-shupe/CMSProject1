<?php
/*
    shop.php
    Daniel Shupe
    CSIS 410
    This page displays the items from the products table and allows the user to add them to the bag, if they are signed in.
*/
    //  if logged in
    if (!isset($_SESSION['logged_in'])) {
        header("Location: ../signin.php");
        exit();
    }
    require 'header.php';
    display_header("Shop","A list of products sold on OrangeNinjaProductions.com","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    require 'database_handler.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<?php
    if (isset($_SESSION['logged_in'])) {
        //  if no bag, create one
        if ($_SESSION['access'] != "Customer") {
            header("Location: ../index.php");
            exit();
        }
        if (!isset($_SESSION['bag'])) {
            $_SESSION['bag'] = array();
        }
        //  order products by content type
        
        $sql = "SELECT * FROM products ORDER BY 'content_type_id'";
        $result = $connection->query($sql);
        if (!$result) {
            trigger_error('Invalid query: ' . $connection->error);
        }
        //  display results of query in a table with a form for each row
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<form action="addtobag.php" method="post">';
                print "<table class=\"product\">";
                //  if image file does not exist on server, display a place holder
                $image = $row['image'];
                if (!file_exists("images/".$image)) {
                    $image = 'placeholder.png';
                }
                print "<tr><td><img src=\"images/{$image}\" alt=\"CRB\" /><div class=\"caption\">{$row['name']}</div></td>";
                print "<td>{$row['long_description']}</td>";
                print "<td>$ ".number_format($row['price'],2)."</td>";
                //  button will add 1 of item to bag
                echo '<td><p>Qty</p><input type="text" name="quantity'.$row['product_id'].'" value="1" /></td>';
                print "<td><input type=\"hidden\" name=\"item\" value=\"".$row['product_id']."\" /><button type=\"submit\">Add to bag</button></td></tr>";
                print "</table></form>";
            }
            
            $connection->close();
        }
    }
    else {
        header("Location: ../signin.php");
        exit();
    }
?>
<div class="footer">
<?php
    display_footer("shop.php");
?>
</div>
</body>
</html>
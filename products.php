<?php
/*
    shop.php
    Daniel Shupe
    CSIS 410
    This page displays the items from the products table and allows the user to add them to the bag, if they are signed in.
*/
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
    //  if logged in
    if (isset($_SESSION['logged_in'])) {
        //  if access level set
        if (isset($_SESSION['access'])) {
            if ($_SESSION['access'] == "Admin" or $_SESSION['access'] == "Publisher") {
                $sql = "SELECT * FROM products ORDER BY content_type_id";
                $result = $connection->query($sql);
                if (!$result) {
                    trigger_error('Invalid query: ' . $connection->error);
                }
                //  display new item button
                echo '<div class="manage"><form action="content_manage.php" method="post">';
                echo '<input type="hidden" name="table" value="products" />';
                echo '<input type="submit" name="new" value="New Product" />';
                echo '</form></div>';
                //  display results of query in a table with a form for each row
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<form action="content_manage.php" method="post">';
                        print "<table class=\"product\">";
                        //  hidden post variables
                        echo '<input type="hidden" name="table" value="products" />';
                        echo '<input type="hidden" name="record" value="'.$row['product_id'].'" />';
                        echo '<input type="hidden" name="image" value="'.$row['image'].'" />';
                        echo '<input type="hidden" name="price" value="'.$row['price'].'" />';
                        echo '<input type="hidden" name="name" value="'.$row['name'].'" />';
                        echo '<input type="hidden" name="short_description" value="'.$row['short_description'].'" />';
                        echo '<input type="hidden" name="long_description" value="'.$row['long_description'].'" />';
                        echo '<input type="hidden" name="content_type_id" value="'.$row['content_type_id'].'" />';
                        //  check if image file exists, display placeholder if needed
                        $image = $row['image'];
                        if (!file_exists("images/".$image)) {
                            $image = 'placeholder.png';
                        }
                        //  display table
                        print "<tr><td><img src=\"images/{$image}\" alt=\"{$row['image']}\" /><div class=\"caption\">{$row['name']}</div></td>";
                        print "<td>{$row['long_description']}</td>";
                        print "<td>$ ".number_format($row['price'],2)."</td>";
                        //  display edit button
                        echo '<td><input type="submit" name="edit'.$row['product_id'].'" value="Edit" /></td>';
                        //  if Admin is logged in, show delete button
                        if ($_SESSION['access'] == "Admin") {
                            echo '<td><input type="submit" name="delete'.$row['product_id'].'" value="Delete" /></td></tr>';
                        }
                        print "</table></form>";
                    }             
                    $connection->close();
                }    
            }
        }
        //  order products by content type
        
        
    }
    else {
        header("Location: ../Signin.php");
    }
?>
<div class="footer">
<?php
    display_footer("products.php");
?>
</div>
</body>
</html>
<?php
/*
    bag.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Shopping bag","Items currently in bag for order on Orange Ninja Productions shop","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<?php
    //  if a bag exists
    if (isset($_SESSION['bag_load'])) {
        if ($_SESSION['access'] != "Customer") {
            header("Location: ../index.php");
            exit();
        }
        require 'database_handler.php';
        $sql = "SELECT product_id, quantity FROM bag_products WHERE bag_id ={$_SESSION['bag_id']}";
        $result = $connection->query($sql);
        while($row = $result->fetch_assoc())
        $frequencies[] = $row;        

        //  query database for all products
        $sql = "SELECT * FROM products";
        $result = $connection->query($sql);
        while($row = $result->fetch_assoc()) {
            $products[] = $row;    
        }
        $connection->close();
        //  values for total cost and sales tax (virginia)
        $total = 0;
        $sales_tax = .055;
        echo '<form method="post" action="../ordersubmit.php"><table class="bag">';
        echo '<thead><tr><th>Item</th><th>Description</th><th>Quantity</th><th>Price</th></tr></thead>';
        //  loop through frequencies to fill bag table
        foreach($frequencies as $freq) {
            foreach($products as $row) {
                if ($freq['product_id'] == $row['product_id']) {
                    $quantity = $freq['quantity'];
                    echo '<tr><td>'.$row['name'].'</td><td>'.$row['short_description'].'</td><td><input type="text" name="'.$row['product_id'].'" value="'.$quantity.'"</td><td> $'.$row['price']*$quantity.'</td></tr>';
                    $total += $row['price'] * $quantity;
                    $total = number_format($total,2);
                }
             }    
        }
        echo '</tbody></table>';
        //  display bag total and update/checkout buttons
        echo '<div class="bag"><table><tr><td><input type="submit" value="Checkout" name="checkout"/></td><td></td><td><input type="submit" formaction="../updatebag.php" value="Update bag" /></td><td>Total: $'.number_format($total * (1 + $sales_tax),2).'</td></tr></table></div></form>'; 
    }
?>
<div class="footer">
<?php
    display_footer("bag.php");
?>
</div>
</body>
</html>
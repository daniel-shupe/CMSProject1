<?php
/*
    ordersubmit.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Order Summary","Order Summary for shop.","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<?php
    if (isset($_POST['checkout'])) {
        if (isset($_SESSION['bag_load'])) {
            echo '<div class="article">';   
            echo '<h1>Thank you for placing an order with us!</h1>';
            require 'database_handler.php';
            $bag_id = get_bag($connection);
            //  query database for all products
            $sql = "SELECT * FROM products";
            $result = $connection->query($sql);
            while($row = $result->fetch_assoc()) {
                $products[] = $row;    
            }
            $sql = "SELECT * FROM bag_products WHERE bag_id=?";
            $stmt = $connection->prepare($sql);
            if (!$stmt->bind_param("i",$bag_id)) {
                header("Location: ../index.php?sql=error");
                exit();
            }
            else {
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bag_row[] = $row;
                    }
                }
                else {
                    header("Location: ../index.php?sql=norows");
                    exit();
                }
            }
            //  values for total cost and sales tax (virginia)
            $total = 0;
            $sales_tax = .053;
            //  create new order in order table
            $sql = "INSERT INTO orders (account_id, total) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ".$page."?error=invalidentry");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ii", $_SESSION['account_id'], $total);
                mysqli_stmt_execute($stmt);
            }
            //  get order_id
            $order_id = mysqli_insert_id($connection);
            //  loop through bag
            foreach($bag_row as $bag) {
                foreach ($products as $row) {
                    if ($bag['product_id'] == $row['product_id']) {
                        $cost = $bag['cost'];
                        $quantity = $bag['quantity'];
                        echo '<p>'.$row['name'].' x ' .$quantity. ' at '.number_format($row['price'],2).' = $ '.number_format($cost,2);
                        $total += $cost;
                        //  add to order_products table for order history
                        $sql = "INSERT INTO order_products (order_id, product_id, quantity, cost) VALUES (?, ?, ?, ?)";
                        $sntmt = mysqli_stmt_init($connection);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ".$page."?error=invalidentry");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "iiid", $order_id, $row['product_id'], $quantity, $cost);
                            mysqli_stmt_execute($stmt);
                        }
                    }
                }
            }
            //  display total
            echo '<hr /><p>Your total is : $ ' . number_format($total*(1 + $sales_tax),2).'</p></div>';
            //  set bag as inactive
            $clear = 0;
            $sql = "UPDATE bags SET active=? WHERE bag_id=? AND account_id=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("iii",$clear,$bag_id,$_SESSION['account_id']);
                $stmt->execute();
                //  clear bag
                unset($bag_id);
                unset($_SESSION['bag_load']);
                unset($_SESSION['bag_id']);
            //  update order in order table with total
            
            $sql = "UPDATE orders SET total = ".number_format($total*(1 + $sales_tax),2)." WHERE order_id = ".$order_id;
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ".$page."?error=invalidentry");
                exit();
            }
            else {
                mysqli_stmt_execute($stmt);
            }
        }
    }
?>
<div class="footer">
<?php
    display_footer("ordersubmit.php");
?>
</div>
</body>
</html>
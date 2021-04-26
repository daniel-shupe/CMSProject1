<?php
/*
    index.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Home","This is the home page for the Orange Ninja Productions website","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="article">
<?php
    require 'database_handler.php';
    if (!isset($_SESSION['logged_in'])) {
        header("Location: ../index.php");
        exit();
    }
    if ($_SESSION['access'] != "Customer") {
        header("Location: ../index.php");
        exit();
    }
    $sql = "SELECT a.account_id, o.order_id AS 'order_id', o.date AS 'date', o.total AS 'total', op.product_id, op.quantity AS 'quantity', op.cost AS 'cost', p.name AS 'name', p.price AS 'price', p.short_description AS 'sd' FROM accounts a
    INNER JOIN orders o ON o.account_id = a.account_id
    INNER JOIN order_products op ON o.order_id=op.order_id
    INNER JOIN products p ON op.product_id=p.product_id
    WHERE a.account_id=? ORDER BY o.order_id";
    $order_line = array();
    $stmt = $connection->prepare($sql);
        if($stmt->bind_param("i",$_SESSION['account_id'])) {
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $order_line[] = $row;
                }
                echo '<h1>Orders for '.$_SESSION['username'].':</h1>';
                $last_order = 0;
                foreach($order_line as $ol) {
                    $oid = $ol['order_id'];
                    $total;
                    if ($last_order != $oid) {
                        if ($last_order != 0) {
                            echo '<tr><td>Total (5.3% tax):</td><td colspan="4" style="text-align:right;">$ '.$total.'</td></tr>';
                            echo '</table>';
                        }
                        $last_order = $oid;
                        echo '<h2>Order#: '.$oid.' on '.$ol['date'].'</h2>';
                        echo '<table>';
                        echo '<tr><th>Product</th><th>Description</th><th>Price</th><th>Quantity</th><th>Line Total</th></tr>';
                    }
                    if ($last_order == $oid) {
                        echo '<tr><td>'.$ol['name'].'</td><td>'.$ol['sd'].'</td><td>'.$ol['price'].'</td><td>'.$ol['quantity'].'</td><td>'.$ol['cost'].'</td></tr>';
                        $total = $ol['total'];
                    }
                }
                echo '<tr><td>Total (5.3% tax):</td><td colspan="4" style="text-align:right;">$ '.$total.'</td></tr>';
                echo '</table>';
            }
            else {
                echo "No order history.";
            }
        }
        else {
        }    
?>
</div>
<div class="footer">
<?php
    display_footer("orderhistory.php");
?>
</div>
</body>
</html>
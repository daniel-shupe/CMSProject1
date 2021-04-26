<?php
    session_start();
    //  check to see if script was reached via post
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['access']) && ($_SESSION['access'] == "Customer")) {
        require 'database_handler.php';
        
        $item = $_POST['item'];
        $qty = $_POST['quantity'.$item];
        $bag_id = get_bag($connection);
        //  check if user has an active bag
        
        //  test qty
        if (!is_numeric($qty) || $qty < 1) {
            header("Location: ".$_SESSION['current_page']."?error=invalidqty");
            exit();
        }
        else {
        //  select statement using product_id from post
        $sql = "SELECT * FROM products WHERE product_id=?";
        $stmt = mysqli_stmt_init($connection);              //  prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ".$_SESSION['current_page']."?error=invalidentry");
            exit();
        }
        else {
            //  assign product_id to bag
            $item = str_replace("'","",$item);
            mysqli_stmt_bind_param($stmt, "i", $item);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $product = $row['product_id'];
            $cost = $row['price'] * $qty;
            //  check if item is already in bag
            $sql = "SELECT product_id, quantity, cost FROM bag_products WHERE bag_id={$bag_id} AND product_id={$product}";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $qty += $row['quantity'];
                $cost += $row['cost'];
                $sql = "UPDATE bag_products SET quantity = {$qty}, cost = {$cost} WHERE bag_id={$bag_id} AND product_id={$product}";
                $result = $connection->query($sql);
            }
            //  add new product to bag
            else {
                $sql = "INSERT INTO bag_products (bag_id, product_id, quantity, cost) VALUES ({$bag_id}, {$product}, {$qty}, {$cost})";
                $result = $connection->query($sql);
                if (!$result) {
                }
            }
        }
    }
        header("Location: ".$_SESSION['current_page']."?add=success");
        exit();
    }
    else {
        header("Location: ../index.php");
        exit();
    }

    function get_bag($connection) {
        $sql = "SELECT * FROM bags WHERE account_id = ".$_SESSION['account_id']." AND active=1 LIMIT 1";
        $result = $connection->query($sql);
        //  create new bag_id
        if ($result->num_rows == 0)
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
<?php
    session_start();
    //  ensure that script is being accessed through post method
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        require 'database_handler.php';
        $sql = "SELECT product_id FROM products";   //  select just the product id from products table
        $result = $connection->query($sql);
        while($row = $result->fetch_assoc()) {
            $product[] = (int)$row['product_id'];   //  add product_id to product array as int
        }                                           
        $connection->close();                       //  close database

        //  loop through text inputs to ensure that the user only entered non-negative integers
        foreach($product as $test) {
            if (isset($_POST[(string)$test])) {
                $qty = $_POST[$test];
                if (!is_numeric($qty) && $qty >=0 ) {
                    //  return to bag and display error message
                    header("Location: /CMSProject1/bag.php?error=invalidentry");
                    exit();
                }
            }
        }

        unset($_SESSION['bag']);                   //  clear the bag
        
        //  loop through inputs and rebuild bag with updated item quantities
        foreach($product as $product) {     
            
            if (isset($_POST[(string)$product])) {
                $qty = $_POST[$product];
                $x = 0;
                while ($x < $qty) {
                    $_SESSION['bag'][] = (int)$product;
                    $x++;
                }
            }
        }
        //  return to bag
        header("Location: /CMSProject1/bag.php");
        exit();
    }
    //  if user did not access the script through post method, send back to index
    header("Location: /CMSProject1/index.php"]);
    exit();
?>
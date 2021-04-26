<?php
    /*
        updatebag.php
        Daniel Shupe
        CSIS 410
        This script will update the bag after a user changes quantities.
    */
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
        //$connection->close();                       //  close database

        //  loop through text inputs to ensure that the user only entered non-negative integers
        foreach($product as $test) {
            if (isset($_POST[(string)$test])) {
                $qty = $_POST[$test];
                if (!is_numeric($qty) || $qty < 0 ) {
                    //  return to bag and display error message
                    header("Location: ../bag.php?error=invalidentry");
                    exit();
                }
            }
        }
        
        //  loop through inputs and rebuild bag with updated item quantities
        foreach($product as $product) {         
            if (isset($_POST[(string)$product])) {
                $qty = $_POST[$product];
                $sql = "UPDATE bag_products SET quantity=? WHERE bag_id=? AND product_id=?";
                $stmt = $connection->prepare($sql);
                if ($stmt->bind_param("iii",$qty,$_SESSION['bag_id'],$product)){
                    $stmt->execute();
                }
            }
        }

        //  return to bag
        header("Location: ../bag.php?success=yes");
        exit();
    }
    //  if user did not access the script through post method, send back to index
    header("Location: ../index.php");
    exit();
?>


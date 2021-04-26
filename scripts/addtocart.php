<?php
    //  check to see if script was reached via post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require 'database_handler.php';
        session_start();
        $item = $_POST['item'];
        
        //  select statement using product_id from post
        $sql = "SELECT * FROM products WHERE product_id=?";
        $stmt = mysqli_stmt_init($connection);              //  prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ".$page."?error=invalidentry");
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
            
                $_SESSION['bag'][] = $product; //  add product to bag
        }
        header("Location: ".$_SESSION['current_page']);
    }
?>
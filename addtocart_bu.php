<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        require 'database_handler.php';
        $item = $_GET['item'];
        var_dump($item);
        $sql = "SELECT product_id FROM products";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while ($id = $result->fetch_assoc()) {
                $i = $id['product_id'];
                $item = "'".$i."'";
                var_dump($i);
                if (isset($_POST[$item])) {
                    var_dump($item);
                }
            }
        }
        $sql = "SELECT * FROM products WHERE product_id=?";
        $stmt = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ".$page."?error=invalidentry");
            exit();
        }
        else {
            $item = str_replace("'","",$item);
            mysqli_stmt_bind_param($stmt, "i", $item);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $sql = "SELECT * FROM products WHERE product_id=$item";
            var_dump($user);
            var_dump($sql);
            var_dump($stmt);
        }
        /*require 'database_handler.php';
        $result2 = $connection->query($sql2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {

            }
        }*/
    }
?>
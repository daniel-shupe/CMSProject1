<?php
    session_start();
    require 'database_handler.php';
    //  content management should only be accessible if user is logged in as an admin or publisher
    if ($_SERVER['REQUEST_METHOD'] == "POST" && ($_SESSION['access'] == "Publisher" || $_SESSION['access'] == "Admin")) {
        //  handle new buttons
        if (isset($_POST['new'])) {
            $_SESSION['manage_type'] = 'new';
            $_SESSION['table'] = $_POST['table'];
            header("Location: ../content_form.php");
            exit();
        }
        //  handle edit buttons
        else if (isset($_POST['record'])) {
            $edit_str = 'edit'.$_POST['record'];
            $delete_str = 'delete'.$_POST['record'];
            
            if (isset($_POST[$edit_str])) {
                $_SESSION['manage_type'] = 'edit';
                $_SESSION['table'] = $_POST['table'];
                $_SESSION['record'] = $_POST['record'];
                //  edit button for news
                if ($_POST['table'] == 'news') {
                    $_SESSION['title'] = $_POST['title'];
                    $_SESSION['post'] = $_POST['post'];
                }
                //  edit button for products
                else if ($_POST['table'] == 'products') {
                    $_SESSION['name'] = $_POST['name'];
                    $_SESSION['short_description'] = $_POST['short_description'];
                    $_SESSION['long_description'] = $_POST['long_description'];
                    $_SESSION['price'] = $_POST['price'];
                    $_SESSION['image'] = $_POST['image'];
                    $_SESSION['content_type_id'] = $_POST['content_type_id'];
                }
                header("Location: ../content_form.php");
                exit();
            }
            //  handle delete buttons (handles news, products, and accounts)
            if (isset($_POST[$delete_str])) {
                $_SESSION['manage_type'] = 'delete';
                $_SESSION['table'] = $_POST['table'];
                $_SESSION['record'] = $_POST['record'];
                header("Location: ../content_form.php");
                exit();
            }
        }
        //  handle update buttons
        if (isset($_POST['update'])) {
            //  update a record in the news table
            if ($_POST['table'] == "news") {
                unset($_SESSION['title']);
                unset($_SESSION['post']);
                $sql = "UPDATE ".$_POST['table']." SET post_title = ?, post_content = ? WHERE ".$_POST['table']."_id = ?";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt,$sql)) {

                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssi", $_POST['title'], $_POST['post'], $_POST['record']);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../".$_POST['table'].".php");
                    exit();
                }
            }
            //  update a record in the product table
            else if ($_POST['table'] == "products") {
                validate_product($_POST);
                unset($_SESSION['title']);
                unset($_SESSION['post']);
                $sql = "UPDATE ".$_POST['table']." SET name = ?, image = ?, price = ?, short_description = ?, long_description = ?, content_type_id = ? WHERE product_id = ?";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt,$sql)) {

                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssdssii", $_POST['name'], $_POST['image'], $_POST['price'], $_POST['short_description'], $_POST['long_description'], $_POST['content_type_id'], $_POST['record']);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../".$_POST['table'].".php");
                    exit();
                }
            }
            unset($_SESSION['manage_type']);
            unset($_SESSION['table']);
            unset($_SESSION['record']);
        }
        //  handle add buttons
        if (isset($_POST['add'])) {
            //  insert into news table     
            if ($_POST['table'] == "news") {
                $sql = "INSERT INTO ".$_POST['table']." (post_title, post_content, account_id) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'something';
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssi", $_POST['title'], $_POST['post'], $_SESSION['account_id']);
                    mysqli_stmt_execute($stmt);                    
                header("Location: ../".$_POST['table'].".php?getting=here".$sql);
                exit();    
                }
            }
            //  insert into products table
            else if ($_POST['table'] == "products") {
                validate_product($_POST);
                $sql = "INSERT INTO ".$_POST['table']." (name, image, price, short_description, long_description, content_type_id) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo 'something';
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssdssi", $_POST['name'], $_POST['image'], $_POST['price'], $_POST['short_description'], $_POST['long_description'], $_POST['content_type_id']);
                    mysqli_stmt_execute($stmt);                
                }
            }
                unset($_SESSION['manage_type']);
                unset($_SESSION['table']);
                header("Location: ../".$_POST['table'].".php?getting=here".$sql);
                exit();
        }
        
        //  handle remove buttons
        if (isset($_POST['remove'])) {
            unset($_SESSION['manage_type']);
            unset($_SESSION['record']);
            unset($_SESSION['table']);
            $table_id = $_POST['table'];
            //  delete from non-news table
            if ($table_id != "news") {
                //  remove the s from the end of the table name to get the primary key
                $table_id = rtrim($table_id,'s');
            }
            $sql = "DELETE FROM ".$_POST['table']." WHERE ".$table_id."_id = ?";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {

            }
            //  delete from news table
            else {
                mysqli_stmt_bind_param($stmt, "i", $_POST['record']);
                mysqli_stmt_execute($stmt);
                header("Location: ../".$_POST['table'].".php");
                exit();
            }
        }
        //  cancel delete operation
        if (isset($_POST['no'])) {
            header("Location: ../".$_POST['table'].".php");
            exit();
        }
    }
    else {
        header("Location: ../index.php");
        exit();
    }

    //  validate user input for products
    function validate_product($entry) {
        $error = false;
        $error_str = "";
        $name_str = "&name=".$entry['name'];
        $image_str = "&image=".$entry['image'];
        $price_str = "&price=".$entry['price'];
        $ld_str = "&ld=".$entry['long_description'];
        $sd_str = "&sd=".$entry['short_description'];
        //  valid image extensions
        $image_type = array('gif','webm', 'jpg', 'png');
        $ext = strtolower(pathinfo($entry['image'], PATHINFO_EXTENSION));
        //  checks if name is null or outside of the length allowed by database
        if (!isset($entry['name']) || (strlen($entry['name']) == 0) || (strlen($entry['name']) > 255)) {
            $error = true;
            $error_str = "?error=invalidname".$price_str.$image_str.$ld_str.$sd_str;
        }
        //  checks if image is null or has an invalid extension
        else if (!isset($entry['image']) || (!in_array($ext, $image_type))) {
            $error = true;
            $error_str = "?error=invalidimage".$price_str.$name_str.$ld_str.$sd_str;
        }
        //  check if price is numeric and non-negative
        else if (!isset($entry['price']) || (!is_numeric($entry['price'])) || $entry['price'] < 0) {
            $error = true;
            $error_str = "?error=invalidprice".$name_str.$image_str.$ld_str.$sd_str;
        }
        //  checks if short_description is null or outside of the length allowed by database
        else if (!isset($entry['short_description']) || (strlen($entry['short_description']) == 0) || (strlen($entry['short_description']) > 255)) {
            $error = true;
            $error_str = "?error=invalidsd".$price_str.$image_str.$ld_str.$name_str;
        }
        //  checks if long_description is null or outside of the length allowed by database
        else if (!isset($entry['long_description']) || (strlen($entry['long_description']) == 0) || (strlen($entry['long_description']) > 65535)) {
            $error = true;
            $error_str = "?error=invalidld".$price_str.$image_str.$name_str.$sd_str;
        }
        //  if there was an error, send error message
        if ($error) {
            header("Location: ../content_form.php".$error_str);
            exit();
        }
    }
?>
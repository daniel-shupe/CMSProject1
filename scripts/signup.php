<?php
    if (isset($_POST['register'])) {
        require 'database_handler.php';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];
        $passwordcheck = $_POST['password_check'];
        $page = "/CMSProject1/register.php";

        //  check to ensure all fields are filled
        if (empty($username) || empty($email) || empty($first_name) || empty($last_name) || empty($password) || empty($passwordcheck)) {
            header("Location: " .$page ."?error=empty&username=" .$username ."&email=".$email."&first_name=".$first_name."&last_name=".$last_name);
            exit(); 
        }
        //  check to see if a valid email address was addes
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ".$page."?error=invalidemailaddress&username=".$username."&first_name=".$first_name."&last_name=".$last_name);
            exit();
        }
        //  check to see if username is properly formatted
        else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ".$page."?error=invalidusername&email=".$email."&first_name=".$first_name."&last_name=".$last_name);
            exit();
        }
        //  check to see if first/last name are properly formatted
        else if (!preg_match("/^[a-zA-Z]*$/", $first_name) || (!preg_match("/^[a-zA-Z]*$/", $last_name))) {
            header("Location: ".$page."?error=impropernameformat&username=".$username."&email=".$email);
            exit();
        }
        //  check to see if passwords match
        else if ($password != $passwordcheck) {
            header("Location: ".$page."error=passwordnomatch&username=".$username."&email=".$email."&first_name=".$first_name."&last_name=".$last_name);
            exit();
        }
        else {
            //  use prepared statement to search database for matching usernames/emails
            $sql = "SELECT account_id FROM accounts WHERE username=? OR email=?";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ".$page."?error=invalidentry");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $results = mysqli_stmt_num_rows($stmt);
                if ($results > 0) {
                    header("Location: ".$page."?error=alreadyexits");
                    exit();
                }
                //  if no other errors, insert new user into database with a prepared statement
                else {
                    $sql = "INSERT INTO accounts (username, email, first_name, last_name, password) VALUES (?, ?, ?, ?, ?)";
                    $sntmt = mysqli_stmt_init($connection);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ".$page."?error=invalidentry");
                        exit();
                    }
                    else {
                        //  hash password before inserting
                        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $first_name, $last_name, $password_hashed);
                        mysqli_stmt_execute($stmt);
                        header("Location: ".$page."?register=success");
                        exit();
                    }
                }
            }

        }
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
    }
    else {
        header("Location: /CMSProject1/register.php");
    }
?>
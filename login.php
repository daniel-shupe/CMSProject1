<?php
/*
    login.php
    Daniel Shupe
    CSIS 410
*/
    //  check if login button was used to access this page
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //  check if either username or password are empty
        if (empty($username) || empty($password)) {
            header("Location: ../signin.php?error=empty");
        } 
        else {
            require 'database_handler.php';
            //  prepared statement to see if there is a match with username or email
            $sql = "SELECT * FROM accounts WHERE username=? OR email=?";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt,$sql)) {

            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = $result->fetch_assoc()) {
                    //  check if password matches hashed password in database
                    $password_validate = password_verify($password, $row['password']);
                    if ($password_validate == false) {
                        header("Location: ../signin.php?error=invalidpass");
                        exit();
                    }
                    //  if password matches, log the user in
                    else if ($password_validate == true) {
                        session_start();
                        //  get access level description
                        $sql = "SELECT description FROM access_levels WHERE access_level_id=?";
                        $stmt = mysqli_stmt_init($connection);
                        if (!mysqli_stmt_prepare($stmt,$sql)) {

                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "i", $row['access_level_id']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                                if ($al = $result->fetch_assoc()) {
                                    $_SESSION['access'] = $al['description'];
                                }
                        $_SESSION['username'] = $row['username'];
                        if ($_SESSION['access'] != "Customer") {
                            $_SESSION['username'].=" (".$_SESSION['access'].")";
                        }
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['account_id'] = $row['account_id'];
                        $_SESSION['logged_in'] = true;
                        header("Location: " .$_SESSION['current_page']);
                        exit();
                        }
                    }
                }
                else {
                    header("Location: ../signin.php?error=usernotfound");
                    exit();
                }
            }
        }
    }
?>
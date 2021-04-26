<?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            header("Location: /CMSProject1/signin.php?error=empty");
        } 
        else {
            require 'database_handler.php';
            $sql = "SELECT * FROM accounts WHERE username=? OR email=?";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt,$sql)) {

            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = $result->fetch_assoc()) {
                    $password_validate = password_verify($password, $row['password']);
                    if ($password_validate == false) {
                        header("Location: /CMSProject1/signin.php?error=invalidpass");
                        exit();
                    }
                    else if ($password_validate == true) {
                        session_start();
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['access'] = $row['access_level_id'];
                        $_SESSION['logged_in'] = true;
                        header("Location: " .$_SESSION['current_page']);
                        exit();
                    }
                }
                else {
                    header("Location: /CMSProject1/signin.php?error=usernotfound");
                    exit();
                }
            }
        }
    }
        /*
            $result = $connection->query($sql);
            if (!$result) {
                trigger_error('Invalid query: ' . $connection->error);
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($pass == $row['password']) {
                        session_start();
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['access'] = $row['access_level_id'];
                        $_SESSION['logged_in'] = true; 
                        echo 'logged in successfully';
                        $connection->close();
                        header("Location: ". $_SESSION['current_page']);
                    }
                    else {
                        $error[] = "Username/password combination does not match.";
                    }
                }
            }
            else {
                $error[] = "User not found.";
            }
        }
        else {
            header("Location: /CMSProject1/signin.php?errors={$error}");
        }
        header("Location: /CMSProject1/signin.php?errors={$error}");
    }
    else
    {
        header("Location: ". $_SESSION['current_page']); ///CMSProject1/index.php");
        exit();
    }

    function test(string $temp) {
        $temp = trim($temp);
        $temp = stripslashes($temp);
        $temp = htmlspecialchars($temp);
        return $temp;
    }*/
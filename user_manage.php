<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    if (isset($_POST['delete'])) {
        $_SESSION['record'] = $_POST['account_id'];
        $_SESSION['table'] = 'accounts';
        $_SESSION['manage_type'] = 'delete';
        header("Location: ../content_form.php");
        exit();
    }
    else if (isset($_POST['new'])) {
        header("Location: ../register.php");
        exit();
    }
    else if (isset($_POST['edit'])) {
        $_SESSION['record'] = $_POST['account_id'];
        $_SESSION['table'] = 'accounts';
        $_SESSION['manage_type'] = 'edit';
        require_once 'database_handler.php';
        $sql = "SELECT username, access_level_id FROM accounts WHERE account_id = ".$_SESSION['record'];
        $result = $connection->query($sql);
        if (!$result) {
            trigger_error('Invalid query: ' . $connection->error);
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_edit'] = $row['username'];
                $_SESSION['selected_access'] = $row['access_level_id'];
            }
        }
        header("Location: ../content_form.php");
        exit();
    }
    else if (isset($_POST['update'])) {
        $record = $_SESSION['record'];
        unset($_SESSION['record']);
        unset($_SESSION['manage_type']);
        unset($_SESSION['user_edit']);
        require_once 'database_handler.php';
        $sql = "UPDATE accounts SET access_level_id = ".$_POST['access_level_id']." WHERE account_id = ".$record;
        $result = $connection->query($sql);
        if (!$result) {
            trigger_error('Invalid query: ' . $connection->error);
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_edit'] = $row['username'];
                $_SESSION['selected_access'] = $row['access_level_id'];
            }
        }
        header("Location: ../accounts.php?update=success");
        exit();
    }

}
?>